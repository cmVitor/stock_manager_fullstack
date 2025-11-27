<template>
  <v-navigation-drawer v-model="isDrawerOpen">
    <v-list>
      <v-list-subheader>Gerenciamento</v-list-subheader>

      <v-list>
        <v-list-item v-if="auth.usuarioLogado" :prepend-avatar="defaultAvatar" :subtitle="auth.usuarioLogado.role"
          :title="auth.usuarioLogado.name" />
      </v-list>

      <v-divider />

      <v-list-item to="/home" prepend-icon="mdi-view-dashboard">Dashboard</v-list-item>
      <v-list-item to="/produtos" prepend-icon="mdi-cube-outline">Produtos</v-list-item>
      <v-list-item to="/estoque" prepend-icon="mdi-warehouse">Estoque</v-list-item>
      <v-list-item to="/movimentacoes" prepend-icon="mdi-swap-horizontal-bold">Movimentações</v-list-item>

      <v-divider />
      <div class="admin-list" v-if="authStore.userRole === 'admin'">
        <v-list-subheader class="mt-5">Administração</v-list-subheader>
        <v-list-item to="/usuarios" prepend-icon="mdi-account">Usuários</v-list-item>
        <v-list-item to="/fornecedores" prepend-icon="mdi-factory">Fornecedores</v-list-item>
        <v-list-item to="/lotes" prepend-icon="mdi-alpha-l-circle-outline">Lotes</v-list-item>
        <v-list-item to="/categorias" prepend-icon="mdi-shape">Categorias</v-list-item>
        <v-list-item to="/marcas" prepend-icon="mdi-ticket-confirmation">Marcas</v-list-item>
      </div>
    </v-list>
  </v-navigation-drawer>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import { useAuthStore } from '@/stores/authStore'
import { useRouter } from 'vue-router';

export default defineComponent({
  name: 'HeaderDrawer',
  props: {
    modelValue: { type: Boolean, required: true },
  },
  emits: ['update:modelValue'],

  data() {
    return {
      auth: useAuthStore(),
      router: useRouter(),
      defaultAvatar:
        'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSppkoKsaYMuIoNLDH7O8ePOacLPG1mKXtEng&s',
    }
  },

  computed: {
    isDrawerOpen: {
      get(): boolean {
        return this.modelValue
      },
      set(value: boolean) {
        this.$emit('update:modelValue', value)
      },
    },
    usuario() {
      return this.auth.usuarioLogado
    },
    authStore(){
      return useAuthStore()
    }
  },

  mounted() {
    // Caso o usuário atualize a página, recarrega a sessão
    this.auth.carregarSessao()

    // Se não estiver logado, redireciona ao login
    if (!this.auth.isAuthenticated) {
      this.router.push('/login')
    }
  },
})
</script>
