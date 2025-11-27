import api from './api'
import type { ILote } from '@/interfaces/Lote/ILote'

export default {
    getAll() {
        return api.get('/lotes')
    },

    create(lote: ILote) {
        return api.post('/lotes', lote)
    },

    update(lote: ILote) {
        return api.put(`/lotes/${lote.id}`, lote)
    },

    delete(id: number) {
        return api.delete(`/lotes/${id}`)
    }
}
