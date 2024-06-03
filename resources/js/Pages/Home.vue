<script setup>
import { Head } from "@inertiajs/vue3";
import TheNav from "@/Components/TheNav.vue";
import AppCardList from "@/Components/AppCardList.vue";
import TheHeader from "@/Components/TheHeader.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const props = defineProps({
    trails: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <Head title="Home" />

    <TheHeader />

    <SecondaryButton @click="$inertia.visit('/search')" icon="search"
        >Rechercher</SecondaryButton
    >

    <div class="home">
        <AppCardList :datas="trails"
            >Les parcours les plus populaires</AppCardList
        >
        <AppCardList :datas="trails[0].interest_points"
            >Les points d’intérêts les mieux notés</AppCardList
        >
        <AppCardList :datas="trails[1].interest_points"
            >Les différentes catégories</AppCardList
        >
    </div>

    <TheNav />
</template>

<style scoped>
.home {
    padding: 1rem 0rem 0rem 1rem;
}
</style>
