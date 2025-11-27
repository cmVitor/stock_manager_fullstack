import { defineStore } from 'pinia'
import type { IMarca } from '@/interfaces/Marca/IMarca'
import marcaService from '@/services/marcaService'

export const useMarcaStore = defineStore('marcaStore', {
    state: () => ({
        marcas: [] as IMarca[],
        loading: false,
        search: '',
        pagination: {
            current_page: 1,
            last_page: 1,
            per_page: 10,
            total: 0
        }
    }),

    actions: {
        async buscarMarcas(page = 1) {
            try {
                this.loading = true

                const { data } = await marcaService.getAll(page, this.pagination.per_page, this.search)

                this.marcas = data.data
                this.pagination = {
                    current_page: data.meta.current_page,
                    last_page: data.meta.last_page,
                    per_page: data.meta.per_page,
                    total: data.meta.total
                }

            } catch (error) {
                console.error('Erro ao buscar marcas:', error)
            } finally {
                this.loading = false
            }
        },

        async setSearch(value: string) {
            this.search = value
            await this.buscarMarcas(1) // volta pra página 1 ao filtrar
        },

        async atualizarMarca(marca: IMarca) {
            try {
                await marcaService.update(marca)
                await this.buscarMarcas()
            } catch (error) {
                console.error('Erro ao atualizar marca:', error)
            }
        },

        async salvarMarca(marca: IMarca) {
            if (!marca.nome) {
                console.error('Nome é obrigatório.')
                return
            }
            try {
                await marcaService.create(marca)
                await this.buscarMarcas()
            } catch (error) {
                console.error('Erro ao salvar marca:', error)
            }
        },

        async excluirMarca(id: number) {
            try {
                await marcaService.delete(id)
                await this.buscarMarcas()
            } catch (error) {
                console.error('Erro ao excluir marca:', error)
            }
        }
    }
})
