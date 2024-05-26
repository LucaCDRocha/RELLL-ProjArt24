<script setup>
import { Head } from "@inertiajs/vue3";
import TheNav from "@/Components/TheNav.vue";
import useDarkMode from "@/Composables/darkMode";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const { toggleDarkMode } = useDarkMode();
</script>

<template>
    <Head title="Settings" />

    <h1>Settings</h1>

    <div>
        <PrimaryButton @click="toggleDarkMode()"
            >Toggle dark mode</PrimaryButton
        >
        <SecondaryButton icon="search">Rechercher</SecondaryButton>
    </div>

    <div style="height: 5rem"></div>
    <TheNav />
</template>

<style scoped>
div {
    display: flex;
    flex-direction: row;
    gap: 0.5rem;
}
</style>
