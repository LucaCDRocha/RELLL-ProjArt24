<script setup>
import BaseTag from "@/Components/BaseTag.vue";

defineProps({
    tag: {
        type: String,
        default: () => [],
    },
});
</script>

<template>
    <div class="card">
        <div class="tag">
            <BaseTag :tag="tag">{{ tag }}</BaseTag>
        </div>
        <p><slot /></p>
    </div>
</template>

<style scoped>
div.card {
    display: flex;
    flex-direction: column;
    align-self: center;
    justify-content: flex-end;
    
    height: 10rem;
    padding: 1rem;
    margin-right: 1rem;
    margin-bottom: 1rem;

    border-radius: 1.75rem;
    box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);
    
    background-color: beige;
    background:
        linear-gradient(180deg, rgba(32, 32, 32, 0) 0%, #202020 94.1%),
        white 50% / cover no-repeat
}

.tag {
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 0.6rem;
}

p {
    @apply text-xl text-green-50;

    width: 10rem;
}
</style>
