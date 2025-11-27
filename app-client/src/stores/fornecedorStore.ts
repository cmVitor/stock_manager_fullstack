import { defineStore } from 'pinia'
import type { IFornecedor } from '@/interfaces/Fornecedor/IFornecedor'
import FornecedorService from '@/services/fornecedorService'

export const useFornecedorStore = defineStore('fornecedor', {
    state: () => ({
        fornecedores: [] as IFornecedor[],
        loading: false,
    }),

    actions: {
        async buscarFornecedores() {
            try {
                this.loading = true
                const { data } = await FornecedorService.buscarFornecedores()
                this.fornecedores = data
            } catch (error) {
                console.error('Erro ao buscar fornecedores:', error)
            } finally {
                this.loading = false
            }
        },

        async adicionarFornecedor(fornecedor: IFornecedor) {
            if (!fornecedor.nome || !fornecedor.contato) {
                console.error('Nome e contato são obrigatórios.')
                return
            }
            try {
                await FornecedorService.adicionarFornecedor(fornecedor)
                await this.buscarFornecedores()
            } catch (error) {
                console.error('Erro ao adicionar fornecedor:', error)
                console.log(fornecedor)
            }
        },

        async atualizarFornecedor(fornecedor: IFornecedor) {
            if (!fornecedor.id) return
            try {
                await FornecedorService.atualizarFornecedor(fornecedor)
                await this.buscarFornecedores()
            } catch (error) {
                console.error('Erro ao atualizar fornecedor:', error)
                console.log(fornecedor)
            }
        },

        async excluirFornecedor(id: number) {
            try {
                await FornecedorService.excluirFornecedor(id)
                await this.buscarFornecedores()
            } catch (error) {
                console.error('Erro ao excluir fornecedor:', error)
            }
        },
    }
})
