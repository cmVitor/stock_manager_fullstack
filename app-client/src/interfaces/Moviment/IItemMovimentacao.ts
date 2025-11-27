export interface IItemMovimentacao {
  produtoId: string
  fornecedorId: string
  fornecedorNome?: string
  produtoNome?: string
  loteId: string
  loteDescricao: string
  validade?: string
  quantidade: number
  preco: number | string
}