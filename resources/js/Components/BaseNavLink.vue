<script setup>
const props = defineProps({
    icon: {
        type: String,
        default: "",
    },
    href: {
        type: String,
        default: "",
    },
});
</script>

<template>
    <a :href="href">
        <span class="material-symbols-rounded"> {{ icon }} </span>
        <slot />
    </a>
</template>

<style scoped>
a {
    @apply text-xs;

    display: flex;
    justify-content: center;
    flex-direction: column;
    align-items: center;

    width: 100%;
}

span {
    display: flex;
    align-self: center;
    justify-content: center;

    width: 60%;
    margin-bottom: 0.1rem;
    padding: 0.2rem;

    border: none;
    border-radius: 1.2rem;
}

span.active {
    @apply bg-primarySurface dark:bg-green-600;
}
</style>
