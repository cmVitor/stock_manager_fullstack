import { defineStore } from 'pinia'
import type { ICategoria } from '@/interfaces/Categoria/ICategoria'
import categoriaService from '@/services/categoriaService'

export const useCategoriaStore = defineStore('categoriaStore', {
    state: () => ({
        categorias: [] as ICategoria[],
        loading: false,
    }),

    actions: {
        async buscarCategorias() {
            try {
                this.loading = true
                const { data } = await categoriaService.getAll()
                this.categorias = data
            } catch (error) {
                console.error('Erro ao buscar categorias:', error)
            } finally {
                this.loading = false
            }
        },

        async atualizarCategoria(categoria: ICategoria) {
            try {
                await categoriaService.update(categoria)
                await this.buscarCategorias()
            } catch (error) {
                console.error('Erro ao salvar categoria', error)
            }
        },

        async salvarCategoria(categoria: ICategoria) {
            if (!categoria.nome) {
                console.error('Nome é obrigatório.')
                return
            }
            try {
                await categoriaService.create(categoria)
                await this.buscarCategorias()
            } catch (error) {
                console.error('Erro ao salvar categoria:', error)
            }
        },

        async excluirCategoria(id: number) {
            try {
                await categoriaService.delete(id)
                await this.buscarCategorias()
            } catch (error) {
                console.error('Erro ao excluir categoria', error)
            }
        }
    }
})
