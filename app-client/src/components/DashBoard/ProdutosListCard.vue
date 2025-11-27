<template>
  <v-card elevation="3" class="pa-4 h-100">
    <div class="text-h6 mb-2">Últimos produtos cadastrados</div>

    <v-list density="compact">
      <template v-if="!loading && produtos.length">
        <v-list-item
          v-for="(produto, i) in produtosRecentes.slice(0, 3)"
          :key="i"
        >
          <v-list-item-title>{{ produto.nome }}</v-list-item-title>
          <v-list-item-subtitle>{{ produto.marca }}</v-list-item-subtitle>
          <v-divider></v-divider>
        </v-list-item>
      </template>

      <v-list-item v-else>
        <v-list-item-title>Nenhum produto encontrado</v-list-item-title>
      </v-list-item>
    </v-list>

    <v-card-actions>
      <v-btn variant="text" color="primary" @click="$router.push('/produtos')">
        Ver todos
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import { useProductStore } from '@/stores/productStore'

export default defineComponent({
  name: 'ProdutosListCard',

  data() {
    return {
      productStore: useProductStore()
    }
  },

  computed: {
    produtos() {
      return this.productStore.produtos
    },
    produtosRecentes() {
      return [...this.produtos].reverse()
    },
    loading() {
      return this.productStore.loading
    }
  },

  async mounted() {
    if (this.produtos.length === 0) {
      await this.productStore.buscarProdutos()
    }
  }
})
</script>
