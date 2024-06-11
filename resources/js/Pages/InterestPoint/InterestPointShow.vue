<script setup>
import { ref } from "vue";
import { Head } from "@inertiajs/vue3";
import AppInterestPointInfo from "@/Components/AppInterestPointInfo.vue";
import AppTrailInfo from "@/Components/AppTrailInfo.vue";
import BaseBottomSheet from "@/Components/BaseBottomSheet.vue";

const isOpen = ref(false);

const data = ref({});

const bottomSheet = (e) => {
    if (e.point.difficulty) {
        fetch(route("trails.showJson", e.point.id))
            .then((response) => response.json())
            .then((datas) => {
                data.value = datas;
                isOpen.value = true;
                const scroll = document.querySelector(
                    ".base-overlay-card__content"
                );
                scroll ? (scroll.scrollTop = 0) : null;
            });
    } else {
        fetch(route("interestPoints.showJson", e.point.id))
            .then((response) => response.json())
            .then((datas) => {
                data.value = datas;
                isOpen.value = true;
                const scroll = document.querySelector(
                    ".base-overlay-card__content"
                );
                scroll ? (scroll.scrollTop = 0) : null;
            });
    }
};

const closeBottomSheet = () => {
    isOpen.value = false;
    full.value = false;
};

const full = ref(false);
const toggleFull = () => {
    full.value = true;
};

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
    <Head title="Point d'intérêt" />

    <AppInterestPointInfo
        class="interest-point"
        :data="interestPoint"
        :full="true"
        @handle-close="goBack()"
        @handle-point="bottomSheet($event)"
    />

    <BaseBottomSheet
        v-if="isOpen"
        :isOpen="isOpen"
        @handle-close="closeBottomSheet()"
        @handle-full="toggleFull()"
    >
        <AppTrailInfo
            v-if="data.difficulty"
            :data="data"
            :full="full"
            @handle-close="closeBottomSheet()"
            @handle-point="bottomSheet($event)"
        />
        <AppInterestPointInfo
            v-else
            :data="data"
            :full="full"
            @handle-close="closeBottomSheet()"
            @handle-point="bottomSheet($event)"
        />
    </BaseBottomSheet>
</template>

<style scoped>
.interest-point {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    width: 100vw;
    height: fit-content;
    padding: 1rem 0rem 0rem 1rem;
    overflow: scroll;
}
</style>
