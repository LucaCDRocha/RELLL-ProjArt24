<script setup>
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
import TheNav from "@/Components/TheNav.vue";
import AppCardList from "@/Components/AppCardList.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";

const props = defineProps({
    trails: {
        type: Array,
        default: () => [],
    },
});

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

    <div class="home">
        <ApplicationLogo />

        <AppCardList :datas="trails"
            >Les parcours les plus populaires</AppCardList
        >
        <AppCardList :datas="trails[0].interest_points"
            >Les points d’intérêts les mieux notés</AppCardList
        >
        <AppCardList :datas="trails[1].interest_points">Les différentes catégories</AppCardList>
    </div>

    <TheNav />
</template>

<style scoped>
.home {
    padding: 1rem 0rem 0rem 1rem;
}
</style>
