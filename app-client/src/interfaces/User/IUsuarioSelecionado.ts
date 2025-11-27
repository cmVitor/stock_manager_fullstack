export interface IUsuarioSelecionado {
  id?: number
  nome: string
  email: string
  cpf: string
  senha?: string
  cargo: string
  estado: string
  estado_uf: string
  cidade: string
  cidade_id: number | null
  bairro: string,
  complemento: string
  cep: string
  logradouro: string
  numero: string
}