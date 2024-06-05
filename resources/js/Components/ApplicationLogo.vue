<script setup>
const isDarkMode = JSON.parse(localStorage.getItem("darkMode"));
</script>

<template>
    <img
        v-if="isDarkMode"
        src="/img/logo/Logo_RGB_Blanc_grand.png"
        alt="Logo de VaudSentiers"
        @click="$inertia.visit('/home')"
    />
    <img
        v-else
        src="/img/logo/Logo_RGB_grand.png"
        alt="Logo de VaudSentiers"
        @click="$inertia.visit('/home')"
    />
</template>

<style scoped>
img {
    width: 10rem;
    height: auto;
}
</style>
