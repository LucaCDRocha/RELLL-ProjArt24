<script setup>
defineProps({
    imgs: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <div class="gallery">
        <img :src="imgs[0]" :alt="'Image 1'" />
        <div class="double">
            <img
                v-for="(img, index) in imgs.slice(1)"
                :key="index"
                :src="img"
                :alt="'Image ' + (index + 2)"
            />
        </div>
    </div>
</template>

<style scoped>
.gallery {
    display: flex;
    flex-direction: row;
    justify-content: center;
    width: 100%;
    height: 15rem;
    gap: 1rem;
    overflow-x: scroll;
}

img {
    border-radius: 0.6rem;
    height: 15rem;
    width: 13rem;
    object-fit: cover;
}

.double {
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    flex-wrap: wrap;
    gap: 1rem;
}

.double img {
    height: 7rem;
    border-radius: 0.6rem;
    object-fit: cover;
}
</style>
