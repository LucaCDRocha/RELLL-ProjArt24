<script setup>
import { ref, onMounted } from "vue";
import BaseNavLink from "@/Components/BaseNavLink.vue";

const props = defineProps({
    index: {
        type: Number,
        default: 0,
    },
    lastIndex: {
        type: Number,
        default: 0,
    },
});

const emit = defineEmits(["next", "previous"]);
</script>

<template>
    <div>
        <BaseNavLink
            v-if="props.index === 0"
            @click.prevent="$inertia.visit(`/home`)"
            icon="cancel"
            class="quit"
            >Quitter</BaseNavLink
        >
        <BaseNavLink v-else @click.prevent="emit('previous')" icon="arrow_back"
            >Point précédent</BaseNavLink
        >
        <BaseNavLink
            v-if="props.index !== props.lastIndex"
            @click.prevent="emit('next')"
            icon="arrow_forward"
            >Point suivant</BaseNavLink
        >
        <BaseNavLink
            v-else
            icon="check_circle"
            @click.prevent="$inertia.visit(`/home`)"
            >Terminer</BaseNavLink
        >
    </div>
</template>

<style scoped>
div {
    @apply bg-surfaceVariant dark:bg-darkSurfaceVariant;

    display: flex;
    justify-content: space-around;
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 1rem 0rem;

    z-index: 1001;
}

.quit {
    @apply text-error dark:text-darkError;
}
</style>
