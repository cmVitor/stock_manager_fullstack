<template>
  <v-container fluid class="pa-6">

    <!-- Linha 1 -->
    <v-row class="mt-4" justify="center" align="stretch">
      <v-col cols="12" sm="6" md="4" lg="3">
        <ActionCard
          icon="mdi-plus"
          color="primary"
          title="Cadastrar um novo produto"
          to="/produtos/novo"
        />
      </v-col>

      <EstoqueCard />

      <v-col cols="12" sm="6" md="4" lg="3">
        <ActionCard
          icon="mdi-arrow-right-bold"
          color="success"
          title="Realizar nova movimentação"
          to="/movimentacoes/nova"
        />
      </v-col>
    </v-row>

    <!-- Linha 2 -->
    <v-row class="my-5" justify="center" align="stretch">
      <v-col cols="12" sm="6" md="4" lg="3">
        <ProdutosListCard />
      </v-col>

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

    <!-- Linha 3 -->
    <v-row class="my-4" justify="center" align="stretch">
      <v-col cols="12" sm="8">
        <MovimentacoesTable />
      </v-col>
    </v-row>
  </v-container>
</template>

<script lang="ts">
import { defineComponent } from 'vue'

export default defineComponent({
    name: 'DashBoard'
})

</script>