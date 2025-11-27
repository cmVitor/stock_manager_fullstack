<template>
  <v-container class="py-6">
    <v-card elevation="6">
      <v-card-title class="text-h5 d-flex justify-space-between align-center">
        <span>Movimentações Realizadas</span>
        <v-btn color="#7f2ec5" class="text-white" variant="elevated" @click="atualizarDados">
          <v-icon start>mdi-refresh</v-icon>
          Atualizar
        </v-btn>
      </v-card-title>

      <v-divider class="my-3"></v-divider>

      <!-- Filtros -->
      <v-row class="px-4" dense>
        <v-col cols="12" sm="3">
          <v-text-field
            v-model="filtros.produto"
            label="Produto"
            variant="outlined"
            rounded
            prepend-inner-icon="mdi-package-variant"
            clearable
          />
        </v-col>

        <v-col cols="12" sm="2">
          <v-select
            v-model="filtros.tipo"
            :items="['Entrada', 'Saída']"
            label="Tipo"
            variant="outlined"
            rounded
            prepend-inner-icon="mdi-swap-horizontal"
            clearable
          />
        </v-col>

        <v-col cols="12" sm="2">
          <v-text-field
            v-model.number="filtros.quantidade"
            label="Qtd. mínima"
            variant="outlined"
            rounded
            type="number"
            prepend-inner-icon="mdi-scale-balance"
            clearable
            min="0"
          />
        </v-col>

        <v-col cols="12" sm="3">
          <v-select
            v-model="filtros.funcionarioId"
            :items="funcionarios"
            label="Funcionário"
            item-title="nome"
            item-value="id"
            variant="outlined"
            rounded
            prepend-inner-icon="mdi-account"
            clearable
          />
        </v-col>

        <v-col cols="12" sm="2" class="d-flex align-start justify-center mt-3">
          <v-btn color="primary" @click="limparFiltros" variant="outlined">
            <v-icon start>mdi-filter-remove</v-icon> Limpar
          </v-btn>
        </v-col>

        <v-col cols="12" sm="3">
          <v-text-field
            v-model="filtros.dataInicio"
            label="Data inicial"
            variant="outlined"
            rounded
            type="date"
            prepend-inner-icon="mdi-calendar-start"
            clearable
          />
        </v-col>

        <v-col cols="12" sm="3">
          <v-text-field
            v-model="filtros.dataFim"
            label="Data final"
            variant="outlined"
            rounded
            type="date"
            prepend-inner-icon="mdi-calendar-end"
            clearable
          />
        </v-col>
      </v-row>

      <v-divider class="my-3"></v-divider>

      <!-- Tabela -->
      <v-data-table
        :headers="headers"
        :items="linhasFiltradas"
        :loading="movimentacaoStore.loading"
        class="elevation-1"
        hover
        no-data-text="Nenhuma movimentação encontrada"
        item-value="id"
      >
        <template v-slot:item="{ item }">
          <tr>
            <td>
              <v-chip :color="item.tipo === 'E' ? 'green' : 'red'" size="small">
                {{ item.tipo }}
              </v-chip>
            </td>
            <td>{{ item.produtoNome }}</td>
            <td>{{ item.quantidade }}</td>
            <td>R$ {{ Number(item.preco).toFixed(2).replace('.', ',') }}</td>
            <td>{{ item.loteDescricao || '—' }}</td>
            <td>{{ item.funcionarioNome || '—' }}</td>
            <td>{{ item.fornecedorNome || '—' }}</td>
            <td>{{ formatarData(item.data) }}</td>
          </tr>
        </template>
      </v-data-table>
    </v-card>
  </v-container>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import { useMovimentacaoStore } from '@/stores/movimentacaoStore'
import { useUserStore } from '@/stores/userStore'
import { mapStores } from 'pinia'
import type { IUsuario } from '@/interfaces/User/IUsuario'
import type { IMovimentacao } from '@/interfaces/Moviment/IMovimentacao'

export default defineComponent({
  name: 'MovimentacaoTable',

  data() {
    return {
      userStore: useUserStore(),
      filtros: {
        produto: '',
        quantidade: null as number | null,
        tipo: '',
        funcionarioId: '',
        dataInicio: '',
        dataFim: '',
      },
      headers: [
        { title: 'Tipo', key: 'tipo' },
        { title: 'Produto', key: 'produtoNome' },
        { title: 'Quantidade', key: 'quantidade' },
        { title: 'Preço', key: 'preco' },
        { title: 'Lote', key: 'lote' },
        { title: 'Funcionário', key: 'funcionarioNome' },
        { title: 'Fornecedor', key: 'fornecedorNome' },
        { title: 'Data', key: 'data' },
      ],
    }
  },

  computed: {
    ...mapStores(useMovimentacaoStore),

    funcionarios(): IUsuario[] {
      return this.userStore.usuarios
    },

    linhasFormatadas(): any[] {
      return this.movimentacaoStore.movimentacoes.flatMap(mov => {
        const funcionario = this.funcionarios.find(f => f.id === mov.funcionarioId)
        return mov.itens.map(item => ({
          id: `${mov.id}-${item.produtoId}`,
          tipo: mov.tipo,
          data: mov.data,
          funcionarioId: mov.funcionarioId,
          funcionarioNome: funcionario?.nome || '—',
          ...item,
        }))
      })
    },

    linhasFiltradas(): any[] {
      return this.linhasFormatadas.filter(item => {
        const { produto, quantidade, tipo, funcionarioId, dataInicio, dataFim } = this.filtros
        const dataMov = new Date(item.data)

        const produtoMatch = !produto || item.produtoNome.toLowerCase().includes(produto.toLowerCase())
        const tipoMatch = !tipo || item.tipo === tipo
        const quantidadeMatch = !quantidade || item.quantidade >= quantidade
        const funcionarioMatch = !funcionarioId || item.funcionarioId == funcionarioId
        const dataInicioMatch = !dataInicio || dataMov >= new Date(dataInicio)
        const dataFimMatch = !dataFim || dataMov <= new Date(dataFim)

        return produtoMatch && tipoMatch && quantidadeMatch && funcionarioMatch && dataInicioMatch && dataFimMatch
      })
    },
  },

  async mounted() {
    await Promise.all([
      this.userStore.buscarUsuarios(),
      this.movimentacaoStore.buscarMovimentacoes(),
    ])
  },

  methods: {
    limparFiltros() {
      this.filtros = {
        produto: '',
        quantidade: null,
        tipo: '',
        funcionarioId: '',
        dataInicio: '',
        dataFim: '',
      }
    },

    async atualizarDados() {
      await Promise.all([
        this.userStore.buscarUsuarios(),
        this.movimentacaoStore.buscarMovimentacoes(),
      ])
    },

    formatarData(isoString: string): string {
      const data = new Date(isoString)
      return data.toLocaleDateString('pt-BR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
      })
    },
  },
})
</script>

<style scoped>
.v-card-title {
  font-weight: bold;
}
.v-data-table {
  border-radius: 12px;
}
.v-btn {
  text-transform: none;
}
</style>
