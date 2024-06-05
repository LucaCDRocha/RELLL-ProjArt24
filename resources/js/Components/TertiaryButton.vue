<template>
    <button>
        <slot />
    </button>
</template>

<style scoped>
button {
    @apply inline-flex items-center px-4 py-2;

    @apply text-base font-medium;
    @apply text-onSecondary dark:text-green-800;

    @apply bg-secondary dark:bg-green-200;
    @apply border rounded-full border-transparent shadow-sm;

    @apply hover:bg-green-700 dark:hover:bg-green-100;
    @apply hover:text-green-50 dark:hover:text-green-800;

    @apply active:bg-secondary dark:active:bg-green-300;
    @apply active:text-onSecondary dark:active:text-green-800;

    @apply focus:outline-none focus:ring-2 focus:ring-offset-2;
    @apply focus:ring-green-500 dark:focus:ring-green-600 dark:focus:ring-offset-green-800;
    @apply focus:border-green-500 dark:focus:border-green-600;
    @apply focus:bg-green-700 dark:focus:bg-green-50;

    @apply transition ease-in-out duration-150;

    height: 2.5rem;
}
</style>
