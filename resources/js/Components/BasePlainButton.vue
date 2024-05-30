<script setup>
defineProps({
    type: {
        type: String,
        default: "button",
    },
    icon: {
        type: String,
    },
});
</script>

<template>
    <button :type="type">
        <span class="material-symbols-rounded"> {{ icon }} </span>
        <slot />
    </button>
</template>

<style scoped>
button {
    @apply inline-flex items-center px-4 py-2;

    @apply font-semibold text-sm;
    @apply text-green-800 dark:text-green-200;

    @apply bg-green-50 dark:bg-green-950;

    height: 2.5rem;
    gap: 0.5rem;
}
</style>
