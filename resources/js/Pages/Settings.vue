<script setup>
import { Head } from "@inertiajs/vue3";
import TheNav from "@/Components/TheNav.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import BaseToggleButton from "@/Components/BaseToggleButton.vue";
import BaseDivider from "@/Components/BaseDivider.vue";
</script>

<template>
    <Head title="Settings" />

    <div class="settings">
        <h1>Settings</h1>

        <div>
            <PrimaryButton>Toggle dark mode</PrimaryButton>
            <SecondaryButton icon="search">Rechercher</SecondaryButton>
        </div>

        <BaseToggleButton label="Theme sombre" />

        <BaseDivider />
    </div>

    <div style="height: 5rem"></div>
    <TheNav />
</template>

<style scoped>
.settings {
    display: flex;
    flex-direction: column;
    gap: 1rem;

    padding: 1rem;
}

div {
    display: flex;
    flex-direction: row;
    gap: 0.5rem;
}
</style>
