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
});
</script>

<template>
    <AppCardList
        :datas="historics"
        @handle-close="closeBottomSheet()"
        @handle-point="BottomSheet($event)"
        >Votre historique de sentiers</AppCardList
    >

    <BaseDivider />

    <AppCardList
        :datas="myTrails"
        @handle-close="closeBottomSheet()"
        @handle-point="BottomSheet($event)"
        >Les sentiers que vous avez créés</AppCardList
    >

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
    <TheNav />
</template>
