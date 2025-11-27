<template>
  <v-container max-width="600px" class="py-6">
    <v-card class="pa-8 rounded-xl elevation-18 mx-auto" max-width="600">
      <v-card-title class="text-h5 font-weight-bold text-center mb-4">
        Cadastro de Produto
      </v-card-title>

      <v-divider class="mb-6"></v-divider>

      <v-form ref="form" v-model="valid" lazy-validation>
        <v-row dense>
          <!-- Código -->
          <v-col cols="12" sm="6">
            <v-text-field v-model="produto.codigo" label="Código" prepend-inner-icon="mdi-barcode" variant="outlined"
              color="primary" rounded :rules="[rules.required]" required />
          </v-col>

          <!-- Nome -->
          <v-col cols="12" sm="6">
            <v-text-field v-model="produto.nome" label="Nome do Produto" prepend-inner-icon="mdi-tag" variant="outlined"
              color="primary" rounded :rules="[rules.required]" required />
          </v-col>

          <!-- Marca -->
          <v-col cols="12" sm="6">
            <v-select v-model="produto.marca" :items="marcas" item-title="nome" item-value="id" label="Marca"
              prepend-inner-icon="mdi-ticket-confirmation" :loading="loadingMarcas" variant="outlined" rounded
              color="primary" :rules="[rules.required]" required />
          </v-col>

          <!-- Categoria -->
          <v-col cols="12" sm="6">
            <v-select v-model="produto.categoria" :items="categorias" item-title="nome" item-value="id"
              label="Categoria" prepend-inner-icon="mdi-shape" :loading="loadingCategorias" variant="outlined" rounded
              color="primary" :rules="[rules.required]" required />
          </v-col>

          <!-- Quantidade Mínima -->
          <v-col cols="12" sm="6">
            <v-text-field v-model.number="produto.quantidadeMinima" label="Quantidade Mínima" type="number"
              prepend-inner-icon="mdi-counter" variant="outlined" rounded color="primary"
              :rules="[rules.required, rules.positive]" required min="0" />
          </v-col>

          <!-- Unidade Medida -->
          <v-col cols="12" sm="6" class="d-flex align-center">
            <v-select v-model="produto.unidadeMedida" rounded variant="outlined" label="Unidade Medida"
            prepend-inner-icon="mdi-weight-kilogram" :items="unidades" item-title="nome" item-value="id"
            :rules="[rules.required]"
            ></v-select>
          </v-col>

          <!-- Perecível -->
          <v-col cols="12" sm="3" class="d-flex align-center">
            <v-checkbox v-model="produto.perecivel" label="Perecível" color="deep-purple-accent-4" hide-details />
          </v-col>

          <!-- Botão para abrir o Dialog de Informação Nutricional -->
          <v-col cols="12">
            <v-btn color="#7f2ec5" variant="outlined" block prepend-icon="mdi-food-variant"
              @click="dialogInfoNutricional = true">
              Informações Nutricionais
            </v-btn>
          </v-col>
        </v-row>

        <v-divider class="my-4"></v-divider>

        <v-card-actions>
          <v-btn color="primary" variant="elevated" class="gradient-btn text-white w-100" @click="salvarProduto">
            <v-icon start>mdi-content-save</v-icon>
            Salvar
          </v-btn>
        </v-card-actions>
      </v-form>
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
                <v-text-field v-model="infoNutricional.ingredientes" 
                label="Ingredientes" variant="outlined" rounded prepend-inner-icon="mdi-noodles"/>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" sm="6">
                <v-text-field v-model="infoNutricional.alergenicos" 
                label="Alérgenos" variant="outlined" rounded prepend-inner-icon="mdi-peanut-off-outline"/>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field v-model="infoNutricional.porcao" 
                label="Porção" variant="outlined" rounded prepend-inner-icon="mdi-food-takeout-box-outline"/>
              </v-col>

              <v-col cols="12" sm="6">
                <v-text-field v-model.number="infoNutricional.calorias" 
                label="Calorias (kcal)" type="number"
                variant="outlined" rounded prepend-inner-icon="mdi-nutrition"/>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field v-model.number="infoNutricional.proteinas" 
                label="Proteínas (g)" type="number"
                variant="outlined" rounded prepend-inner-icon="mdi-food-drumstick" />
              </v-col>

              <v-col cols="12" sm="6">
                <v-text-field v-model.number="infoNutricional.carboidratos" 
                label="Carboidratos (g)" type="number"
                variant="outlined" rounded prepend-inner-icon="mdi-barley"/>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field v-model.number="infoNutricional.gorduras" 
                label="Gorduras Totais (g)" type="number"
                variant="outlined" rounded prepend-inner-icon="mdi-scale"/>
              </v-col>
              
              <v-col cols="12" sm="6">
                <v-text-field v-model.number="infoNutricional.sodio" 
                label="Sódio (mg)" type="number" variant="outlined" rounded prepend-inner-icon="mdi-shaker"/>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field v-model.number="infoNutricional.acucares" label="Açúcares (g)" type="number"
              variant="outlined" rounded prepend-inner-icon="mdi-spoon-sugar"/>
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
  </v-container>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import { useProductStore } from '@/stores/productStore'
