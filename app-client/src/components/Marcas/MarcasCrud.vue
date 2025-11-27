<template>
  <v-container max-width="600px" class="py-6">
    <v-card class="pa-8 rounded-xl elevation-18 mx-auto" max-width="600">
      <v-card-title class="text-h5 font-weight-bold text-center mb-4">
        Gerenciador de Marca
      </v-card-title>

      <v-divider class="mb-6"></v-divider>

      <v-card-title>Cadastrar Marca</v-card-title>

      <v-form ref="form" v-model="valid" lazy-validation>
        <v-row>
          <v-col cols="12" sm="8">
            <v-text-field v-model="marca.nome" label="Digite a marca" prepend-inner-icon="mdi-tag" variant="outlined"
              color="primary" rounded :rules="[rules.required]" required />
          </v-col>
          <v-col cols="12" sm="4">
            <v-btn @click="salvarMarca" class="gradient-btn mt-2">
              <v-icon start>mdi-content-save</v-icon>
              Salvar
            </v-btn>
          </v-col>
        </v-row>
      </v-form>

      <v-divider class="my-8"></v-divider>

      <v-card-title>Marcas cadastradas</v-card-title>

      <v-text-field v-model="marcaStore.search" label="Buscar marca" @input="marcaStore.setSearch(marcaStore.search)" />

      <v-data-table-server :headers="headers" :items="marcas" :items-length="pagination.total"
        :items-per-page="pagination.per_page" :page="pagination.current_page" @update:page="trocarPagina"
        :loading="loading" class="elevation-1" item-value="id" hover no-data-text="Nenhuma marca cadastrada">
        <template v-slot:item="{ item }">
          <tr>
            <td>{{ item.id }}</td>
            <td align="center">{{ item.nome }}</td>
            <td align="right">
              <v-btn icon variant="text" color="blue" @click="abrirEdicao(item)">
                <v-icon>mdi-pencil</v-icon>
              </v-btn>
              <v-btn icon variant="text" color="red" @click="abrirDialogExcluir(item)">
                <v-icon>mdi-delete</v-icon>
              </v-btn>
            </td>
          </tr>
        </template>
      </v-data-table-server>
    </v-card>

    <!-- Dialog de Edição -->
    <v-dialog v-model="dialogEdicao" max-width="600px">
      <v-card>
        <v-card-title>Edição de Marca</v-card-title>
        <v-divider></v-divider>

        <v-card-text>
          <v-form ref="formEdicao" v-model="formValido">
            <v-text-field variant="outlined" rounded v-model="marcaEditando.nome" label="Nome"
              prepend-inner-icon="mdi-tag" required />
          </v-form>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn text @click="fecharDialog">Cancelar</v-btn>
          <v-btn color="primary" :disabled="!formValido" @click="salvarEdicao">
            Salvar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- Dialog de Exclusão -->
    <v-dialog v-model="dialogExcluir" max-width="400px">
      <v-card>
        <v-card-title class="text-h6 font-weight-bold">Excluir Marca</v-card-title>
        <v-card-text>
          Tem certeza que deseja excluir a marca
          <strong>{{ marcaSelecionada?.nome }}</strong>?
        </v-card-text>
        <v-card-actions>
          <v-spacer />
          <v-btn variant="text" color="grey" @click="dialogExcluir = false">Cancelar</v-btn>
          <v-btn variant="elevated" color="red" @click="confirmarExclusao">Excluir</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import { useMarcaStore } from '@/stores/marcaStore'
import type { IMarca } from '@/interfaces/Marca/IMarca'

interface Header {
  title: string
  key: string
}

export default defineComponent({
  name: 'MarcaCrud',

  data() {
    return {
      valid: false,
      formValido: false,
      dialogEdicao: false,
      dialogExcluir: false,
      marcaEditando: {} as IMarca,
      marcaSelecionada: null as IMarca | null,
      marca: {
        nome: ''
      } as IMarca,
      headers: [
        { title: 'Id', key: 'id' },
        { title: 'Nome', key: 'nome', align: 'center' },
        { title: 'Ações', key: 'acoes', sortable: false, align: 'end' }
      ] as Header[],

      rules: {
        required: (v: string) => !!v || 'Campo obrigatório'
      }
    }
  },

  computed: {
    marcaStore() {
      return useMarcaStore()
    },

    marcas() {
      return this.marcaStore.marcas
    },

    loading() {
      return this.marcaStore.loading
    },

    pagination() {
      return this.marcaStore.pagination
    }
  },

  async mounted() {
    await this.marcaStore.buscarMarcas()
  },

  methods: {
    async salvarMarca() {
      const form = this.$refs.form as any
      const { valid } = await form.validate()
      if (!valid) {
        alert('Preencha os campos corretamente')
        return
      }

      const marcaStore = useMarcaStore()

      try {
        await marcaStore.salvarMarca(this.marca)
        alert('Marca cadastrada com sucesso!')
        this.resetForm()
      } catch (error) {
        console.error('Erro ao salvar marca:', error)
        alert('Erro ao salvar marca.')
      }
    },

    resetForm() {
      this.marca = { nome: '' }
        ; (this.$refs.form as any).resetValidation()
    },

    abrirEdicao(marca: IMarca) {
      this.marcaEditando = { ...marca }
      this.dialogEdicao = true
    },

    fecharDialog() {
      this.dialogEdicao = false
      this.marcaEditando = {} as IMarca
    },

    async salvarEdicao() {
      await this.marcaStore.atualizarMarca(this.marcaEditando)
      this.fecharDialog()
    },

    abrirDialogExcluir(marca: IMarca) {
      this.marcaSelecionada = marca
      this.dialogExcluir = true
    },

    async confirmarExclusao() {
      if (!this.marcaSelecionada) return
      await this.marcaStore.excluirMarca(this.marcaSelecionada.id!)
      this.dialogExcluir = false
      this.marcaSelecionada = null
    },
    async trocarPagina(page: number) {
      await this.marcaStore.buscarMarcas(page)
    }
  }
})
</script>

<style scoped>
.v-data-table {
  border-radius: 12px;
}

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
