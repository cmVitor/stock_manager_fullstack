<template>
  <v-container class="py-8">
    <v-card elevation="12" class="pa-4 card-table">
      <v-card-title class="d-flex align-center justify-space-between">
        <span class="text-h5 font-weight-bold">Lotes Cadastrados</span>
        <v-btn color="#7f2ec5" variant="elevated" class="text-white" @click="loteStore.buscarLotes">
          <v-icon start>mdi-refresh</v-icon>
          Atualizar
        </v-btn>
      </v-card-title>

      <v-divider class="my-4" />

      <!-- Tabela -->
      <v-data-table
        :headers="headers"
        :items="lotes"
        :loading="loading"
        loading-text="Carregando lotes..."
        class="elevation-2 rounded-lg"
        hover
        no-data-text="Nenhum lote encontrado"
        item-value="id"
      >
        <template v-slot:item="{ item }">
          <tr>
            <td>{{ item.descricao }}</td>
            <td>{{ item.dataValidade }}</td>
            <td>{{ item.corredor }}</td>
            <td>{{ item.prateleira }}</td>
            <td>{{ item.secao }}</td>
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
        <v-card-title class="text-h6 font-weight-bold">Editar Lote</v-card-title>
        <v-card-text>
          <v-form ref="formEdicao" v-model="valid">
            <v-text-field
              variant="outlined"
              rounded
              v-model="loteSelecionado.descricao"
              label="Descrição"
              prepend-inner-icon="mdi-text"
            />
            <v-text-field
              variant="outlined"
              rounded
              v-model="loteSelecionado.dataValidade"
              label="Data de Validade"
              prepend-inner-icon="mdi-calendar"
              type="date"
            />
            <v-text-field
              variant="outlined"
              rounded
              v-model="loteSelecionado.corredor"
              label="Corredor"
              prepend-inner-icon="mdi-office-building-marker-outline"
            />
            <v-text-field
              variant="outlined"
              rounded
              v-model="loteSelecionado.prateleira"
              label="Prateleira"
              prepend-inner-icon="mdi-archive-marker-outline"
            />
            <v-text-field
              variant="outlined"
              rounded
              v-model="loteSelecionado.secao"
              label="Seção"
              prepend-inner-icon="mdi-map-marker-radius"
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
        <v-card-title class="text-h6 font-weight-bold">Excluir Lote</v-card-title>
        <v-card-text>
          Tem certeza que deseja excluir o lote
          <strong>{{ loteSelecionado.descricao }}</strong>?
        </v-card-text>
        <v-card-actions>
          <v-spacer />
          <v-btn variant="text" color="grey" @click="dialogExcluir = false">Cancelar</v-btn>
          <v-btn variant="elevated" color="red" @click="excluirLote">Excluir</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import { useloteStore } from '@/stores/loteStore'
import type { ILote } from '@/interfaces/Lote/ILote';

export default defineComponent({
  name: 'LoteTable',

  data() {
    return {
      loteStore: useloteStore(),
      dialogEdicao: false,
      dialogExcluir: false,
      loteSelecionado: {} as ILote,
      valid: false,
      headers: [
        { title: 'Descrição', key: 'descricao' },
        { title: 'Data de Validade', key: 'dataValidade' },
        { title: 'Corredor', key: 'corredor' },
        { title: 'Prateleira', key: 'prateleira' },
        { title: 'Seção', key: 'secao' },
        { title: 'Ações', key: 'acoes', sortable: false },
      ],
    }
  },

  computed: {
    lotes(): ILote[] {
      return this.loteStore.lotes
    },
    loading(): boolean {
      return this.loteStore.loading
    },
  },

  async mounted() {
    await this.loteStore.buscarLotes()
  },

  methods: {
    abrirEdicao(lote: ILote) {
      this.loteSelecionado = { ...lote }
      this.dialogEdicao = true
    },

    confirmarExclusao(lote: ILote) {
      this.loteSelecionado = lote
      this.dialogExcluir = true
    },

    async salvarEdicao() {
      try {
        await this.loteStore.atualizarlote(this.loteSelecionado)
        this.dialogEdicao = false
      } catch {
        alert('Erro ao salvar alterações.')
      }
    },

    async excluirLote() {
      try {
        await this.loteStore.excluirLote(this.loteSelecionado.id!)
        this.dialogExcluir = false
      } catch {
        alert('Erro ao excluir lote.')
      }
    },
  },
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
