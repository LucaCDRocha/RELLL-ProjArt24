<script setup>
import { Head } from "@inertiajs/vue3";
import { ref, onMounted, onUnmounted, watch } from "vue";
import TheNav from "@/Components/TheNav.vue";
import AppCardList from "@/Components/AppCardList.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";

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

    <h1>Home</h1>
    <ApplicationLogo class="w-20 h-20 fill-current text-gray-500" />

    <AppCardList :datas="data">Les parcours les plus populaires</AppCardList>
    <AppCardList :datas="data"
        >Les points d’intérêts les mieux notés</AppCardList
    >
    <AppCardList :datas="data">Les différentes catégories</AppCardList>

    <div style="height: 5rem"></div>
    <TheNav />
</template>

<style scoped></style>
