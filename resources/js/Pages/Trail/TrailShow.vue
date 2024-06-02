<script setup>
import AppTrailInfo from "@/Components/AppTrailInfo.vue";

const props = defineProps({
    trail: {
        type: Object,
        default: () => {},
    },
});

const goBack = () => {
    window.history.back();
};
</script>

<template>
    <AppTrailInfo class="trail-info" :data="trail" :full="true" @handle-open="goBack()" />
</template>

<style scoped>
.trail-info {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    width: 100vw;
    height: fit-content;
    padding: 1rem 0rem 0rem 1rem;
    overflow: scroll;
}
</style>
