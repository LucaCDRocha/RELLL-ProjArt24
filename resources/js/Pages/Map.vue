<script setup>
import { Head } from "@inertiajs/vue3";
import TheNav from "@/Components/TheNav.vue";
import AppMap from "@/Components/AppMap.vue";

const props = defineProps({
    interestPoints: {
        type: Array,
        default: () => [],
    },
});

</script>

<template>
    <Head title="Map" />

    <AppMap :waypoints="interestPoints" />
    
    <TheNav />
</template>

<style scoped>
#map {
    height: calc(var(--vh, 1vh) * 100 - 5rem);
}
</style>
