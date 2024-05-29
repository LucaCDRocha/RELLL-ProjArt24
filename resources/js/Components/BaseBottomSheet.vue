<script setup>
const isOpen = defineProps({
    type: Boolean,
    default: false,
});

const scrollUp = (e) => {
    document.querySelector(".base-overlay-card__content").style.top = `0`;
    document.querySelector(
        ".base-overlay-card__content"
    ).style.height = `100vh`;
};
</script>

<template>
    <div
        class="base-overlay-card"
        :open="isOpen"
        @click.self="$emit('handleOpen')"
    >
        <div
            class="base-overlay-card__content"
            @touchmove.once="scrollUp($event)"
            @scroll.once="scrollUp($event)"
        >
            <slot></slot>
        </div>
    </div>
</template>

<style scoped>
.base-overlay-card {
    position: fixed;
    top: 100vh;

    width: 100vw;
    height: 100vh;

    z-index: 1000;
}

.base-overlay-card[open] {
    @apply bg-transparent dark:bg-transparent;

    top: 0;
}

.base-overlay-card__content {
    @apply bg-green-50 dark:bg-green-950;

    display: flex;

    position: fixed;
    top: 50vh;
    padding: 1rem 1rem;

    border-top-left-radius: 2rem;
    border-top-right-radius: 2rem;

    width: 100vw;
    height: 50vh;

    overflow-y: scroll;
    overflow-x: hidden;
}
</style>
