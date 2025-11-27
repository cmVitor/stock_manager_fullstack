import api from './api'

export default {
  carregarEstoque() {
    return api.get('/estoque')
  }
}
