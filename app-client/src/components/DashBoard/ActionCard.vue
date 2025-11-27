<template>
  <v-card
    class="pa-6 text-center h-100 d-flex flex-column justify-center align-center"
    elevation="6"
    hover
    @click="go"
  >
    <v-icon :size="48" :color="color">{{ icon }}</v-icon>
    <div class="mt-4 text-h6">{{ title }}</div>
  </v-card>
</template>

<script lang="ts">
import { defineComponent } from 'vue'

export default defineComponent({
  name: 'ActionCard',
  props: {
    icon: { type: String, required: true },
    color: { type: String, required: false, default: 'primary' },
    title: { type: String, required: true },
    to: { type: String, required: true }
  },
  methods: {
    go(){
      this.$router.push(this.to)
    }
  }
})
</script>
