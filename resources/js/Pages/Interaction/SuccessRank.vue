<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Merci" />
    <div class="success">
        <div>
            <h1>Votre avis a été ajouté !</h1>
            <p>Nous vous remercions d’avoir noté ce sentier.</p>
        </div>
        <PrimaryButton @click="$inertia.visit(`/home`)">
            Retour à l'accueil
        </PrimaryButton>
    </div>
</template>

<style scoped>
.success {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 100vh;
    gap: 2rem;
}
</style>
