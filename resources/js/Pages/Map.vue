<script setup>
import { computed, ref } from "vue";
import { Head } from "@inertiajs/vue3";
import TheNav from "@/Components/TheNav.vue";
import AppMap from "@/Components/AppMap.vue";
import TheHeader from "@/Components/TheHeader.vue";
import BaseLinkSearch from "@/Components/BaseLinkSearch.vue";
import TextInput from "@/Components/TextInput.vue";

const props = defineProps({
    interestPoints: {
        type: Array,
        default: () => [],
    },
    filters: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <Head title="Map" />

    <TheHeader />

    <!-- <BaseLinkSearch /> -->
    <AppMap :waypoints="interestPoints" :filters="filters" />

    <TheNav />
</template>

<style scoped></style>
