<script setup>
defineProps({
    isOpen: {
        type: Boolean,
        default: false,
    },
});

const scrollUp = (e) => {
    document.querySelector(".base-overlay-card__content").style.top = `0`;
    document.querySelector(
        ".base-overlay-card__content"
    ).style.height = `100vh`;
};

const emit = defineEmits(["handleOpen"]);
</script>

<template>
    <div
        class="base-overlay-card"
        :open="isOpen"
        @click.self="emit('handleOpen')"
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
    left: 0;

    width: 100vw;
    height: 100vh;

    transition: top 0.5s;

    z-index: 1000;
}

.base-overlay-card[open] {
    @apply bg-transparent dark:bg-transparent;

    top: 0;

    transition: top 0.5s;
}

.base-overlay-card__content {
    @apply bg-green-50 dark:bg-green-950;

    display: flex;

    position: fixed;
    top: 50vh;
    padding: 1rem 0rem 1rem 1rem;

    border-top-left-radius: 2rem;
    border-top-right-radius: 2rem;

    width: 100vw;
    height: 50vh;

    overflow-y: scroll;
    overflow-x: hidden;

    transition: top 0.5s;

    box-shadow: 0 -11px 10px rgba(50, 50, 93, 0.11),
        0 0px 5px rgba(0, 0, 0, 0.08);
}
</style>
