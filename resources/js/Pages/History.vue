<script setup>
import { ref } from "vue";
import TheNav from "@/Components/TheNav.vue";
import AppCardList from "@/Components/AppCardList.vue";
import BaseDivider from "@/Components/BaseDivider.vue";
import BaseBottomSheet from "@/Components/BaseBottomSheet.vue";
import AppTrailInfo from "@/Components/AppTrailInfo.vue";
import AppInterestPointInfo from "@/Components/AppInterestPointInfo.vue";

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
    window.location.hash = "bottom-sheet";
};

const closeBottomSheet = () => {
    isOpen.value = false;
    full.value = false;
    window.location.hash = "";
};

const full = ref(false);
const toggleFull = () => {
    full.value = true;
};

const datas = defineProps({
    historics: {
        type: Array,
        required: false,
        default: () => [],
    },
    myTrails: {
        type: Array,
        required: false,
        default: () => [],
    },
    isAdmin: {
        type: Number,
        required: false,
        default: 0,
    },
});
</script>

<template>
    <AppCardList
        :datas="historics"
        @handle-close="closeBottomSheet()"
        @handle-point="bottomSheet($event)"
        >Votre historique de sentiers</AppCardList
    >

    <BaseDivider v-if="isAdmin == 1" />

    <AppCardList
        v-if="isAdmin == 1"
        :datas="myTrails"
        @handle-close="closeBottomSheet()"
        @handle-point="bottomSheet($event)"
        >Les sentiers que vous avez créés</AppCardList
    >

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
