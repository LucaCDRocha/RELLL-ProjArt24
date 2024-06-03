<script setup>
import { computed, onMounted, onUnmounted, ref } from "vue";
import AppInterestPointInfo from "@/Components/AppInterestPointInfo.vue";
import BaseMap from "@/Components/BaseMap.vue";
import { trail } from "@/Stores/map.js";
import BaseBottomSheet from "@/Components/BaseBottomSheet.vue";
import { SwipeModal } from "@takuma-ru/vue-swipe-modal";
import TheCardNav from "./TheCardNav.vue";

const isOpen = ref(false);

const name = ref("Trail");
const open_season = ref("all");
const description = ref("Description");
const tag = ref("test");
const imgs = ref([]);

const data = computed(() => ({
    name: name.value,
    open_season: open_season.value,
    description: description.value,
    tag: tag.value,
    imgs: imgs.value,
}));

const toggleBottomSheet = () => {
    isOpen.value = !isOpen.value;
};

const props = defineProps({
    waypoints: {
        type: Array,
        default: () => [],
    },
});

// onMounted(() => {
//     updateView();
// });

const updateCardInfo = (e) => {
    name.value = e.point.name;
    open_season.value = e.point.open_season;
    description.value = e.point.description;
    tag.value = e.point.tag;
    imgs.value = e.point.imgs;
    toggleBottomSheet();
};

onUnmounted(() => {
    trail.value = null;
});
</script>

<template>
    <BaseMap
        :trakable="true"
        :track="true"
        :points="waypoints"
        @marker-click="updateCardInfo($event)"
    />
    <BaseBottomSheet
        v-if="isOpen"
        :isOpen="isOpen"
        @handle-open="toggleBottomSheet()"
    >
        <AppInterestPointInfo :data="data" @handle-open="toggleBottomSheet()" />
    </BaseBottomSheet>
</template>

<style>
#map {
    height: calc(100vh - 5rem);
    height: calc(var(--vh, 1vh) * 100 - 5rem);
    z-index: 0;
}
</style>
