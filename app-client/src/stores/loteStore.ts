import { defineStore } from 'pinia'
import type { ILote } from '@/interfaces/Lote/ILote'
import loteService from '@/services/loteService'

export const useloteStore = defineStore('loteStore', {
    state: () => ({
        lotes: [] as ILote[],
        loading: false
    }),

    actions: {
        async buscarLotes() {
            try {
                this.loading = true
                const { data } = await loteService.getAll()
                this.lotes = data
            } catch (error) {
                console.error('Erro ao buscar lotes:', error)
            } finally {
                this.loading = false
            }
        },

        async salvarLote(lote: ILote) {
            try {
                await loteService.create(lote)
                await this.buscarLotes()
            } catch (error) {
                console.error('Erro ao salvar lote:', error)
                throw error
            }
        },

        async atualizarlote(lote: ILote) {
            if (!lote.id) return
            try {
                await loteService.update(lote)
                await this.buscarLotes()
            } catch (error) {
                console.error('Erro ao atualizar lote:', error)
                throw error
            }
        },

        async excluirLote(id: number) {
            try {
                await loteService.delete(id)
                this.lotes = this.lotes.filter(l => l.id !== id)
            } catch (error) {
                console.error('Erro ao excluir lote:', error)
                throw error
            }
        }
    }
})
