<script setup>
import { Head } from "@inertiajs/vue3";
import { ref, onMounted, onUnmounted, watch } from "vue";
import useDarkMode from "@/Composables/darkMode";
import TheNav from "@/Components/TheNav.vue";
import AppCardList from "@/Components/AppCardList.vue";

const { toggleDarkMode } = useDarkMode();

const data = ref([
    {
        name: "Château",
        tag: "Facile",
    },
    {
        name: "Art en ville de Lausanne",
        tag: "Moyen",
    },
    {
        name: "33",
        tag: "Difficile",
    },
    {
        name: "33",
        tag: "oui",
    },
]);
</script>

<template>
    <Head title="Home" />

    <button
        @click="toggleDarkMode()"
        class="px-4 py-2 text-sm font-semibold text-green-50 bg-blue-500 rounded-full"
    >
        Toggle Dark Mode
    </button>

    <h1>Home</h1>
    <p>Welcome to your application</p>
    <AppCardList :datas="data">Les parcours les plus populaires</AppCardList>
    <AppCardList :datas="data">Les points d’intérêts les mieux notés</AppCardList>
    <AppCardList :datas="data">Les différentes catégories</AppCardList>

    <div style="height: 5rem;"></div>
    <TheNav />
</template>

<style scoped></style>
