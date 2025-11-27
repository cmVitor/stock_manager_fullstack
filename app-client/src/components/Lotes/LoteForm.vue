<template>
    <v-container class="d-flex align-center justify-center fill-height">
        <v-card elevation="12" width="750" class="pa-6 card-form mt-10">
            <v-card-title class="text-h4 font-weight-bold text-center mb-1">
                Cadastro de Lote
            </v-card-title>
            <v-card-subtitle class="text-h6 text-center mb-6">
                Preencha os dados abaixo:
            </v-card-subtitle>

            <v-form ref="form" v-model="valid" lazy-validation>
                <v-row dense>
                    <v-col cols="12" sm="9">
                        <v-text-field v-model="lote.descricao" label="Descrição" prepend-inner-icon="mdi-text"
                            variant="outlined" color="primary" rounded
                            :rules="[rules.required]"/>
                    </v-col>

                    <v-col cols="12" sm="3">
                        <v-text-field variant="outlined" rounded v-model="lote.dataValidade" label="Validade"
                            type="date" :rules="[rules.validDate, rules.required]"/>
                    </v-col>

                </v-row>

                <v-divider class="my-6"></v-divider>

                <p class="text-h5 mb-4">Localização no Depósito</p>

                <v-row dense>
                    <v-col cols="12" sm="6">
                        <v-text-field v-model="lote.corredor" label="Corredor"
                            prepend-inner-icon="mdi-office-building-marker-outline" variant="outlined" color="primary"
                            rounded :rules="[rules.required]" />
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field v-model="lote.prateleira" label="Prateleira"
                            prepend-inner-icon="mdi-archive-marker-outline" variant="outlined" color="primary" rounded
                            :rules="[rules.required]" />
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field v-model="lote.secao" label="Seção" prepend-inner-icon="mdi-map-marker-radius"
                            variant="outlined" color="primary" rounded
                            :rules="[rules.required]"/>
                    </v-col>

                </v-row>

                <v-btn class="mt-6 gradient-btn" block size="large" @click="salvarLote">
                    <v-icon start>mdi-content-save</v-icon>
                    Registrar Lote
                </v-btn>
            </v-form>
        </v-card>
    </v-container>
</template>

<script lang="ts">
import { useloteStore } from '@/stores/loteStore';
import { defineComponent } from 'vue';
import type { ILote } from '@/interfaces/Lote/ILote';

export default defineComponent({
    name: 'LoteForm',
    data() {
        return {
            valid: false,
            loteStore: useloteStore(),
            lote: {
                descricao: '',
                dataValidade: '',
                corredor: '',
                prateleira: '',
                secao: ''
            } as ILote,
            rules: {
                required: (v: any) => !!v || 'Campo obrigatório',
                validDate: (v: string) => {
                    if (!v) return true

                    const date = new Date(v)
                    const today = new Date()

                    const onlyDate = new Date(today.toISOString().split('T')[0] ?? '') //remove a hora e evita que o tipo seja undefined
                    if (date < onlyDate) {
                        return 'A data de validade não pode estar no passado'
                    }

                    //Verifica se está no formato certo
                    const regex = /^\d{4}-\d{2}-\d{2}$/
                    if (!regex.test(v)) {
                        return 'Formato inválido (use dd-mm-aaaa)'
                    }

                    return true
                }
            }
        }
    },
    methods: {
        async salvarLote(e: Event) {
            e.preventDefault()
            const form = this.$refs.form as any
            const { valid } = await form.validate()
            if (!valid) {
                alert('Preencha os campos corretamente')
                return
            }

            try {
                await this.loteStore.salvarLote(this.lote)
                alert('Lote cadastrado com sucesso!')
                this.resetForm()
            } catch {
                alert('Erro ao salvar lote.')
            }
        },

        resetForm() {
            this.lote = {
                descricao: '',
                dataValidade: '',
                corredor: '',
                prateleira: '',
                secao: ''
            }
            const form = this.$refs.form as any
            form?.resetValidation?.()
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