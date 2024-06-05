<script setup>
import { Head } from "@inertiajs/vue3";
import TheHeader from "@/Components/TheHeader.vue";
import TheNav from "@/Components/TheNav.vue";
</script>

<template>
    <Head title="Map" />

    <TheHeader />

    <div class="maintenance">
        <h1>Cette page est en maintenance.</h1>
        <p>Revenez plus tard.</p>
    </div>

    <TheNav />
</template>

<style scoped>
.maintenance{
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: calc(100vh - 5rem);
    text-align: center;
}
</style>
