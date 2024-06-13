<script setup>
import { computed, ref } from 'vue'
import { Head } from '@inertiajs/vue3'
import TheNav from '@/Components/TheNav.vue'
import AppMap from '@/Components/AppMap.vue'
import TheHeader from '@/Components/TheHeader.vue'
import BaseLinkSearch from '@/Components/BaseLinkSearch.vue'
import TextInput from '@/Components/TextInput.vue'

const props = defineProps({
    interestPoints: {
        type: Array,
        default: () => [],
    },
    filters: {
        type: Array,
        default: () => [],
    },
})
</script>

<template>
    <Head title="Map" />

    <TheHeader />

    <!-- <BaseLinkSearch /> -->
    <AppMap :points="interestPoints" :filters="filters" />

    <TheNav />
</template>

<style scoped>
#map {
    height: calc(var(--vh, 1vh) * 100 - 14.06rem);
    z-index: 0;
}
</style>
