import api from './api'

export default {
    getEstados() {
        return api.get('/estados')
    },

    getCidades(siglaEstado: string) {
        return api.get(`/cidades/${siglaEstado}`)
    }
}
