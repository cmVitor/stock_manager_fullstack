export interface IFornecedor {
    id?: number
    nome: string
    contato: string
    email: string
    estado: string
    cidade: string
    cidade_id: number | null
    bairro: string
    complemento: string
    cep: string
    logradouro: string
    numero: string
}