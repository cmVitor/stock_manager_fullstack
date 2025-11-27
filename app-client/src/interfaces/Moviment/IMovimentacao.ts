import type { IItemMovimentacao } from "./IItemMovimentacao"

export interface IMovimentacao {
  id?: string
  tipo: 'E' | 'S'
  data: string
  funcionarioId: number | null
  itens: IItemMovimentacao[]
}
