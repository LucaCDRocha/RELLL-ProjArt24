<script setup>
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
import TheNav from "@/Components/TheNav.vue";
import AppCardList from "@/Components/AppCardList.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";

const data = ref([
    {
        id: 1,
        name: "Château",
        description: "Le château de Lausanne",
        tag: "Facile",
        is_accessible: true,
    },
    {
        id: 2,
        name: "Art en ville de Lausanne",
        description: "Les oeuvres d'art de la ville de Lausanne",
        tag: "Moyen",
        is_accessible: true,
    },
    {
        id: 3,
        name: "33",
        description: "Le parcours du 33",
        tag: "Difficile",
        is_accessible: false,
    },
    {
        id: 4,
        name: "33",
        description: "Le parcours du 33",
        tag: "oui",
        is_accessible: false,
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
