import api from './api'
import type { ICategoria } from '@/interfaces/Categoria/ICategoria'

export default {
    getAll() {
        return api.get('/categorias')
    },

    update(categoria: ICategoria) {
        return api.put(`/categorias/${categoria.id}`, categoria)
    },

    create(categoria: ICategoria) {
        return api.post('/categorias', categoria)
    },

    delete(id: number) {
        return api.delete(`/categorias/${id}`)
    }
}
