<script setup>
const props = defineProps({
    type: {
        type: String,
        default: 'button',
    },
    icon: {
        type: String,
    },
})
</script>

<template>
    <button :type="type">
        <span class="material-symbols-rounded"> {{ icon }} </span>
        <slot />
    </button>
</template>

<style scoped>
button {
    @apply inline-flex items-center px-2 py-2;

    @apply text-base text-onSurface dark:text-darkOnSurface;

    @apply bg-transparent dark:bg-transparent;

    height: 2.5rem;
    gap: 0.6rem;
    width: 100%;
}
</style>
