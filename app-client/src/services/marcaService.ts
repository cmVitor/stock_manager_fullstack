import api from './api'
import type { IMarca } from '@/interfaces/Marca/IMarca'

export default {
    getAll(page: number, perPage: number, search = '') {
        return api.get('/marcas', {
            params: { page, per_page: perPage, search }
        })
    },

    update(marca: IMarca) {
        return api.put(`/marcas/${marca.id}`, marca)
    },

    create(marca: IMarca) {
        return api.post('/marcas', marca)
    },

    delete(id: number) {
        return api.delete(`/marcas/${id}`)
    }
}
