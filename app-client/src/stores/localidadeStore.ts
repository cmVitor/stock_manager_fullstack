import { defineStore } from 'pinia'
import type { IEstado } from '@/interfaces/Localidade/IEstado'
import type { ICidade } from '@/interfaces/Localidade/ICidade'
import localidadeService from '@/services/localidadeService'

export const useLocalidadeStore = defineStore('localidade', {
    state: () => ({
        estados: [] as IEstado[],
        cidades: [] as ICidade[],
        loadingEstados: false,
        loadingCidades: false,
    }),

    actions: {
        async buscarEstados() {
            try {
                if (this.estados.length > 0) return

                this.loadingEstados = true
                const { data } = await localidadeService.getEstados()

                this.estados = data.map((estado: any) => ({
                    nome: estado.nome,
                    uf: estado.uf
                }))
            } catch (error) {
                console.error('Erro ao carregar estados:', error)
            } finally {
                this.loadingEstados = false
            }
        },

        async buscarCidades(siglaEstado: string) {
            try {
                this.loadingCidades = true
                this.cidades = []

                const { data } = await localidadeService.getCidades(siglaEstado)

                this.cidades = data.map((cidade: any) => ({
                    id: cidade.id,
                    name: cidade.name
                }))
            } catch (error) {
                console.error('Erro ao carregar cidades:', error)
            } finally {
                this.loadingCidades = false
            }
        },
    },
})
