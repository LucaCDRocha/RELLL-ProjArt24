<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue'
import { Head } from '@inertiajs/vue3'
</script>

<template>
    <Head title="Merci" />
    <div class="success">
        <div>
            <h1>Modification enregistrée!</h1>
        </div>
        <PrimaryButton @click="$inertia.visit('/profile')">
            Retour au profil
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

.success h1 {
    text-align: center;
}
</style>
