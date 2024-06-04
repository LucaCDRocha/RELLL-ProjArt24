<script setup>
import { ref } from "vue";
import { Head } from "@inertiajs/vue3";
import TheNav from "@/Components/TheNav.vue";
import AppCardList from "@/Components/AppCardList.vue";
import TheHeader from "@/Components/TheHeader.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
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

const props = defineProps({
    trails: {
        type: Array,
        default: () => [],
    },
    interestPoints: {
        type: Array,
        default: () => [],
    },
});

console.log(props.trails);
console.log(props.interestPoints);
</script>

<template>
    <Head title="Home" />

    <TheHeader />

    <SecondaryButton @click="$inertia.visit('/search')" icon="search"
        >Rechercher</SecondaryButton
    >

    <div class="home">
        <AppCardList :datas="trails" @handle-point="BottomSheet($event)"
            >Les parcours les plus populaires</AppCardList
        >
        <AppCardList :datas="interestPoints" @handle-point="BottomSheet($event)"
            >Les points d’intérêts les mieux notés</AppCardList
        >
        <!-- <AppCardList
            :datas="trails[1].interest_points"
            @handle-point="BottomSheet($event)"
            >Les différentes catégories</AppCardList
        > -->
    </div>

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

<style scoped>
.home {
    padding: 1rem 0rem 0rem 1rem;
}
</style>
