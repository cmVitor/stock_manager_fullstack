// services/unidadeService.ts
import api from './api'

export default {
    getAll() {
        return api.get('/unidades')
    }
}
