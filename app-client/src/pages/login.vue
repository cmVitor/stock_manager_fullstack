<template>
    <v-container fluid>
        <div class="d-flex align-center justify-space-evenly">
            <v-img src="../../public/img/StockManagerBg.png" max-height="350"></v-img>
        <LoginForm></LoginForm>
        </div>
    </v-container>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
    name: 'Login'
})
</script>
