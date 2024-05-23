<script setup>
import { Head } from "@inertiajs/vue3";
import { ref, onMounted, onUnmounted, watch } from "vue";
import useDarkMode from "@/Composables/darkMode";

const { toggleDarkMode } = useDarkMode();

</script>

<template>
    <Head title="Home" />
    <button
        @click="toggleDarkMode()"
        class="px-4 py-2 text-sm font-semibold text-white bg-blue-500 rounded-lg"
    >
        Toggle Dark Mode
    </button>

    <h1
        class="text-xl font-semibold text-black dark:text-white dark:background-black"
    >
        Home
    </h1>
    <p class="text-sm text-gray-500 dark:text-gray-400">
        Welcome to your application
    </p>
</template>

<style scoped></style>
