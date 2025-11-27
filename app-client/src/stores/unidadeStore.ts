import { defineStore } from 'pinia'
import type { IUnidade } from '@/interfaces/Unidade/IUnidade'
import unidadeService from '@/services/unidadeService'

export const useUnidadeStore = defineStore('unidadeStore', {
    state: () => ({
        unidades: [] as IUnidade[],
        loading: false
    }),

    actions: {
        async buscarUnidades() {
            try {
                this.loading = true
                const { data } = await unidadeService.getAll()
                this.unidades = data
            } catch (error) {
                console.error('Erro ao buscar unidades:', error)
            } finally {
                this.loading = false
            }
        }
    }
})
