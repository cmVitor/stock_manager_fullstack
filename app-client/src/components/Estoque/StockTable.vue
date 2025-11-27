<template>
  <v-container class="py-6">
    <v-card elevation="6">
      <v-card-title class="text-h5">Estoque Atual</v-card-title>
      <v-divider></v-divider>

      <v-data-table
        :headers="headers"
        :items="estoqueComDados"
        class="elevation-10"
        hover
        no-data-text="Nenhum item no estoque"
      >
        <template v-slot:item="{ item }">
          <tr :class="linhaClasse(item)">
            <td>{{ item.produtoNome }}</td>
            <td>{{ item.lote }}</td>
            <td>{{ formatarData(item.validade) }}</td>
            <td class="text-left">{{ item.saldo }}</td>
            <td>{{ item.quantidadeMinima }}</td>
            <td>
              <v-chip v-if="item.expirado" color="red" text-color="white" small>
                Vencido
              </v-chip>

              <v-chip v-else-if="item.pertoDeVencer" color="orange" text-color="white" small>
                Vence em {{ item.diasParaVencer }}d
              </v-chip>

              <v-chip v-if="item.estoqueCritico" color="deep-orange" text-color="white" small>
                Estoque Crítico
              </v-chip>
            </td>
          </tr>
        </template>
      </v-data-table>
    </v-card>
  </v-container>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import { useEstoqueStore } from '@/stores/estoqueStore'
import { useloteStore } from '@/stores/loteStore'
import { useProductStore } from '@/stores/productStore'
import type { IEstoqueItem } from '@/interfaces/Estoque/IEstoqueItem'

export default defineComponent({
  name: 'StockTable',

  data() {
    return {
      headers: [
        { title: 'Produto', key: 'produtoNome' },
        { title: 'Lote', key: 'lote' },
        { title: 'Validade', key: 'validade' },
        { title: 'Saldo', key: 'saldo' },
        { title: 'Qtd Mínima', key: 'quantidadeMinima' },
        { title: 'Status', key: 'status' }
      ]
    }
  },

  computed: {
    estoqueStore() {
      return useEstoqueStore()
    },
    loteStore() {
      return useloteStore()
    },
    productStore() {
      return useProductStore()
    },

    
     // Junta os dados do estoque + lote + produto
     // para exibir validade e quantidade mínima corretas.
     
    estoqueComDados(): IEstoqueItem[] {
      const hoje = new Date()
      const limite = 30

      return this.estoqueStore.estoque.map((item) => {
        const lote = this.loteStore.lotes.find(l => l.descricao === item.lote)
        const produto = this.productStore.produtos.find(p => p.id === item.produtoId)

        const validadeStr = lote?.dataValidade || item.validade
        const validade = new Date(validadeStr)
        const diffMs = validade.getTime() - hoje.getTime()
        const dias = Math.ceil(diffMs / (1000 * 60 * 60 * 24))

        const quantidadeMinima = produto?.quantidadeMinima ?? item.quantidadeMinima ?? 0

        return {
          ...item,
          validade: validadeStr,
          quantidadeMinima,
          diasParaVencer: dias,
          expirado: dias < 0,
          pertoDeVencer: dias >= 0 && dias <= limite,
          estoqueCritico: item.saldo <= quantidadeMinima
        }
      })
    }
  },

  async mounted() {
    await Promise.all([
      this.estoqueStore.carregarEstoque(),
      this.loteStore.buscarLotes(),
      this.productStore.buscarProdutos()
    ])
  },

  methods: {
    formatarData(iso: string): string {
      if (!iso) return '-'
      const d = new Date(iso)
      return d.toLocaleDateString('pt-BR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
      })
    },

    linhaClasse(item: IEstoqueItem) {
      if (item.expirado) return 'linha-expirada'
      if (item.pertoDeVencer) return 'linha-vencendo'
      if (item.estoqueCritico) return 'linha-critica'
      return ''
    }
  }
})
</script>

<style scoped>
.v-data-table {
  font-size: 0.9rem;
}

.linha-expirada {
  background-color: rgba(255, 0, 0, 0.11);
}

.linha-vencendo {
  background-color: rgba(247, 255, 171, 0.432);
}

.linha-critica {
  background-color: rgba(255, 98, 0, 0.205);
}
</style>
