<template>
  <v-container class="py-6" max-width="900px">
    <v-card elevation="10" class="pa-6">
      <v-card-title class="text-h5">Nova Movimentação</v-card-title>
      <v-divider class="my-4" />

      <v-form ref="formRef" v-model="valid" lazy-validation>
        <v-row dense>
          <v-col cols="12" sm="4">
            <v-select variant="outlined" rounded prepend-inner-icon="mdi-swap-vertical" v-model="movimentacao.tipo"
              :items="['E', 'S']" label="Tipo" required :rules="[rules.required]" />
          </v-col>

          <v-col cols="12" sm="4">
            <v-menu ref="menuData" v-model="menuData" :close-on-content-click="false" transition="scale-transition"
              max-width="290px">
              <template #activator="{ props }">
                <v-text-field variant="outlined" rounded prepend-inner-icon="mdi-calendar" v-model="movimentacao.data"
                  label="Data da Movimentação" readonly v-bind="props" :rules="[rules.required]" />
              </template>
              <v-date-picker v-model="movimentacao.data" @input="menuData = false"></v-date-picker>
            </v-menu>
          </v-col>

          <v-col cols="12" sm="4">
            <v-select variant="outlined" rounded prepend-inner-icon="mdi-account" v-model="movimentacao.funcionarioId"
              :items="usuarios" item-title="nome" item-value="id" label="Funcionário" :loading="loadingUsuarios"
              :rules="[rules.required]" required clearable no-data-text="Nenhum funcionário registrado" />
          </v-col>
        </v-row>

        <v-divider class="my-4" />

        <!-- Adicionar item -->
        <v-card class="pa-4 mb-4 elevation-5">
          <v-card-title class="mb-4">Adicione produtos à movimentação:</v-card-title>
          <v-row dense align="center">
            <v-col cols="12" md="4">
              <v-select variant="outlined" rounded prepend-inner-icon="mdi-package-variant"
                v-model="linhaTemp.produtoId" :items="produtos" item-title="nome" item-value="id" label="Produto"
                :loading="loadingProdutos" :rules="[rules.required]" no-data-text="Nenhum produto disponível" />
            </v-col>


            <v-col cols="12" md="5">
              <v-select variant="outlined" rounded prepend-inner-icon="mdi-package-variant" v-model="linhaTemp.loteId"
                :items="lotes" item-title="descricao" item-value="id" label="Lote" :loading="loadingLotes"
                :rules="[rules.required]" no-data-text="Nenhum lote registrado" />
            </v-col>

            <v-col cols="12" md="3">
              <v-text-field variant="outlined" rounded prepend-inner-icon="mdi-cash-multiple" v-model="linhaTemp.preco"
                label="Preço" prefix="R$" :rules="[rules.required]" @input="formatarPreco" />
            </v-col>

            <v-col cols="12" md="2">
              <v-text-field variant="outlined" rounded prepend-inner-icon="mdi-counter"
                v-model.number="linhaTemp.quantidade" label="Quantidade" type="number"
                :rules="[rules.required, rules.positiveNumber]" min="1" />
            </v-col>


            <v-col cols="12" md="4">
              <v-select variant="outlined" rounded prepend-inner-icon="mdi-truck" v-model="linhaTemp.fornecedorId"
                :items="fornecedores" item-title="nome" item-value="id" label="Fornecedor"
                :loading="loadingFornecedores" :rules="[rules.required]" no-data-text="Nenhum fornecedor registrado" />
            </v-col>
          </v-row>

          <v-row>
            <v-col cols="12" class="d-flex justify-end">
              <v-btn class="gradient-btn" @click="adicionarLinha">
                <v-icon left>mdi-plus</v-icon> Adicionar Item
              </v-btn>
            </v-col>
          </v-row>
        </v-card>

        <!-- Tabela de itens adicionados -->
        <v-data-table :headers="itensHeaders" :items="movimentacao.itens" class="elevation-1" dense hide-default-footer
          item-value="produtoId">
          <template v-slot:item="{ item, index }">
            <tr>
              <td>{{ item.produtoNome }}</td>
              <td>{{ item.fornecedorNome }}</td>
              <td>{{ item.loteDescricao }}</td>
              <td>{{ item.quantidade }}</td>
              <td>R$ {{ item.preco }}</td>
              <td class="text-center">
                <v-btn icon color="red" @click="removerLinha(index)">
                  <v-icon>mdi-delete</v-icon>
                </v-btn>
              </td>
            </tr>
          </template>
        </v-data-table>

        <v-row class="mt-4">
          <v-col cols="12" class="d-flex justify-end">
            <v-btn color="grey" class="me-2" @click="resetForm">Limpar</v-btn>
            <v-btn color="success" @click="salvarMovimentacao">
              Salvar Movimentação
            </v-btn>
          </v-col>
        </v-row>
      </v-form>
    </v-card>
  </v-container>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import { useMovimentacaoStore } from '@/stores/movimentacaoStore'
