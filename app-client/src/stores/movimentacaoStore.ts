import { defineStore } from 'pinia'
import { useEstoqueStore } from './estoqueStore'
import MovimentacaoService from '@/services/movimentacaoService'
import type { IMovimentacao } from '@/interfaces/Moviment/IMovimentacao'

export const useMovimentacaoStore = defineStore('movimentacao', {
  state: () => ({
    movimentacoes: [] as IMovimentacao[],
    loading: false,
  }),

  actions: {
    async buscarMovimentacoes() {
      try {
        this.loading = true
        const { data } = await MovimentacaoService.buscarMovimentacoes()
        this.movimentacoes = data
      } catch (error) {
        console.error('Erro ao buscar movimentações:', error)
      } finally {
        this.loading = false
      }
    },

    async salvarMovimentacao(mov: IMovimentacao) {
      try {
        await MovimentacaoService.salvarMovimentacao(mov)

        const estoqueStore = useEstoqueStore()
        await estoqueStore.carregarEstoque()

        await this.buscarMovimentacoes()
      } catch (error) {
        console.error('Erro ao salvar movimentação:', error)
        throw error
      }
    },


  },
})
