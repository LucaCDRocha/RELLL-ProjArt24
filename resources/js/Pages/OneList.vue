<script setup>
import { Head, Link } from '@inertiajs/vue3';
import TheNav from "@/Components/TheNav.vue";
import BaseDivider from "@/Components/BaseDivider.vue";
import BasePlainButton from "@/Components/BasePlainButton.vue";
import BaseCard from "@/Components/BaseCard.vue";

const items = defineProps({
    trailsList: {
        type: Object,
        default: () => [],
    },
    listDetails: {
        type: Object,
        default: () => [],
    }
});

</script>
<template>

    <Head :title="listDetails.name" />

    <h1>{{ listDetails.name }}</h1>
    <Link :href="route('bookmark.index')"
        class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-offset-gray-800">
    Retour
    </Link>

    <BaseDivider />

    <div class="trailsList">
        <BaseCard v-for="trail in trailsList" :key="trail.id" :data="trail"></BaseCard>
        <BaseCard v-for="trail in trailsList" :key="trail.id" :data="trail"></BaseCard>
        <BaseCard v-for="trail in trailsList" :key="trail.id" :data="trail"></BaseCard>
        <BaseCard v-for="trail in trailsList" :key="trail.id" :data="trail"></BaseCard>
    </div>

    <TheNav />
</template>

<style scoped>
div.trailsList {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    height: 100%;
    gap: 1rem;
    padding-right: 1rem;
}
</style>
