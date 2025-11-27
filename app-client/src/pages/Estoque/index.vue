<template>
    <v-container fluid>
        <StockTable></StockTable>
        <v-row class="my-5" justify="center" align="stretch">

      <v-col cols="12" sm="6" md="4" lg="3">
        <ReportCard
          icon="mdi-calendar-alert"
          color="warning"
          title="Produtos Próximos ao Vencimento"
          buttonText="Ver relatório completo"
          to="/relatorios/vencimentos"
        />
      </v-col>

      <v-col cols="12" sm="6" md="4" lg="3">
        <ReportCard
          icon="mdi-alert-circle"
          color="error"
          title="Produtos em Estoque Crítico"
          buttonText="Ver relatório completo"
          to="/relatorios/criticos"
        />
      </v-col>
    </v-row>
    <RedirectButton to="/home" text="Voltar pra DashBoard"></RedirectButton>
    </v-container>
</template>

<script>
export default {
    name: "Estoque"
}
</script>

<style>

</style>