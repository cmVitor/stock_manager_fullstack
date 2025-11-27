<template>
  <v-container fluid>
    <RelatorioEstoqueCritico />
    <RedirectButton to="/estoque" text="Ver estoque"></RedirectButton>
  </v-container>
</template>

<script lang="ts">
export default defineComponent({
  name: 'RelatoriosCriticos'
})
</script>

<style>

</style>