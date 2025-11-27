<template>
  <v-footer
    class="app-footer d-flex flex-column align-center justify-center text-center"
    elevation="0"
  >
  <v-divider class="my-6"> </v-divider>
    <v-container>
      <p class="text-h6 mb-1">StockManager &copy; {{ new Date().getFullYear() }}</p>
      <small class="text-body-2">Gerenciamento de produtos alimentícios</small>

      <div class="d-flex justify-center mt-5">
        <v-btn
          class="mx-3 my-1"
          icon="mdi-github"
          color="#550899"
          href="https://github.com/cmVitor"
          target="_blank"
          variant="outlined"
        ></v-btn>

        <v-btn
          class="mx-3 my-1"
          icon="mdi-linkedin"
          color="#550899"
          href="https://www.linkedin.com/in/vitor-martins-castanheira-749b1024a/"
          target="_blank"
          variant="outlined"
        ></v-btn>
      </div>
      <small class="text-body-3">Vitor Martins Castanheira</small>
    </v-container>
  </v-footer>
</template>

<script lang="ts">
import { defineComponent } from 'vue'

export default defineComponent({
  name: 'AppFooter',
})
</script>

<style scoped>
.app-footer {
  color: #6210aa;
  margin: auto; /* empurra o footer pro fim da tela */
  padding-top: 24px;
  padding-bottom: 24px;
}

.text-body-2 {
  opacity: 0.8;
  font-size: 0.9rem;
}
.v-footer{
  background-color: transparent;
}
</style>
