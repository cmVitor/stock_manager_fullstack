<template>
  <v-container class="py-6">
    <v-card elevation="6">
      <v-card-title class="text-h5">Lista de Produtos</v-card-title>
      <v-divider></v-divider>

      <v-card-text>Filtros</v-card-text>

      <!-- Filtros -->
      <v-row class="pa-2" dense>
        <v-col cols="12" sm="4">
          <v-text-field v-model="filtros.nome" label="Filtrar por nome" clearable rounded variant="outlined" />
        </v-col>

        <v-col cols="12" sm="4">
          <v-select v-model="filtros.categoria" :items="categorias" item-title="nome" label="Filtrar por categoria"
            clearable rounded variant="outlined" />
        </v-col>
        <v-col cols="12" sm="4">
          <v-select v-model="filtros.marca" :items="marcas" item-title="nome" label="Filtrar por marca" clearable
            rounded variant="outlined" />
        </v-col>
      </v-row>

      <!-- Tabela -->
      <v-data-table :headers="headers" :items="produtosFiltrados" :loading="loading" class="elevation-1" item-value="id"
        hover no-data-text="Nenhum produto cadastrado">
        <template v-slot:item="{ item }">
          <tr>
            <td>{{ item.codigo }}</td>
            <td>{{ item.nome }}</td>
            <td>{{ item.marca }}</td>
            <td>{{ item.categoria }}</td>
            <td>
              <v-chip :color="item.perecivel ? 'red' : 'green'" text-color="white" size="small">
                {{ item.perecivel ? 'Perecível' : 'Não Perecível' }}
              </v-chip>
            </td>
            <td>{{ item.quantidadeMinima }}</td>
            <td>
              <v-btn icon variant="text" color="blue" @click="abrirEdicao(item)">
                <v-icon>mdi-pencil</v-icon>
              </v-btn>
              <v-btn icon variant="text" color="red" @click="abrirDialogExcluir(item)">
                <v-icon>mdi-delete</v-icon>
              </v-btn>
            </td>
          </tr>
        </template>
      </v-data-table>
    </v-card>

    <!-- Dialog de Edição -->
    <v-dialog v-model="dialogEdicao" max-width="600px">
      <v-card>
        <v-card-title>Edição de Produto</v-card-title>
        <v-divider></v-divider>

        <v-card-text>
          <v-form ref="formEdicao" v-model="formValido">
            <v-text-field variant="outlined" rounded v-model="produtoEditando.codigo" label="Código"
              prepend-inner-icon="mdi-barcode" required />
            <v-text-field variant="outlined" rounded v-model="produtoEditando.nome" label="Nome"
              prepend-inner-icon="mdi-tag" required />
            <v-select variant="outlined" rounded v-model="produtoEditando.marca" :items="marcas" item-title="nome"
              item-value="id" label="Marca" prepend-inner-icon="mdi-ticket-confirmation" required />
            <v-select variant="outlined" rounded v-model="produtoEditando.categoria" :items="categorias"
              item-title="nome" item-value="id" label="Categoria" prepend-inner-icon="mdi-shape" required />
            <v-switch v-model="produtoEditando.perecivel" label="Perecível" prepend-icon="mdi-alert-circle-outline" />
            <v-btn color="#7f2ec5" variant="outlined" block prepend-icon="mdi-food-variant"
              @click="abrirDialogNutricional" class="mb-8">
              Informações Nutricionais
            </v-btn>
            <v-row>
              <v-col cols="12" sm="6">
                <v-text-field variant="outlined" rounded v-model.number="produtoEditando.quantidadeMinima"
                  label="Quantidade Mínima" type="number" prepend-inner-icon="mdi-counter" required min="0" />
              </v-col>
              <v-col cols="12" sm="6">
                <v-select variant="outlined" rounded v-model="produtoEditando.unidadeMedida" :items="unidades"
                  item-title="nome" item-value="id" label="Unidade de Medida" prepend-inner-icon="mdi-shape" required />
              </v-col>
            </v-row>
          </v-form>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn text @click="fecharDialogo">Cancelar</v-btn>
          <v-btn color="primary" :disabled="!formValido" @click="salvarEdicao">
            Salvar
          </v-btn>
        </v-card-actions>
      </v-card>
      <!-- Dialog de Informações Nutricionais -->
      <v-dialog v-model="dialogInfoNutricional" max-width="600px">
        <v-card>
          <v-card-title>Informações Nutricionais</v-card-title>
          <v-divider></v-divider>
          <v-card-text>
            <v-form ref="formInfo">
              <v-row>
                <v-col cols="12">
                  <v-text-field v-model="infoNutricional.ingredientes" label="Ingredientes" variant="outlined" rounded
                    prepend-inner-icon="mdi-noodles" />
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" sm="6">
                  <v-text-field v-model="infoNutricional.alergenicos" label="Alérgenos" variant="outlined" rounded
                    prepend-inner-icon="mdi-peanut-off-outline" />
                </v-col>
                <v-col cols="12" sm="6">
                  <v-text-field v-model="infoNutricional.porcao" label="Porção" variant="outlined" rounded
                    prepend-inner-icon="mdi-food-takeout-box-outline" />
                </v-col>

                <v-col cols="12" sm="6">
                  <v-text-field v-model.number="infoNutricional.calorias" label="Calorias (kcal)" type="number"
                    variant="outlined" rounded prepend-inner-icon="mdi-nutrition" />
                </v-col>
                <v-col cols="12" sm="6">
                  <v-text-field v-model.number="infoNutricional.proteinas" label="Proteínas (g)" type="number"
                    variant="outlined" rounded prepend-inner-icon="mdi-food-drumstick" />
                </v-col>

                <v-col cols="12" sm="6">
                  <v-text-field v-model.number="infoNutricional.carboidratos" label="Carboidratos (g)" type="number"
                    variant="outlined" rounded prepend-inner-icon="mdi-barley" />
                </v-col>
                <v-col cols="12" sm="6">
                  <v-text-field v-model.number="infoNutricional.gorduras" label="Gorduras Totais (g)" type="number"
                    variant="outlined" rounded prepend-inner-icon="mdi-scale" />
                </v-col>

                <v-col cols="12" sm="6">
                  <v-text-field v-model.number="infoNutricional.sodio" label="Sódio (mg)" type="number"
                    variant="outlined" rounded prepend-inner-icon="mdi-shaker" />
                </v-col>
                <v-col cols="12" sm="6">
                  <v-text-field v-model.number="infoNutricional.acucares" label="Açúcares (g)" type="number"
                    variant="outlined" rounded prepend-inner-icon="mdi-spoon-sugar" />
                </v-col>
              </v-row>
            </v-form>
          </v-card-text>

          <v-card-actions>
            <v-spacer />
            <v-btn text color="grey" @click="dialogInfoNutricional = false">Cancelar</v-btn>
            <v-btn color="primary" @click="salvarInfoNutricional">Salvar</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-dialog>

    <!-- Dialog de Exclusão -->
    <v-dialog v-model="dialogExcluir" max-width="400px">
      <v-card>
        <v-card-title class="text-h6 font-weight-bold">Excluir Produto</v-card-title>
        <v-card-text>
          Tem certeza que deseja excluir o produto
          <strong>{{ produtoSelecionado?.nome }}</strong>?
        </v-card-text>
        <v-card-actions>
          <v-spacer />
          <v-btn variant="text" color="grey" @click="dialogExcluir = false">Cancelar</v-btn>
          <v-btn variant="elevated" color="red" @click="confirmarExclusao">Excluir</v-btn>
        </v-card-actions>
      </v-card>7
    </v-dialog>
  </v-container>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import { useProductStore } from '@/stores/productStore'
