<template>
    <v-col cols="12" sm="6" md="4" lg="3">
        <v-card class="pa-6 text-center" elevation="6" hover @click="$router.push('/estoque')">
            <v-icon size="48" color="info">mdi-information-outline</v-icon>
            <div class="mt-4 text-h6">Ver Estoque Atual</div>
            <v-row dense justify="center" class="mt-2">
                <v-chip color="orange-darken-4" size="small" class="ma-1" prepend-icon="mdi-alert">
                    {{ estoqueStore.totalPertoDeVencer }} produtos próximos ao vencimento
                </v-chip>
                <v-chip color="red-darken-4" size="small" class="ma-1" prepend-icon="mdi-alert">
                    {{ estoqueStore.totalEstoqueCritico }} produtos em estoque crítico
                </v-chip>
            </v-row>
        </v-card>
    </v-col>
</template>

<script lang="ts">
import { useEstoqueStore } from '@/stores/estoqueStore';
import { defineComponent } from 'vue';

export default defineComponent({
    name: 'EstoqueCard',

    data() {
        return {
        }
    },
    computed: {
        estoqueStore() {
            return useEstoqueStore()
        }
    },
    async mounted() {   
        const store = this.estoqueStore
        if (!store.estoque.length) {
            await store.carregarEstoque() //para que os alertas não fiquem zerados quando o card é carregado
        }
    }
})
</script>