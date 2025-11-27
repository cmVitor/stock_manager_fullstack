<template>
    <v-container max-width="600px" class="py-6">
        <v-card class="pa-8 rounded-xl elevation-18 mx-auto" max-width="600">
            <v-card-title class="text-h5 font-weight-bold text-center mb-4">
                Gerenciador de Categoria
            </v-card-title>

            <v-divider class="mb-6"></v-divider>

            <v-card-title>Cadastrar Categoria</v-card-title>

            <v-form ref="form" v-model="valid" lazy-validation>
                <v-row>
                    <v-col cols="12" sm="8">
                        <v-text-field v-model="categoria.nome" label="Categoria" prepend-inner-icon="mdi-shape"
                            variant="outlined" color="primary" rounded :rules="[rules.required]" required />
                    </v-col>
                    <v-col cols="12" sm="4">
                        <v-btn @click="salvarCategoria" class="gradient-btn mt-2">
                            <v-icon start>mdi-content-save</v-icon>
                            Salvar
                        </v-btn>
                    </v-col>
                </v-row>
            </v-form>

            <v-divider class="my-8"></v-divider>

            <v-card-title>Categorias cadastradas</v-card-title>

            <v-data-table :headers="headers" :items="categorias" :loading="loading" class="elevation-1" item-value="id"
                hover no-data-text="Nenhuma categoria cadastrada">
                <template v-slot:item="{ item }" >
                    <tr>
                        <td>{{ item.id }}</td>
                        <td align="center">{{ item.nome }}</td>
                        <td align="right">
                            <v-btn icon variant="text" color="blue" @click="abrirEdicao(item)">
                                <v-icon>mdi-pencil</v-icon>
                            </v-btn>
                            <v-btn icon variant="text" color="red" @click="abrirDialogExcluir(item)">
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
                <v-card-title>Edição de Categoria</v-card-title>
                <v-divider></v-divider>

                <v-card-text>
                    <v-form ref="formEdicao" v-model="formValido">
                        <v-text-field variant="outlined" rounded v-model="categoriaEditando.nome" label="Nome"
                            prepend-inner-icon="mdi-shape" required />
                    </v-form>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn text @click="fecharDialog">Cancelar</v-btn>
                    <v-btn color="primary" :disabled="!formValido" @click="salvarEdicao">
                        Salvar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- Dialog de Exclusão -->
        <v-dialog v-model="dialogExcluir" max-width="400px">
            <v-card>
                <v-card-title class="text-h6 font-weight-bold">Excluir Produto</v-card-title>
                <v-card-text>
                    Tem certeza que deseja excluir a categoria
                    <strong>{{ categoriaSelecionada?.nome }}</strong>?
                </v-card-text>
                <v-card-actions>
                    <v-spacer />
                    <v-btn variant="text" color="grey" @click="dialogExcluir = false">Cancelar</v-btn>
                    <v-btn variant="elevated" color="red" @click="confirmarExclusao">Excluir</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

    </v-container>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import { useCategoriaStore } from '@/stores/categoriaStore'
import type { ICategoria } from '@/interfaces/Categoria/ICategoria'

interface Header {
    title: string
    key: string
}

export default defineComponent({
    name: 'CategoriaCrud',

    data() {
        return {
            valid: false,
            formValido: false,
            dialogEdicao: false,
            dialogExcluir: false,
            categoriaEditando: {} as ICategoria,
            categoriaSelecionada: null as ICategoria | null,
            categoria: {
                nome: ''
            } as ICategoria,
            headers: [
                { title: 'Id', key: 'id' },
                { title: 'Nome', key: 'nome', align: 'center' },
                { title: 'Ações', key: 'acoes', sortable: false, align: 'end' }
            ] as Header[],

            rules: {
                required: (v: string) => !!v || 'Campo obrigatório'
            },
        }
    },
    computed: {
        categoriaStore() {
            return useCategoriaStore()
        },

        categorias() {
            return this.categoriaStore.categorias
        },

        loading() {
            return this.categoriaStore.loading
        }
    },

    async mounted() {
        await this.categoriaStore.buscarCategorias()
    },

    methods: {
        async salvarCategoria() {
            const form = this.$refs.form as any
            const { valid } = await form.validate()
            if (!valid) {
                alert('Preencha os campos corretamente')
                return
            }

            const categoriaStore = useCategoriaStore()

            try {
                await categoriaStore.salvarCategoria(this.categoria)
                alert('Categoria cadastrada com sucesso!')
                this.resetForm()
            } catch (error) {
                console.error('Erro ao salvar categoria:', error)
                alert('Erro ao salvar categoria.')
            }
        },

        resetForm() {
            this.categoria = {
                nome: ''
            }
                ; (this.$refs.form as any).resetValidation()
        },

        abrirEdicao(categoria: ICategoria) {
            this.categoriaEditando = { ...categoria }
            this.dialogEdicao = true
        },

        fecharDialog() {
            this.dialogEdicao = false
            this.categoriaEditando = {} as ICategoria
        },

        async salvarEdicao() {
            await this.categoriaStore.atualizarCategoria(this.categoriaEditando)
            this.fecharDialog()
        },

        abrirDialogExcluir(categoria: ICategoria) {
            this.categoriaSelecionada = categoria
            this.dialogExcluir = true
        },

        async confirmarExclusao() {
            if (!this.categoriaSelecionada) return
            await this.categoriaStore.excluirCategoria(this.categoriaSelecionada.id!)
            this.dialogExcluir = false
            this.categoriaSelecionada = null
        }
    }
})
</script>

<style scoped>
.v-data-table {
    border-radius: 12px;
}
.v-card {
  border-radius: 16px;
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
