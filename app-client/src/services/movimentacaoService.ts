import api from './api'
import type { IMovimentacao } from '@/interfaces/Moviment/IMovimentacao'

export default {
    buscarMovimentacoes() {
        return api.get('/movements')
    },

    salvarMovimentacao(mov: IMovimentacao) {
        return api.post('/movements', mov)
    }
}
