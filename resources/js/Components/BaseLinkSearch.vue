<script setup>
import { ref } from "vue";
import TextInput from "@/Components/TextInput.vue";
import BaseDivider from "@/Components/BaseDivider.vue";

const no = ref("");
</script>

<template>
    <a href="/search">
        <div class="search-bar">
            <p>Rechercher des lieux ou sentiers</p>
            <span class="material-symbols-rounded">search</span>
        </div>
        <BaseDivider />
    </a>
</template>

<style scoped>
a {
    text-decoration: none;
    width: 100%;
}

.search-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    height: 4rem;
}

.search-bar > span {
    @apply bg-green-100 dark:bg-green-800;
    @apply text-green-500 dark:text-green-300;
    @apply rounded-full;
    @apply flex;
    @apply justify-center;
    @apply items-center;

    cursor: pointer;
    padding: 0.5rem;
}
</style>
