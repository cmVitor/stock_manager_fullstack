<template>
  <v-container class="py-6">
    <v-card elevation="6">
      <v-card-title class="text-h5">Produtos em Estoque Crítico</v-card-title>
      <v-divider></v-divider>

      <v-data-table :headers="headers" :items="estoqueCritico" class="elevation-10" hover
        no-data-text="Nenhum produto com estoque crítico">
        <template v-slot:item="{ item }">
          <tr class="linha-critica">
            <td>{{ item.produtoNome }}</td>
            <td>{{ item.lote }}</td>
            <td>{{ formatarData(item.validade) }}</td>
            <td class="text-left">{{ item.saldo }}</td>
            <td class="text-left">{{ item.quantidadeMinima }}</td>
          </tr>
        </template>
      </v-data-table>
    </v-card>
  </v-container>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import { useEstoqueStore } from '@/stores/estoqueStore'
import type { IEstoqueItem } from '@/interfaces/Estoque/IEstoqueItem';


export default defineComponent({
  name: 'RelatorioEstoqueCritico',
  data() {
    return {
      headers: [
        { title: 'Produto', key: 'produtoNome' },
        { title: 'Lote', key: 'lote' },
        { title: 'Validade', key: 'validade' },
        { title: 'Saldo', key: 'saldo' },
        { title: 'Qtd Mínima', key: 'quantidadeMinima' }
      ]
    }
  },
  computed: {
  
    estoqueStore() {
      return useEstoqueStore()
    },

    // apenas os produtos com estoque crítico
    estoqueCritico(): IEstoqueItem[] {
      return this.estoqueStore.estoqueFormatado.filter(
        item => item.estoqueCritico === true
      )
    }
  },
  async mounted() {
    await this.estoqueStore.carregarEstoque()
  },
  methods: {
    formatarData(iso: string) {
      return new Date(iso).toLocaleDateString('pt-BR', { day: '2-digit', month: '2-digit', year: 'numeric' })
    }
  }
})
</script>

<style scoped>
.linha-critica {
  background-color: rgba(255, 0, 0, 0.11);
}
</style>
