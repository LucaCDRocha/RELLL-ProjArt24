<script setup>
import { Head } from "@inertiajs/vue3";
import TheNav from "@/Components/TheNav.vue";
import AppMap from "@/Components/AppMap.vue";
import TheHeader from "@/Components/TheHeader.vue";
import BaseLinkSearch from "@/Components/BaseLinkSearch.vue";

const props = defineProps({
    interestPoints: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <Head title="Map" />

    <TheHeader />

    <BaseLinkSearch />

    <AppMap :waypoints="interestPoints" />

    <TheNav />
</template>

<style scoped></style>
