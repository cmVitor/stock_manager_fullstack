<template>
  <v-container class="py-8">
    <v-card elevation="12" class="pa-4 card-table">
      <v-card-title class="d-flex align-center justify-space-between">
        <span class="text-h5 font-weight-bold">Usuários Cadastrados</span>
        <v-btn color="#7f2ec5" variant="elevated" class="text-white" @click="userStore.buscarUsuarios">
          <v-icon start>mdi-refresh</v-icon>
          Atualizar
        </v-btn>
      </v-card-title>

      <v-divider class="my-4" />

      <!-- Tabela -->
      <v-data-table :headers="headers" :items="usuarios" :loading="loading" loading-text="Carregando usuários..."
        class="elevation-2 rounded-lg" hover no-data-text="Nenhum usuário encontrado" item-value="id">
        <template v-slot:item="{ item }">
          <tr>
            <td>{{ item.nome }}</td>
            <td>{{ item.email }}</td>
            <td>{{ item.cpf }}</td>
            <td>{{ item.estado }}</td>
            <td>{{ item.cidade }}</td>
            <td>{{ item.bairro }}</td>
            <td>{{ item.cargo }}</td>
            <td class="text-center">
              <v-btn icon variant="text" color="blue" @click="abrirEdicao(item)">
                <v-icon>mdi-pencil</v-icon>
              </v-btn>
              <v-btn icon variant="text" color="red" @click="confirmarExclusao(item)">
                <v-icon>mdi-delete</v-icon>
              </v-btn>
            </td>
          </tr>
        </template>
      </v-data-table>
    </v-card>

    <!-- Dialog de Edição -->
    <v-dialog v-model="dialogEdicao" max-width="600px">
      <v-card>
        <v-card-title class="text-h6 font-weight-bold">Editar Usuário</v-card-title>
        <v-card-text>
          <v-form ref="formEdicao" v-model="valid">
            <v-text-field variant="outlined" rounded v-model="usuarioSelecionado.nome" label="Nome"
              prepend-inner-icon="mdi-account" />
            <v-text-field variant="outlined" rounded v-model="usuarioSelecionado.email" label="E-mail"
              prepend-inner-icon="mdi-email" />
            <v-text-field variant="outlined" rounded v-model="usuarioSelecionado.cpf" label="CPF"
              prepend-inner-icon="mdi-account-search" />
            <v-text-field variant="outlined" rounded v-model="usuarioSelecionado.senha" label="Senha" type="password"
              prepend-inner-icon="mdi-lock" disabled />

            <v-select v-model="usuarioSelecionado.cargo" :items="['admin', 'funcionario']" label="Cargo"
              prepend-inner-icon="mdi-briefcase" variant="outlined" rounded color="primary" />

            <v-divider class="my-4" />

            <v-select variant="outlined" rounded v-model="usuarioSelecionado.estado_uf"
              :items="localizacaoStore.estados" label="Estado" item-title="uf" item-value=""
              @update:model-value="onEstadoChange" :loading="localizacaoStore.loadingEstados" />

            <v-select variant="outlined" rounded v-model="usuarioSelecionado.cidade_id"
              :items="localizacaoStore.cidades" label="Cidade" item-title="name" item-value="id"
              :disabled="!usuarioSelecionado.estado_uf" :loading="localizacaoStore.loadingCidades" />

            <v-text-field variant="outlined" rounded v-model="usuarioSelecionado.bairro" label="Bairro"
              prepend-inner-icon="mdi-home-map-marker" />
            <v-text-field variant="outlined" rounded v-model="usuarioSelecionado.complemento" label="Complemento"
              prepend-inner-icon="mdi-text" />
            <v-text-field variant="outlined" rounded v-model="usuarioSelecionado.cep" label="CEP"
              prepend-inner-icon="mdi-home-map-marker" />
            <v-text-field variant="outlined" rounded v-model="usuarioSelecionado.logradouro" label="Logradouro"
              prepend-inner-icon="mdi-home-map-marker" />
            <v-text-field variant="outlined" rounded v-model="usuarioSelecionado.numero" label="Numero"
              prepend-inner-icon="mdi-home-map-marker" />
          </v-form>
        </v-card-text>

        <v-card-actions>
          <v-spacer />
          <v-btn color="grey" variant="text" @click="dialogEdicao = false">Cancelar</v-btn>
          <v-btn color="primary" @click="salvarEdicao">Salvar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- Dialog de Exclusão -->
    <v-dialog v-model="dialogExcluir" max-width="400px">
      <v-card>
        <v-card-title class="text-h6 font-weight-bold">Excluir Usuário</v-card-title>
        <v-card-text>
          Tem certeza que deseja excluir o usuário
          <strong>{{ usuarioSelecionado.nome }}</strong>?
        </v-card-text>
        <v-card-actions>
          <v-spacer />
          <v-btn variant="text" color="grey" @click="dialogExcluir = false">Cancelar</v-btn>
          <v-btn variant="elevated" color="red" @click="excluirUsuario">Excluir</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import { useUserStore } from '@/stores/userStore'
