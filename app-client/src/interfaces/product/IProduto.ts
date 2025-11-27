import type { IInformacaoNutricional } from "../InformacaoNutricinal/IInformacaoNutricional"

export interface IProduto {
    id?: string
    codigo: string
    nome: string
    marca: string | number | null
    categoria: string | number | null
    informacaoNutricional: IInformacaoNutricional
    quantidadeMinima: number 
    perecivel: boolean
    unidadeMedida: string | number | null
}