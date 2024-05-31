<script setup>
import AppInterestPointInfo from "@/Components/AppInterestPointInfo.vue";
import TheNav from "@/Components/TheNav.vue";

const props = defineProps({
    interestPoint: {
        type: Object,
        default: () => {},
    },
});

const goBack = () => {
    window.history.back();
};
</script>

<template>
    <AppInterestPointInfo
        class="interest-point"
        :data="interestPoint"
        @handle-open="goBack()"
    />
</template>

<style scoped>
.interest-point {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    width: 100vw;
    height: fit-content;
    padding: 1rem 0rem 1rem 1rem;
}
</style>
