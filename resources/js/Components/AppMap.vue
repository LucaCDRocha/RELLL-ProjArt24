<script setup>
import { computed, onMounted, onUnmounted, ref } from "vue";
import AppInterestPointInfo from "@/Components/AppInterestPointInfo.vue";
import BaseMap from "@/Components/BaseMap.vue";
import { trail } from "@/Stores/map.js";
import BaseBottomSheet from "@/Components/BaseBottomSheet.vue";
import AppTrailInfo from "@/Components/AppTrailInfo.vue";

const isOpen = ref(false);

const data = ref({});

const BottomSheet = (e) => {
    if (e.point.difficulty) {
        window.location.href = route("trails.show", e.point.id);
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
    waypoints: {
        type: Array,
        default: () => [],
    },
});

onUnmounted(() => {
    trail.value = null;
});
</script>

<template>
    <BaseMap
        :trakable="true"
        :track="true"
        :points="waypoints"
        @marker-click="BottomSheet($event)"
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

<style>
#map {
    height: calc(var(--vh, 1vh) * 100 - 14rem);
    z-index: 0;
}
</style>
