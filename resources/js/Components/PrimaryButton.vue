<template>
    <button
        class="inline-flex items-center px-4 py-2 bg-green-800 dark:bg-green-200 border border-transparent rounded-full font-semibold text-sm text-green-50 dark:text-green-800 hover:bg-green-700 dark:hover:bg-green-100 focus:bg-green-700 dark:focus:bg-green-50 active:bg-green-900 dark:active:bg-green-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-green-800 transition ease-in-out duration-150"
    >
        <slot />
    </button>
</template>

<style scoped>
button {
    height: 2.5rem;
}
</style>
