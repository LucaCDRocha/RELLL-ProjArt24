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
import BaseLinkSearch from "@/Components/BaseLinkSearch.vue";

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

const props = defineProps({
    trails: {
        type: Array,
        default: () => [],
    },
    interestPoints: {
        type: Array,
        default: () => [],
    },
    tags: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <Head title="Home" />

    <TheHeader />

    <BaseLinkSearch />

    <div class="home">
        <AppCardList :datas="trails" @handle-point="bottomSheet($event)"
            >Les sentiers les plus populaires</AppCardList
        >
        <AppCardList :datas="interestPoints" @handle-point="bottomSheet($event)"
            >Les lieux les plus récents</AppCardList
        >

        <h2>Les différents thèmes</h2>
        <div class="tags">
            <a
                v-for="tag in tags"
                :key="tag.id"
                :class="`bg-${tag.name
                    .toLowerCase()
                    .normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '')}`"
                :href="route('search', tag.id)"
            >
                {{ tag.name }}
            </a>
        </div>
    </div>

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

    <TheNav />
</template>

<style scoped>
.home {
    padding: 1rem 0rem 0rem 1rem;
}

.tags {
    @apply text-onSurface;

    display: flex;
    flex-direction: column;
    flex-wrap: wrap;
    gap: 0.625rem;
    margin-top: 1.25rem;
    margin-bottom: 2.25rem;
    align-content: flex-start;

    height: 12rem;
    width: 100%;
    overflow: auto;
}

.tags a {
    display: flex;
    width: 11.1875rem;
    height: 5.3125rem;
    padding: 0.625rem;
    justify-content: center;
    align-items: center;
    flex-shrink: 0;

    border-radius: 0.3125rem;
}
</style>