import type { IProduto } from '@/interfaces/Product/IProduto'
import { useCategoriaStore } from '@/stores/categoriaStore'
import { useMarcaStore } from '@/stores/marcaStore'
import { useUnidadeStore } from '@/stores/unidadeStore'

interface InfoNutricional {
  ingredientes: string
  alergenicos: string
  porcao: string
  calorias: number | null
  proteinas: number | null
  carboidratos: number | null
  gorduras: number | null
  sodio: number | null
  acucares: number | null
}

export default defineComponent({
  name: 'ProductTable',

  data() {
    return {
      dialogEdicao: false,
      dialogExcluir: false,
      formValido: false,
      produtoEditando: {} as IProduto,
      produtoSelecionado: null as IProduto | null,
      dialogInfoNutricional: false,
      infoNutricional: {
        ingredientes: '',
        alergenicos: '',
        porcao: '',
        calorias: null,
        proteinas: null,
        carboidratos: null,
        gorduras: null,
        sodio: null,
        acucares: null
      } as InfoNutricional,
      filtros: {
        nome: '',
        categoria: '',
        marca: ''
      },
      categoriaStore: useCategoriaStore(),
      marcaStore: useMarcaStore(),
      useUnidadeStore: useUnidadeStore(),
      headers: [
        { title: 'Código', key: 'codigo' },
        { title: 'Nome', key: 'nome' },
        { title: 'Marca', key: 'marca' },
        { title: 'Categoria', key: 'categoria' },
        { title: 'Status', key: 'perecivel' },
        { title: 'Quantidade Mínima', key: 'quantidadeMinima' },
        { title: 'Ações', key: 'acoes', sortable: false }
      ],
    }
  },

  computed: {
    productStore() {
      return useProductStore()
    },

    produtos() {
      return this.productStore.produtos
    },

    categorias() {
      return this.categoriaStore.categorias
    },

    marcas() {
      return this.marcaStore.marcas
    },

    unidades() {
      return this.useUnidadeStore.unidades
    },

    loading() {
      return this.productStore.loading
    },

    produtosFiltrados(): IProduto[] {
      return this.produtos.filter(p => {
        const matchNome = p.nome.toLowerCase().includes(this.filtros.nome.toLowerCase())
        const matchCategoria = this.filtros.categoria
          ? p.categoria === this.filtros.categoria
          : true
        const matchMarca = this.filtros.marca
          ? p.marca === this.filtros.marca
          : true
        return matchNome && matchCategoria && matchMarca
      })
    }
  },

  async mounted() {
    await this.productStore.buscarProdutos()
    await this.categoriaStore.buscarCategorias()
    await this.marcaStore.buscarMarcas()
    await this.useUnidadeStore.buscarUnidades()
  },

  methods: {
    salvarInfoNutricional() {
      this.produtoEditando.informacaoNutricional = { ...this.infoNutricional }
      this.dialogInfoNutricional = false
    },

    abrirDialogNutricional() {

      try {

        if (this.produtoEditando.informacaoNutricional) {
          this.infoNutricional = { ...this.produtoEditando.informacaoNutricional }
        } else {
          this.infoNutricional = this.infoNutricionalVazia()
        }
      } catch (error) {
        console.error('Erro ao converter JSON de informação nutricional:', error)
      }

      this.dialogInfoNutricional = true
    },

    abrirEdicao(produto: IProduto) {
      this.produtoEditando = { ...produto }

      // Converte nomes → IDs para funcionar no <v-select>
      this.produtoEditando.marca = this.marcas.find(m => m.nome === produto.marca)?.id ?? null

      this.produtoEditando.categoria = this.categorias.find(c => c.nome === produto.categoria)?.id ?? null

      this.produtoEditando.unidadeMedida = this.unidades.find(u => u.nome === produto.unidadeMedida)?.id ?? null
      this.dialogEdicao = true
    },

    fecharDialogo() {
      this.dialogEdicao = false
      this.produtoEditando = {} as IProduto
    },

    async salvarEdicao() {
      await this.productStore.atualizarProduto(this.produtoEditando)
      console.log(this.produtoEditando)
      this.fecharDialogo()
    },

    abrirDialogExcluir(produto: IProduto) {
      this.produtoSelecionado = produto
      this.dialogExcluir = true
    },

    async confirmarExclusao() {
      if (!this.produtoSelecionado) return
      await this.productStore.excluirProduto(this.produtoSelecionado.id!)
      this.dialogExcluir = false
      this.produtoSelecionado = null
    },

    infoNutricionalVazia() {
      return {
        ingredientes: '',
        alergenicos: '',
        porcao: '',
        calorias: 0,
        proteinas: 0,
        carboidratos: 0,
        gorduras: 0,
        sodio: 0,
        acucares: 0
      }
    }

  }
})
</script>
