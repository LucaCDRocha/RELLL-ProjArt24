<script setup>
import { Head } from "@inertiajs/vue3";
import TheNav from "@/Components/TheNav.vue";
import AppMap from "@/Components/AppMap.vue";
import TheHeader from "@/Components/TheHeader.vue";

const props = defineProps({
    interestPoints: {
        type: Array,
        default: () => [],
    },
});

</script>

<template>
    <Head title="Map" />

    <TheHeader/>

    <AppMap :waypoints="interestPoints" />
    
    <TheNav />
</template>

<style scoped>
</style>
