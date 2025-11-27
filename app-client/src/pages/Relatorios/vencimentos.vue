<template>
    <v-container fluid>
        <RelatorioValidadeProxima />
        <RedirectButton to="/estoque" text="Ver estoque"></RedirectButton>
    </v-container>
</template>

<script>
import RelatorioValidadeProxima from '@/components/Estoque/RelatorioValidadeProxima.vue';

export default {
    name: 'RelatoriosVencimentos'
}
</script>

<style>

</style>