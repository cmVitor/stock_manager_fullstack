<template>
  <v-container class="py-6">
    <v-card elevation="6">
      <v-card-title class="text-h5">Produtos Próximos ao Vencimento</v-card-title>
      <v-divider></v-divider>

      <v-data-table
        :headers="headers"
        :items="produtosProximos"
        class="elevation-10"
        hover
        no-data-text="Nenhum produto próximo da validade"
      >
        <template v-slot:item="{ item }">
          <tr class="linha-vencendo">
            <td>{{ item.produtoNome }}</td>
            <td>{{ item.lote }}</td>
            <td>{{ formatarData(item.validade) }}</td>
            <td class="text-left">{{ item.saldo }}</td>
            <td class="text-left">{{ item.quantidadeMinima }}</td>
            <td>{{ item.diasParaVencer }} dias</td>
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
  name: 'RelatorioValidadeProxima',
  data() {
    return {
      limiteDias: 30,
      headers: [
        { title: 'Produto', key: 'produtoNome' },
        { title: 'Lote', key: 'lote' },
        { title: 'Validade', key: 'validade' },
        { title: 'Saldo', key: 'saldo' },
        { title: 'Qtd Mínima', key: 'quantidadeMinima' },
        { title: 'Dias p/ Vencer', key: 'diasParaVencer' }
      ]
    }
  },
  computed: {
    produtosProximos(): IEstoqueItem[] {
      const hoje = new Date()
      return this.estoqueStore.estoqueFormatado
        .map(item => {
          const validade = new Date(item.validade)
          const diff = Math.ceil((validade.getTime() - hoje.getTime()) / (1000 * 60 * 60 * 24))
          return { ...item, diasParaVencer: diff }
        })
        .filter(item => item.diasParaVencer! >= 0 && item.diasParaVencer! <= this.limiteDias)
    },
  
    estoqueStore() {
      return useEstoqueStore()
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
.linha-vencendo {
  background-color: rgba(247, 255, 171, 0.432);
}
</style>
