<template>
  <v-container class="d-flex align-center justify-center fill-height">
    <v-card elevation="12" width="750" class="pa-6 card-form mt-10">
      <v-card-title class="text-h4 font-weight-bold text-center mb-1">
        Cadastro de Usuário
      </v-card-title>
      <v-card-subtitle class="text-h6 text-center mb-6">
        Preencha os dados abaixo:
      </v-card-subtitle>

      <v-form ref="form" v-model="valid" lazy-validation>
        <v-row dense>
          <v-col cols="12" sm="6">
            <v-text-field v-model="user.nome" label="Nome" prepend-inner-icon="mdi-account" variant="outlined"
              color="primary" rounded :rules="[v => !!v || 'O nome é obrigatório']" required />
          </v-col>

          <v-col cols="12" sm="6">
            <v-text-field v-model="user.email" label="E-mail" prepend-inner-icon="mdi-email" variant="outlined"
              color="primary" rounded :rules="[
                v => !!v || 'O e-mail é obrigatório',
                v => /.+@.+\..+/.test(v) || 'E-mail inválido'
              ]" required />
          </v-col>

          <v-col cols="12" sm="6">
            <v-text-field v-model="user.cpf" label="CPF" prepend-inner-icon="mdi-account-search"
               variant="outlined" color="primary" rounded
              :rules="[v => !!v || 'O CPF é obrigatório']" required />
          </v-col>

          <v-col cols="12" sm="6">
            <v-text-field v-model="user.senha" label="Senha" prepend-inner-icon="mdi-lock" type="password"
              variant="outlined" color="primary" rounded :rules="[v => !!v || 'A senha é obrigatória']" required />
          </v-col>

          <v-col cols="12" sm="6">
            <v-select v-model="user.cargo" :items="['admin', 'funcionario']" label="Cargo"
              prepend-inner-icon="mdi-briefcase" variant="outlined" color="primary" rounded
              :rules="[v => !!v || 'Selecione um cargo']" required />
          </v-col>
        </v-row>

        <v-divider class="my-6"></v-divider>

        <p class="text-h6 mb-2 text-primary">Endereço</p>

        <v-row dense>
          <v-col cols="12" sm="6">
            <v-select v-model="user.estado" :items="localidadeStore.estados" label="Estado" item-title="uf"
              item-value="uf" prepend-inner-icon="mdi-map-marker" variant="outlined" color="primary" rounded
              :loading="localidadeStore.loadingEstados" @update:model-value="onEstadoChange"
              :rules="[v => !!v || 'Selecione um estado']" required />
          </v-col>

          <v-col cols="12" sm="6">
            <v-autocomplete v-model="user.cidade" :items="localidadeStore.cidades" label="Cidade" item-title="name"
              item-value="id" prepend-inner-icon="mdi-city" variant="outlined" color="primary" rounded
              :disabled="!user.estado" :loading="localidadeStore.loadingCidades"
              :rules="[v => !!v || 'Selecione uma cidade']" required />
          </v-col>

          <v-col cols="12" sm="5">
            <v-text-field v-model="user.bairro" label="Bairro" prepend-inner-icon="mdi-home-map-marker"
              variant="outlined" color="primary" rounded :rules="[v => !!v || 'O bairro é obrigatório']" required />
          </v-col>
          <v-col cols="12" sm="4">
            <v-text-field
              v-model="user.cep"
              label="CEP"
              prepend-inner-icon="mdi-map-marker-question"
              variant="outlined"
              rounded
              :rules="[v => !!v && v.length === 8 || 'O CEP deve ter 8 caracteres']"
              required
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="3">
            <v-text-field
              v-model="user.numero"
              label="numero"
              prepend-inner-icon="mdi-numeric"
              variant="outlined"
              rounded
              :rules="[v => !!v || 'O número é obrigatório']"
              required
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="6">
            <v-text-field
              v-model="user.logradouro"
              label="Logradouro"
              prepend-inner-icon="mdi-road-variant"
              variant="outlined"
              rounded
              :rules="[v => !!v || 'O Logradouro é obrigatório']"
              required
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="6">
            <v-text-field v-model="user.complemento" label="Complemento" prepend-inner-icon="mdi-text" :rules="[v => !!v || 'O complemento é obrigatório']"
              variant="outlined" color="primary" rounded />
          </v-col>
        </v-row>

        <v-btn class="mt-6 gradient-btn" block size="large" @click="salvarUsuario">
          <v-icon start>mdi-content-save</v-icon>
          Salvar Cadastro
        </v-btn>
      </v-form>
    </v-card>
  </v-container>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import { useUserStore } from '@/stores/userStore'
import { useLocalidadeStore } from '@/stores/localidadeStore'
import type { IUsuario } from '@/interfaces/User/IUsuario'

export default defineComponent({
  name: 'UserForm',

  data() {
    return {
      valid: false,
      userStore: useUserStore(),
      localidadeStore: useLocalidadeStore(),
      user: {
        nome: '',
        email: '',
        cpf: '',
        senha: '',
        estado: '',
        cidade: '',
        cidade_id: null,
        bairro: '',
        complemento: '',
        cargo: '',
        cep: '',
        numero: '',
        logradouro: ''
      } as IUsuario,
    }
  },

  mounted() {
    this.localidadeStore.buscarEstados()
  },

  methods: {
    async onEstadoChange() {
      if (this.user.estado) {
        await this.localidadeStore.buscarCidades(this.user.estado)
      }
    },

    async salvarUsuario(e: Event) {
      e.preventDefault()
      const form = this.$refs.form as any
      const { valid } = await form.validate()
      if (!valid) {
        alert('Preencha os campos corretamente')
        return
      }

      try {
        await this.userStore.salvarUsuario(this.user)
        alert('Usuário cadastrado com sucesso!')
        this.resetForm()
      } catch {
        alert('Erro ao salvar usuário.')
      }
    },

    resetForm() {
      this.user = {
        nome: '',
        email: '',
        cpf: '',
        senha: '',
        estado: '',
        cidade: '',
        cidade_id: null,
        estado_uf: null,
        bairro: '',
        complemento: '',
        cargo: '',
        cep: '',
        logradouro: '',
        numero: ''
      }
      const form = this.$refs.form as any
      form?.resetValidation?.()
    },
  },
})
</script>


<style scoped>
.card-form {
  border-radius: 20px;
}

.gradient-btn {
  background: linear-gradient(45deg, #550899, #ab6ee0);
  color: white !important;
  font-weight: 600;
  border-radius: 12px;
  transition: all 0.3s ease;
}

.gradient-btn:hover {
  background: linear-gradient(45deg, #380c5f, #7f2ec5);
  transform: scale(1.02);
}
</style>