import { useProductStore } from '@/stores/productStore'
import { useFornecedorStore } from '@/stores/fornecedorStore'
import { useUserStore } from '@/stores/userStore'
import { useloteStore } from '@/stores/loteStore'
import { useEstoqueStore } from '@/stores/estoqueStore'
import type { IProduto } from '@/interfaces/Product/IProduto'
import type { IUsuario } from '@/interfaces/User/IUsuario'
import type { IMovimentacao } from '@/interfaces/Moviment/IMovimentacao'
import type { IItemMovimentacao } from '@/interfaces/Moviment/IItemMovimentacao'
import type { ILote } from '@/interfaces/Lote/ILote'
import type { IFornecedor } from '@/interfaces/Fornecedor/IFornecedor'
import type { IEstoqueItem } from '@/interfaces/Estoque/IEstoqueItem'

export default defineComponent({
  name: 'MovimentacaoForm',

  data() {
    return {
      valid: false,
      menuData: false,
      movimentacaoStore: useMovimentacaoStore(),
      productStore: useProductStore(),
      fornecedorStore: useFornecedorStore(),
      userStore: useUserStore(),
      loteStore: useloteStore(),
      estoqueStore: useEstoqueStore(),

      movimentacao: {
        tipo: 'E',
        data: new Date().toISOString().substr(0, 10),
        funcionarioId: null,
        itens: []
      } as IMovimentacao,

      linhaTemp: {
        produtoId: '',
        fornecedorId: '',
        loteId: '',
        validade: '',
        quantidade: 1,
        preco: ''
      } as any,

      loadingProdutos: false,
      loadingUsuarios: false,
      loadingFornecedores: false,
      loadingLotes: false,

      rules: {
        required: (v: any) => !!v || 'Campo obrigatório',
        positiveNumber: (v: number) => v > 0 || 'Deve ser maior que zero',
      },

      itensHeaders: [
        { title: 'Produto', key: 'produtoNome' },
        { title: 'Fornecedor', key: 'fornecedorNome' },
        { title: 'Lote', key: 'lote' },
        { title: 'Quantidade', key: 'quantidade' },
        { title: 'Preço', key: 'preco' },
        { title: 'Ações', key: 'acoes', sortable: false }
      ]
    }
  },

  computed: {
    produtos(): IProduto[] {
      return this.productStore.produtos
    },
    produtoTemp(): IProduto | undefined {
      return this.produtos.find(p => p.id === this.linhaTemp.produtoId)
    },
    fornecedores(): IFornecedor[] {
      return this.fornecedorStore.fornecedores
    },
    usuarios(): IUsuario[] {
      return this.userStore.usuarios
    },
    lotes(): ILote[] {
      return this.loteStore.lotes
    },
    estoque(): IEstoqueItem[]{
      return this.estoqueStore.estoque
    }
  },

  async mounted() {
    await Promise.all([
      this.productStore.buscarProdutos(),
      this.userStore.buscarUsuarios(),
      this.fornecedorStore.buscarFornecedores(),
      this.loteStore.buscarLotes(),
      this.estoqueStore.carregarEstoque()
    ])
  },

  methods: {
    formatarPreco(e: Event) {
      const target = e.target as HTMLInputElement
      if (!target) return

      let value = target.value.replace(/\D/g, '') // remove tudo que não for número
      if (!value) {
        this.linhaTemp.preco = ''
        return
      }
      value = (parseInt(value, 10) / 100).toFixed(2) + ''; // coloca os centavos
      value = value.replace('.', ','); // troca ponto por vírgula
      value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // adiciona separador de milhar
      this.linhaTemp.preco = value;
    },

    validarLinhaTemp(): boolean {
      if (!this.linhaTemp.produtoId) return alert('Selecione um produto'), false
      if (!this.linhaTemp.fornecedorId) return alert('Selecione um fornecedor'), false
      if (!this.linhaTemp.loteId) return alert('Informe o número do lote'), false
      const produto = this.produtos.find(p => p.id === this.linhaTemp.produtoId)
      if (!this.linhaTemp.quantidade || this.linhaTemp.quantidade <= 0)
        return alert('Informe uma quantidade válida (>0)'), false
      const precoNumerico = parseFloat(
        String(this.linhaTemp.preco).replace(',', '.').replace(/\./g, '')
      )

      if (!precoNumerico || precoNumerico <= 0)
        return alert('Informe um preço válido (>0)'), false
      return true
    },

    adicionarLinha() {
      if (!this.validarLinhaTemp()) return

      const produto = this.produtos.find(p => p.id === this.linhaTemp.produtoId)
      const fornecedor = this.fornecedores.find(f => f.id === this.linhaTemp.fornecedorId)
      const lote = this.lotes.find(l => l.id === this.linhaTemp.loteId)

      // Se for uma saída, valida o estoque disponível
      if (this.movimentacao.tipo === 'S') {
        const itemEstoque = this.estoqueStore.estoque.find(
          e => e.produtoId === this.linhaTemp.produtoId && e.lote === (lote ? lote.descricao : '')
        )

        if (!itemEstoque) {
          alert('Esse produto e lote não existem no estoque.')
          return
        }

        if (this.linhaTemp.quantidade > itemEstoque.saldo) {
          alert(`Quantidade indisponível! Estoque atual: ${itemEstoque.saldo}`)
          return
        }
      }

      const item: IItemMovimentacao = {
        produtoId: this.linhaTemp.produtoId,
        fornecedorId: this.linhaTemp.fornecedorId,
        fornecedorNome: fornecedor ? fornecedor.nome : 'Fornecedor',
        produtoNome: produto ? produto.nome : 'Produto',
        loteId: this.linhaTemp.loteId,
        loteDescricao: lote ? lote.descricao : 'Lote',
        quantidade: Number(this.linhaTemp.quantidade),
        preco: parseFloat(
          String(this.linhaTemp.preco)
            .replace(/\./g, '')   // remove separador de milhar
            .replace(',', '.')    // converte vírgula em ponto
        )
      }

      this.movimentacao.itens.push(item)

      this.linhaTemp = {
        produtoId: '',
        fornecedorId: '',
        loteId: '',
        validade: '',
        quantidade: 1,
        preco: ''
      }
    },

    removerLinha(index: number) {
      this.movimentacao.itens.splice(index, 1)
    },

    resetForm() {
      this.movimentacao = {
        tipo: 'E',
        data: new Date().toISOString().substr(0, 10),
        funcionarioId: null,
        itens: []
      }
      this.linhaTemp = { produtoId: '', fornecedorId: '', loteId: '', validade: '', quantidade: 1, preco: '' }
        ; (this.$refs.formRef as any).resetValidation?.()
    },

    async salvarMovimentacao() {
      const form = this.$refs.formRef as any
      if (!form.validate()) return
      if (!this.movimentacao.itens.length)
        return alert('Adicione ao menos 1 item à movimentação')
      if (!this.movimentacao.funcionarioId)
        return alert('Selecione o funcionário responsável')

      try {
        await this.movimentacaoStore.salvarMovimentacao(this.movimentacao)
        alert('Movimentação salva com sucesso!')
        this.resetForm()
      } catch (error) {
        console.error('Erro ao salvar movimentação:', error)
        alert('Erro ao salvar movimentação')
        console.log(this.movimentacao)
      }
    }
  }
})
</script>

<style scoped>
.v-card {
  border-radius: 14px;
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
