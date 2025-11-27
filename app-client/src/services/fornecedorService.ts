import api from './api'
import type { IFornecedor } from '@/interfaces/Fornecedor/IFornecedor'

export default {
    buscarFornecedores() {
        return api.get('/fornecedores')
    },

    adicionarFornecedor(fornecedor: IFornecedor) {
        return api.post('/fornecedores', fornecedor)
    },

    atualizarFornecedor(fornecedor: IFornecedor) {
        return api.put(`/fornecedores/${fornecedor.id}`, fornecedor)
    },

    excluirFornecedor(id: number) {
        return api.delete(`/fornecedores/${id}`)
    }
}
