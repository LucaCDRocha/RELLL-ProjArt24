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
    @apply border-green-800 dark:border-green-200;
    @apply border rounded-full shadow-sm;

    @apply hover:bg-green-100 dark:hover:bg-green-900;

    @apply focus:outline-none focus:ring-2 focus:ring-offset-2;
    @apply focus:ring-green-500 dark:focus:ring-offset-green-800;

    @apply disabled:opacity-25;

    @apply transition ease-in-out duration-150;

    height: 2.5rem;
    gap: 0.5rem;
}
</style>
