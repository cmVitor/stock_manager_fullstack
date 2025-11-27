import { defineStore } from 'pinia'
import { useloteStore } from './loteStore'
import { useProductStore } from './productStore'
import EstoqueService from '@/services/estoqueService'
import type { IEstoqueItem } from '@/interfaces/Estoque/IEstoqueItem'

export const useEstoqueStore = defineStore('estoque', {
  state: () => ({
    estoque: [] as IEstoqueItem[],
    loading: false as boolean,
  }),

  getters: {
    estoqueFormatado: (state): IEstoqueItem[] => {
      return state.estoque.map(item => ({
        ...item,
        validadeFormatada: new Date(item.validade).toLocaleDateString()
      }))
    },

    totalEstoqueCritico(): number {
      return this.estoqueFormatado.filter(i => i.estoqueCritico).length
    },

    totalPertoDeVencer(): number {
      return this.estoqueFormatado.filter(i => i.pertoDeVencer && !i.expirado).length
    },
  },

  actions: {
    async carregarEstoque() {
      this.loading = true
      try {
        // Busca estoque (via service)
        const { data } = await EstoqueService.carregarEstoque()
        this.estoque = data

        // Busca lotes e produtos
        const loteStore = useloteStore()
        const produtoStore = useProductStore()

        if (loteStore.lotes.length === 0) {
          await loteStore.buscarLotes()
        }

        if (produtoStore.produtos.length === 0) {
          await produtoStore.buscarProdutos()
        }

        // Atualiza validade e quantidade mínima conforme dados reais
        this.estoque = this.estoque.map(item => {
          const loteEncontrado = loteStore.lotes.find(l => l.descricao === item.lote)
          const produtoEncontrado = produtoStore.produtos.find(p => p.id === item.produtoId)

          return {
            ...item,
            validade: loteEncontrado?.dataValidade || item.validade,
            quantidadeMinima: produtoEncontrado?.quantidadeMinima || item.quantidadeMinima || 0
          }
        })
      } catch (error) {
        console.error('Erro ao carregar estoque:', error)
      } finally {
        this.loading = false
      }
    },
  },
})
