<script setup>
const props = defineProps({
    imgs: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <div class="container">
        <div class="gallery">
            <div class="alone">
                <img :src="imgs[0]" :alt="'Image 1'" />
            </div>
            <div class="double">
                <div v-for="(img, index) in imgs.slice(1)" :key="index">
                    <img
                        :key="index"
                        :src="img"
                        :alt="'Image ' + (index + 2)"
                    />
                </div>
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
    align-items: flex-start;
    height: 16.4rem;
    gap: 1rem;
    overflow-x: scroll;
    padding-right: 1rem;
    scrollbar-width: thin;
}

.alone {
    flex: 0 0 fit-content;
    height: 15.3rem;
    width: 13.5rem;
    width: 100%;
}

img {
    border-radius: 1.75rem;
    width: 13.5rem;
    height: 15.3rem;
    object-fit: cover;
}

.double {
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
    flex-wrap: wrap;
    row-gap: 0.48rem;
    column-gap: 1rem;
    height: 15.5rem;
}

.double div {
    height: 7.45rem;
    width: 16rem;
}

.double img {
    height: 7.45rem;
    width: 16rem;
    border-radius: 1.75rem;
}
</style>
