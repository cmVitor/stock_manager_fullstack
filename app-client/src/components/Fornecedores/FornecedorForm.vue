<template>
  <v-container class="d-flex justify-center align-center fill height">
    <v-card elevation="12" width="750" class="pa-6 card-form mt-10">
      <v-card-title class="text-h4 font-weight-bold text-center mb-1">
        Cadastro de Fornecedores
      </v-card-title>
      <v-card-subtitle class="text-h6 text-center mb-6">
        Preencha os dados abaixo:
      </v-card-subtitle>

      <v-form ref="form" v-model="valid" lazy-validation>
        <v-row dense>
          <v-col cols="12" sm="6">
            <v-text-field
              label="Nome do Fornecedor"
              prepend-inner-icon="mdi-factory"
              v-model="fornecedor.nome"
              variant="outlined"
              color="primary"
              rounded
              :rules="[v => !!v || 'O nome é obrigatório']"
              required
            />
          </v-col>

          <v-col cols="12" sm="6">
            <v-text-field
              label="Contato"
              prepend-inner-icon="mdi-phone"
              v-model="fornecedor.contato"
              variant="outlined"
              color="primary"
              rounded
              :rules="[v => !!v || 'O contato é obrigatório']"
              required
            />
          </v-col>

          <v-col cols="12">
            <v-text-field
              label="Email"
              prepend-inner-icon="mdi-email"
              v-model="fornecedor.email"
              variant="outlined"
              color="primary"
              rounded
              :rules="[
                v => !!v || 'O e-mail é obrigatório',
                v => /.+@.+\..+/.test(v) || 'E-mail inválido'
              ]"
              required
            />
          </v-col>
        </v-row>

        <v-divider class="my-6"></v-divider>

        <p class="text-h6 mb-2 text-primary">Endereço</p>

        <v-row dense>
          <v-col cols="12" sm="6">
            <v-select
              label="Estado"
              item-title="uf"
              prepend-inner-icon="mdi-map-marker"
              v-model="fornecedor.estado"
              :items="estados"
              :loading="loadingEstados"
              item-value="uf"
              @update:model-value="onEstadoChange"
              variant="outlined"
              rounded
              :rules="[v => !!v || 'Selecione um estado']"
              required
            ></v-select>
          </v-col>

          <v-col cols="12" sm="6">
            <v-autocomplete
              v-model="fornecedor.cidade"
              :items="cidades"
              :loading="loadingCidades"
              :disabled="!fornecedor.estado"
              item-value="id"
              label="Cidade"
              item-title="name"
              prepend-inner-icon="mdi-city"
              variant="outlined"
              rounded
              :rules="[v => !!v || 'Selecione uma cidade']"
              required
            ></v-autocomplete>
          </v-col>

          <v-col cols="12" sm="5">
            <v-text-field
              v-model="fornecedor.bairro"
              label="Bairro"
              prepend-inner-icon="mdi-home-map-marker"
              variant="outlined"
              rounded
              :rules="[v => !!v || 'O bairro é obrigatório']"
              required
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="4">
            <v-text-field
              v-model="fornecedor.cep"
              label="CEP"
              prepend-inner-icon="mdi-map-marker-question"
              variant="outlined"
              rounded
              :rules="[v => !!v || 'O CEP é obrigatório']"
              required
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="3">
            <v-text-field
              v-model="fornecedor.numero"
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
              v-model="fornecedor.logradouro"
              label="Logradouro"
              prepend-inner-icon="mdi-road-variant"
              variant="outlined"
              rounded
              :rules="[v => !!v || 'O Logradouro é obrigatório']"
              required
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="6">
            <v-text-field
              v-model="fornecedor.complemento"
              label="Complemento"
              prepend-inner-icon="mdi-text"
              variant="outlined"
              rounded
              :rules="[v => !!v || 'O bairro é obrigatório']"
              required
            ></v-text-field>
          </v-col>
        </v-row>

        <v-btn class="mt-6 gradient-btn" block size="large" @click="salvarFornecedor">
          <v-icon start>mdi-content-save</v-icon>
          Salvar Fornecedor
        </v-btn>
      </v-form>
    </v-card>
  </v-container>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import { useFornecedorStore } from '@/stores/fornecedorStore'
import { useLocalidadeStore } from '@/stores/localidadeStore'

export default defineComponent({
  name: 'FornecedorForm',

  data() {
    return {
      fornecedorStore: useFornecedorStore(),
      localidadeStore: useLocalidadeStore(),
      valid: false as boolean,
      fornecedor: {
        nome: '',
        contato: '',
        email: '',
        estado: '',
        cidade: '',
        cidade_id: null,
        bairro: '',
        complemento: '',
        cep: '',
        numero: '',
        logradouro: ''
      }
    }
  },

  computed: {
    estados() {
      return this.localidadeStore.estados
    },
    cidades() {
      return this.localidadeStore.cidades
    },
    loadingEstados() {
      return this.localidadeStore.loadingEstados
    },
    loadingCidades() {
      return this.localidadeStore.loadingCidades
    }
  },

  async mounted() {
    await this.localidadeStore.buscarEstados()
  },

  methods: {
    async onEstadoChange() {
      if (this.fornecedor.estado) {
        await this.localidadeStore.buscarCidades(this.fornecedor.estado)
      }
    },

    async salvarFornecedor(e: Event) {
      e.preventDefault()
      const form = this.$refs.form as any
      const { valid } = await form.validate()
      if (!valid) {
        alert('Preencha os campos corretamente')
        return
      }

      try {
        await this.fornecedorStore.adicionarFornecedor(this.fornecedor)
        alert('Fornecedor registrado com sucesso!')
        this.resetForm()
      } catch (error) {
        console.error(error)
        alert('Erro ao salvar fornecedor.')
      }
    },

    resetForm() {
      this.fornecedor = {
        nome: '',
        contato: '',
        email: '',
        estado: '',
        cidade: '',
        cidade_id: null,
        bairro: '',
        complemento: '',
        cep: '',
        numero: '',
        logradouro: ''
      }
    }
  }
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
