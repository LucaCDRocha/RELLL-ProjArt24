<script setup>
const props = defineProps({
    isOpen: {
        type: Boolean,
        default: false,
    },
})

const scrollUp = (e) => {
    document.querySelector('.base-overlay-card__content').style.top = `0`
    document.querySelector('.base-overlay-card__content').style.height = `100vh`

    document.querySelector('.base-overlay-card__content').scrollTop = 0
    emit('handle-full')
}

const emit = defineEmits(['handle-close', 'handle-full'])
</script>

<template>
    <div
        class="base-overlay-card"
        :open="isOpen"
        @click.self="emit('handle-close')"
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

    z-index: 1003;
}

.base-overlay-card[open] {
    background-color: rgba(0, 0, 0, 0.2);

    top: 0;

    transition: top 0.5s;
}

.base-overlay-card__content {
    @apply bg-surface dark:bg-darkSurface;

    display: flex;

    position: fixed;
    bottom: 0;
    padding: 1rem 0rem 1rem 1rem;

    border-top-left-radius: 2rem;
    border-top-right-radius: 2rem;

    width: 100vw;
    height: 50vh;

    overflow-y: scroll;
    overflow-x: hidden;

    transition: top 0.5s;

    box-shadow:
        0 -11px 10px rgba(50, 50, 93, 0.11),
        0 0px 5px rgba(0, 0, 0, 0.08);
}
</style>