import { useCategoriaStore } from '@/stores/categoriaStore'
import { useMarcaStore } from '@/stores/marcaStore'
import { useUnidadeStore } from '@/stores/unidadeStore'
import type { IProduto } from '@/interfaces/Product/IProduto'
import type { IMarca } from '@/interfaces/Marca/IMarca'
import type { ICategoria } from '@/interfaces/Categoria/ICategoria'
import type { IInformacaoNutricional } from '@/interfaces/InformacaoNutricinal/IInformacaoNutricional'

export default defineComponent({
  name: 'ProductForm',

  data() {
    return {
      valid: false,
      dialogInfoNutricional: false,
      infoNutricional: {
        ingredientes: '',
        alergenicos: '',
        porcao: '',
        calorias: 0,
        proteinas: 0,
        carboidratos: 0,
        gorduras: 0,
        sodio: 0,
        acucares: 0
      } as IInformacaoNutricional,

      produto: {
        codigo: '',
        nome: '',
        marca: '',
        categoria: '',
        informacaoNutricional: {
          ingredientes: '',
          alergenicos: '',
          porcao: '',
          calorias: 0,
          proteinas: 0,
          carboidratos: 0,
          gorduras: 0,
          sodio: 0,
          acucares: 0
        },
        quantidadeMinima: 1,
        perecivel: false,
        unidadeMedida: ''
      } as IProduto,

      CategoriaStore: useCategoriaStore(),
      MarcaStore: useMarcaStore(),
      UnidadeStore: useUnidadeStore(),
      loadingCategorias: false,
      loadingMarcas: false,
      loadingUnidades: false,

      rules: {
        required: (v: string) => !!v || 'Campo obrigatório',
        positive: (v: number) => v > 0 || 'Deve ser um número positivo'
      }
    }
  },

  computed: {
    categorias(): ICategoria[] {
      return this.CategoriaStore.categorias
    },
    marcas(): IMarca[] {
      return this.MarcaStore.marcas
    },
    unidades() {
      return this.UnidadeStore.unidades
    }
  },

  async mounted() {
    await Promise.all([
      this.CategoriaStore.buscarCategorias(),
      this.MarcaStore.buscarMarcas(),
      this.UnidadeStore.buscarUnidades()
    ])
  },

  methods: {
    salvarInfoNutricional() {
      this.produto.informacaoNutricional = { ...this.infoNutricional }
      this.dialogInfoNutricional = false
    },

    async salvarProduto() {
      const form = this.$refs.form as any
      const { valid } = await form.validate()
      if (!valid) {
        alert('Preencha os campos corretamente')
        return
      }

      const productStore = useProductStore()

      try {
        await productStore.salvarProduto(this.produto)
        alert('Produto cadastrado com sucesso!')
        this.resetForm()
      } catch (error) {
        console.error('Erro ao salvar produto:', error)
        alert('Erro ao salvar produto.')
      }
    },

    resetForm() {
      this.produto = {
        codigo: '',
        nome: '',
        marca: '',
        categoria: '',
        informacaoNutricional: {
          ingredientes: '',
          alergenicos: '',
          porcao: '',
          calorias: 0,
          proteinas: 0,
          carboidratos: 0,
          gorduras: 0,
          sodio: 0,
          acucares: 0
        },
        quantidadeMinima: 1,
        perecivel: false,
        unidadeMedida: ''
      }
      this.infoNutricional = {
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
        ; (this.$refs.form as any).resetValidation()
    }
  }
})
</script>

<style scoped>
.v-card {
  border-radius: 16px;
}

.gradient-btn {
  background: linear-gradient(45deg, #550899, #ab6ee0);
  color: white !important;
  font-weight: 600;
  border-radius: 12px;
  transition: all 0.3s ease;
}

.gradient-btn:hover {
  background: linear-gradient(45deg, #380c5f, #7f2ec5);
  transform: scale(1.02);
}
</style>
