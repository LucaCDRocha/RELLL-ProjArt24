<script setup>
defineProps({
    imgs: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <div class="container">
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
    </div>
</template>

<style scoped>
.container {
    width: calc(100vw - 1rem);
}

.gallery {
    display: flex;
    flex-direction: row;
    justify-content: center;
    height: 15rem;
    gap: 1rem;
    overflow-x: scroll;
    padding-right: 1rem;
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
    height: 15rem;
    width: auto;
}

.double img {
    height: 7rem;
    width: 15rem;
    border-radius: 0.6rem;
    object-fit: cover;
}
</style>
