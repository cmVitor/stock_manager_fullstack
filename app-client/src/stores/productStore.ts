import { defineStore } from 'pinia'
import type { IProduto } from '@/interfaces/Product/IProduto'
import produtoService from '@/services/produtoService'

export const useProductStore = defineStore('product', {
    state: () => ({
        produtos: [] as IProduto[],
        loading: false
    }),

    actions: {
        async buscarProdutos() {
            try {
                this.loading = true
                const { data } = await produtoService.getAll()
                this.produtos = data
            } catch (error) {
                console.error('Erro ao buscar produtos:', error)
            } finally {
                this.loading = false
            }
        },

        async atualizarProduto(produto: IProduto) {
            try {
                await produtoService.update(produto)
                await this.buscarProdutos()
            } catch (error) {
                console.error('Erro ao salvar produto:', error)
            }
        },

        async salvarProduto(produto: IProduto) {
            if (!produto.nome || !produto.codigo) {
                console.error('Nome e código são obrigatórios.')
                return
            }
            try {
                await produtoService.create(produto)
                await this.buscarProdutos()
            } catch (error) {
                console.error('Erro ao salvar produto:', error)
            }
        },

        async excluirProduto(id: string) {
            try {
                await produtoService.delete(id)
                await this.buscarProdutos()
            } catch (error) {
                console.error('Erro ao excluir produto:', error)
            }
        }
    }
})
