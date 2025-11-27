<template>
  <v-card elevation="3" class="pa-4">
    <div class="text-h6 mb-4">Últimas movimentações</div>

    <v-data-table 
        :headers="headers" 
        :items="ultimasMovimentacoes" 
        density="compact" class="elevation-0"
        hide-default-footer :loading="loading"
        no-data-text="Nenhuma movimentação registrada">


      <template v-slot:loading>
        <v-skeleton-loader type="table"></v-skeleton-loader>
      </template>

      <template v-slot:item.data="{ item }">
        {{ formatarData(item.data) }}
      </template>
    </v-data-table>

    <v-card-actions>
      <v-btn variant="text" color="primary" @click="$router.push('/movimentacoes')">
        Ver todas as movimentações
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import { useMovimentacaoStore } from '@/stores/movimentacaoStore'

export default defineComponent({
  name: 'MovimentacoesTable',

  data() {
    return {
      headers: [
        { title: 'Tipo', key: 'tipo' },
        { title: 'Produto', key: 'produtoNome' },
        { title: 'Quantidade', key: 'quantidade' },
        { title: 'Data', key: 'data' },
      ]
    }
  },

  computed: {
    movimentacaoStore() {
      return useMovimentacaoStore()
    },

    loading() {
      return this.movimentacaoStore.loading
    },

    ultimasMovimentacoes() {
      // Ordena do mais recente pro mais antigo
      const ordenadas = [...this.movimentacaoStore.movimentacoes].sort(
        (a, b) => new Date(b.data).getTime() - new Date(a.data).getTime()
      )

      const ultimas = ordenadas.slice(0, 3).flatMap(mov => {
        return mov.itens.map(item => ({
          tipo: mov.tipo,
          produtoNome: item.produtoNome || '—',
          quantidade: item.quantidade,
          data: mov.data,
        }))
      })

      return ultimas
    }
  },

  methods: {
    formatarData(data: string) {
      const d = new Date(data)
      return d.toLocaleDateString('pt-BR')
    }
  },

  async mounted() {
    await this.movimentacaoStore.buscarMovimentacoes()
  }
})
</script>
