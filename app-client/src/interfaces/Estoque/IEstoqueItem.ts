export interface IEstoqueItem {
  id: number
  produtoId: string
  produtoNome: string
  lote: string
  validade: string
  saldo: number
  quantidadeMinima: number
  diasParaVencer?: number
  expirado?: boolean
  pertoDeVencer?: boolean
  estoqueCritico?: boolean
}