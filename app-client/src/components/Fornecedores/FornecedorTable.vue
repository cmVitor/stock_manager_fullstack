<template>
  <v-container class="py-8">
    <v-card elevation="12" class="pa-4 card-table">
      <v-card-title class="d-flex align-center justify-space-between">
        <span class="text-h5 font-weight-bold">Fornecedores Cadastrados</span>
        <v-btn color="#7f2ec5" variant="elevated" class="text-white" @click="fornecedorStore.buscarFornecedores">
          <v-icon start>mdi-refresh</v-icon>
          Atualizar
        </v-btn>
      </v-card-title>

      <v-divider class="my-4" />

      <!-- Tabela -->
      <v-data-table
        :headers="headers"
        :items="fornecedores"
        :loading="loading"
        loading-text="Carregando fornecedores..."
        class="elevation-2 rounded-lg"
        hover
        no-data-text="Nenhum fornecedor encontrado"
        item-value="id"
      >
        <template #item="{ item }">
          <tr>
            <td>{{ item.nome }}</td>
            <td>{{ item.contato }}</td>
            <td>{{ item.email }}</td>
            <td>{{ item.estado }}</td>
            <td>{{ item.cidade }}</td>
            <td>{{ item.bairro }}</td>
            <td class="text-center">
              <v-btn icon variant="text" color="blue" @click="abrirEdicao(item)">
                <v-icon>mdi-pencil</v-icon>
              </v-btn>
              <v-btn icon variant="text" color="red" @click="confirmarExclusao(item)">
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
        <v-card-title class="text-h6 font-weight-bold">Editar Fornecedor</v-card-title>
        <v-card-text>
          <v-form ref="formEdicao" v-model="valid">
            <v-text-field
              variant="outlined"
              rounded
              v-model="fornecedorSelecionado.nome"
              label="Nome"
              prepend-inner-icon="mdi-account"
            />
            <v-text-field
              variant="outlined"
              rounded
              v-model="fornecedorSelecionado.contato"
              label="Contato"
              prepend-inner-icon="mdi-phone"
            />
            <v-text-field
              variant="outlined"
              rounded
              v-model="fornecedorSelecionado.email"
              label="E-mail"
              prepend-inner-icon="mdi-email"
            />

            <v-divider class="my-4" />

            <v-select
              variant="outlined"
              rounded
              v-model="fornecedorSelecionado.estado"
              :items="estados"
              label="Estado"
              item-title="uf"
              item-value=""
              @update:model-value="onEstadoChange"
              :loading="loadingEstados"
            />

            <v-select
              variant="outlined"
              rounded
              v-model="fornecedorSelecionado.cidade_id"
              :items="cidades"
              label="Cidade"
              item-title="name"
              item-value="id"
              :disabled="!fornecedorSelecionado.estado"
              :loading="loadingCidades"
            />

            <v-text-field
              variant="outlined"
              rounded
              v-model="fornecedorSelecionado.bairro"
              label="Bairro"
              prepend-inner-icon="mdi-home-map-marker"
            />
            <v-text-field
              variant="outlined"
              rounded
              v-model="fornecedorSelecionado.cep"
              label="CEP"
              prepend-inner-icon="mdi-home-map-marker"
            />
            <v-text-field
              variant="outlined"
              rounded
              v-model="fornecedorSelecionado.logradouro"
              label="Logradouro"
              prepend-inner-icon="mdi-home-map-marker"
            />
            <v-text-field
              variant="outlined"
              rounded
              v-model="fornecedorSelecionado.numero"
              label="Numero"
              prepend-inner-icon="mdi-home-map-marker"
            />
          </v-form>
        </v-card-text>

        <v-card-actions>
          <v-spacer />
          <v-btn color="grey" variant="text" @click="dialogEdicao = false">Cancelar</v-btn>
          <v-btn color="primary" @click="salvarEdicao">Salvar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- Dialog de Exclusão -->
    <v-dialog v-model="dialogExcluir" max-width="400px">
      <v-card>
        <v-card-title class="text-h6 font-weight-bold">Excluir Fornecedor</v-card-title>
        <v-card-text>
          Tem certeza que deseja excluir o fornecedor
          <strong>{{ fornecedorSelecionado.nome }}</strong>?
        </v-card-text>
        <v-card-actions>
          <v-spacer />
          <v-btn variant="text" color="grey" @click="dialogExcluir = false">Cancelar</v-btn>
          <v-btn variant="elevated" color="red" @click="excluirFornecedor">Excluir</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import { useFornecedorStore } from '@/stores/fornecedorStore'
import { useLocalidadeStore } from '@/stores/localidadeStore'
import type { IFornecedor } from '@/interfaces/Fornecedor/IFornecedor'

export default defineComponent({
  name: 'FornecedorTable',

  data() {
    return {
      fornecedorStore: useFornecedorStore(),
      localidadeStore: useLocalidadeStore(),
      dialogEdicao: false,
      dialogExcluir: false,
      fornecedorSelecionado: {} as IFornecedor,
      valid: false,
      headers: [
        { title: 'Nome', key: 'nome' },
        { title: 'Contato', key: 'contato' },
        { title: 'E-mail', key: 'email' },
        { title: 'Estado', key: 'estado' },
        { title: 'Cidade', key: 'cidade' },
        { title: 'Bairro', key: 'bairro' },
        { title: 'Ações', key: 'acoes', sortable: false }
      ]
    }
  },

  computed: {
    fornecedores() {
      return this.fornecedorStore.fornecedores
    },
    estados() {
      return this.localidadeStore.estados
    },
    cidades() {
      return this.localidadeStore.cidades
    },
    loading() {
      return this.fornecedorStore.loading
    },
    loadingEstados() {
      return this.localidadeStore.loadingEstados
    },
    loadingCidades() {
      return this.localidadeStore.loadingCidades
    }
  },

  async mounted() {
    await Promise.all([
      this.fornecedorStore.buscarFornecedores(),
      this.localidadeStore.buscarEstados()
    ])
  },

  methods: {
    abrirEdicao(fornecedor: IFornecedor) {
      console.log(fornecedor)
      this.fornecedorSelecionado = { ...fornecedor }
      this.dialogEdicao = true
      this.onEstadoChange()
    },

    confirmarExclusao(fornecedor: IFornecedor) {
      this.fornecedorSelecionado = fornecedor
      this.dialogExcluir = true
    },

    async salvarEdicao() {
      await this.fornecedorStore.atualizarFornecedor(this.fornecedorSelecionado)
      this.dialogEdicao = false
    },

    async excluirFornecedor() {
      if (!this.fornecedorSelecionado.id) return
      await this.fornecedorStore.excluirFornecedor(this.fornecedorSelecionado.id)
      this.dialogExcluir = false
    },

    async onEstadoChange() {
      if (this.fornecedorSelecionado.estado) {
        await this.localidadeStore.buscarCidades(this.fornecedorSelecionado.estado)
      }
    }
  }
})
</script>

<style scoped>
.card-table {
  border-radius: 20px;
}
.v-card-title {
  border-radius: 12px;
}
.v-btn {
  text-transform: none;
}
.v-data-table {
  border-radius: 12px;
}
</style>
