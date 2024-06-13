<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue'
import { Head } from '@inertiajs/vue3'
</script>

<template>
    <Head title="Merci" />
    <div class="success">
        <div>
            <h1>Votre sentier a été ajouté !</h1>
            <p>Nous vous remercions de votre participation.</p>
        </div>
        <PrimaryButton @click="$inertia.visit(`/`)">
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
    padding: 1rem;
}

.success h1,
p {
    text-align: center;
}
</style>
