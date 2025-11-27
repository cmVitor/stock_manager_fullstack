import api from './api'
import type { IProduto } from '@/interfaces/Product/IProduto'

export default {
    getAll() {
        return api.get('/produtos')
    },

    create(produto: IProduto) {
        return api.post('/produtos', produto)
    },

    update(produto: IProduto) {
        return api.put(`/produtos/${produto.id}`, produto)
    },

    delete(id: string) {
        return api.delete(`/produtos/${id}`)
    }
}
