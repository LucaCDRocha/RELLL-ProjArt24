<script setup>
// a modifier pour qu'il affiche les images !
import { computed } from 'vue'

const props = defineProps({
    imgs: {
        type: Array,
        required: true,
    },
    listName: {
        type: String,
        required: true,
    },
})

const displayedImages = computed(() => {
    if (props.imgs.length <= 4) {
        return props.imgs
    } else {
        return props.imgs.slice(0, 4)
    }
})
</script>

<template>
    <div class="image-grid">
        <img
            v-for="(image, index) in displayedImages"
            :key="index"
            :src="image"
            :alt="'Image ' + (index + 1)"
        />
        <div class="image-card">
            <span>{{ listName }}</span>
        </div>
    </div>
</template>

<style scoped>
.image-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    grid-template-rows: repeat(2, 1fr);
    gap: 10px;
}
.image-card {
    position: relative;
    background-color: #ccc;
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>
