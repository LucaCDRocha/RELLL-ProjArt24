<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
</script>

<template>
    <div class="the-header">
        <ApplicationLogo class="cursor-pointer" />
        <small
            >Ce site est un site web fictif réalisé dans le cadre d'un cours
            Bachelor.</small
        >
    </div>
</template>

<style scoped>
.the-header {
    @apply bg-surface dark:bg-darkSurface;

    position: sticky;
    top: 0;

    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    gap: 2rem;
    padding: 1rem;
    width: 100%;
    height: 5rem;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.25);

    z-index: 1001;
}

small {
    @apply text-xs;
}
</style>
