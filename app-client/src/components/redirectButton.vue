<template>
    <div class="redirectBtn">
        <v-btn class="gradient-btn" variant="outlined" color="" @click="$router.push(to)">
            {{ text }}
        </v-btn>
    </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
export default defineComponent({
    name: "RedirectButton",
    props: {
        to: {
            type: String,
            required: true
        },
        text: {
            type: String,
            required: true
        }
    }
})
</script>

<style scoped>
.redirectBtn {
    display: flex;
    justify-content: center;
    margin-top: 20px;
    width: 100%;
}

</style>