import { useLocalidadeStore } from '@/stores/localidadeStore'
import type { IUsuario } from '@/interfaces/User/IUsuario'

export default defineComponent({
  name: 'UserTable',

  data() {
    return {
      userStore: useUserStore(),
      localizacaoStore: useLocalidadeStore(),
      dialogEdicao: false,
      dialogExcluir: false,
      usuarioSelecionado: {} as IUsuario,
      valid: false,
      headers: [
        { title: 'Nome', key: 'nome' },
        { title: 'E-mail', key: 'email' },
        { title: 'CPF', key: 'cpf' },
        { title: 'Estado', key: 'estado' },
        { title: 'Cidade', key: 'cidade' },
        { title: 'Bairro', key: 'bairro' },
        { title: 'Cargo', key: 'cargo' },
        { title: 'Ações', key: 'acoes', sortable: false },
      ],
    }
  },

  computed: {
    usuarios(): IUsuario[] {
      return this.userStore.usuarios
    },
    loading(): boolean {
      return this.userStore.loading
    },
  },

  async mounted() {
    await Promise.all([
      this.userStore.buscarUsuarios(),
      this.localizacaoStore.buscarEstados(),
    ])
  },

  methods: {
    abrirEdicao(usuario: IUsuario) {
      console.log(usuario)
      this.usuarioSelecionado = { ...usuario }
      this.dialogEdicao = true
      if (usuario.estado_uf) {
        this.onEstadoChange(usuario.estado_uf)
      }
    },

    confirmarExclusao(usuario: IUsuario) {
      this.usuarioSelecionado = usuario
      this.dialogExcluir = true
    },

    async salvarEdicao() {
      try {
        await this.userStore.atualizarUsuario(this.usuarioSelecionado)
        console.log(this.usuarioSelecionado)
        this.dialogEdicao = false
      } catch {
        alert('Erro ao salvar alterações.')
      }
    },

    async excluirUsuario() {
      try {
        await this.userStore.excluirUsuario(this.usuarioSelecionado.id!)
        this.dialogExcluir = false
      } catch {
        alert('Erro ao excluir usuário.')
      }
    },

    async onEstadoChange(uf?: string) {
      const estadoUF = uf || this.usuarioSelecionado.estado_uf
      if (!estadoUF) return

      await this.localizacaoStore.buscarCidades(estadoUF)
    },
  },
})
</script>

<style scoped>
.card-table {
  border-radius: 20px;
}

.v-card-title {
  border-radius: 12px;
}

.v-btn {
  text-transform: none;
}

.v-data-table {
  border-radius: 12px;
}

.addBtn {
  display: flex;
  justify-content: center;
  margin-top: 20px;
  width: 100%;
}

.addBtn .v-btn {
  width: 20%;
  height: 80px;
}
</style>
