<script setup>
import { ref } from "vue";
import { Head } from "@inertiajs/vue3";
import AppTrailInfo from "@/Components/AppTrailInfo.vue";
import AppInterestPointInfo from "@/Components/AppInterestPointInfo.vue";
import BaseBottomSheet from "@/Components/BaseBottomSheet.vue";

const isOpen = ref(false);

const data = ref({});

const BottomSheet = (e) => {
    if (e.point.difficulty) {
        fetch(route("trails.showJson", e.point.id))
            .then((response) => response.json())
            .then((datas) => {
                data.value = datas;
                isOpen.value = true;
            });
    } else {
        fetch(route("interestPoints.showJson", e.point.id))
            .then((response) => response.json())
            .then((datas) => {
                data.value = datas;
                isOpen.value = true;
            });
    }
};

const closeBottomSheet = () => {
    isOpen.value = false;
};

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
    <Head title="Trail" />

    <AppTrailInfo
        class="trail-info"
        :data="trail"
        :full="true"
        @handle-close="goBack()"
        @handle-point="BottomSheet($event)"
    />

    <BaseBottomSheet
        v-if="isOpen"
        :isOpen="isOpen"
        @handle-close="closeBottomSheet()"
    >
        <AppTrailInfo
            v-if="data.difficulty"
            :data="data"
            @handle-close="closeBottomSheet()"
            @handle-point="BottomSheet($event)"
        />
        <AppInterestPointInfo
            v-else
            :data="data"
            @handle-close="closeBottomSheet()"
            @handle-point="BottomSheet($event)"
        />
    </BaseBottomSheet>
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
