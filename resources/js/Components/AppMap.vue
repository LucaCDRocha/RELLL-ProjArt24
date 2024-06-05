<script setup>
import { computed, onUnmounted, ref } from "vue";
import AppInterestPointInfo from "@/Components/AppInterestPointInfo.vue";
import BaseMap from "@/Components/BaseMap.vue";
import { trail } from "@/Stores/map.js";
import BaseBottomSheet from "@/Components/BaseBottomSheet.vue";
import AppTrailInfo from "@/Components/AppTrailInfo.vue";
import TextInput from "@/Components/TextInput.vue";
import BaseDivider from "@/Components/BaseDivider.vue";
import DropDown from "@/Components/Dropdown.vue";
import BaseTag from "@/Components/BaseTag.vue";

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
    filters: {
        type: Array,
        default: () => [],
    },
});

const filtersSelected = computed(() => {
    let selected = [];
    for (const filter of props.filters) {
        if (filter.selected) {
            selected.push(filter);
        }
    }
    return selected;
});

const switchFilter = (filter) => {
    if (props.filters.find((f) => f.name === filter.name)) {
        props.filters.find((f) => f.name === filter.name).selected =
            !filter.selected;
    }
};

const search = ref("");

const interestPointsResults = computed(() => {
    let filtered = props.waypoints;
    if (search.value) {
        filtered = props.waypoints.filter((interestPoint) =>
            interestPoint.name
                .toLowerCase()
                .normalize("NFD")
                .replace(/[\u0300-\u036f]/g, "")
                .includes(
                    search.value
                        .toLowerCase()
                        .normalize("NFD")
                        .replace(/[\u0300-\u036f]/g, "")
                )
        );
    }
    if (filtersSelected.value.length === 0) return filtered;
    return filtered.filter((interestPoint) =>
        filtersSelected.value.every((filter) =>
            interestPoint.tags.find((tag) => tag.name === filter.name)
        )
    );
});

onUnmounted(() => {
    trail.value = null;
});
</script>

<template>
    <form @submit.prevent="" class="search-bar">
        <TextInput v-model="search" placeholder="Rechercher" />
        <span class="material-symbols-rounded" @click="search = ''">close</span>
        <button>
            <span class="material-symbols-rounded">search</span>
        </button>
    </form>
    <BaseDivider />

    <DropDown>
        <template #trigger>
            <span class="material-symbols-rounded">filter_list</span>
        </template>
        <template #content>
            <div class="p-2">
                <h2 class="text-lg font-bold">Filtres</h2>
                <BaseDivider />
                <div class="flex flex-col gap-2">
                    <BaseTag
                        v-for="filter in props.filters"
                        :key="filter.name"
                        :tag="filter.name"
                        :selected="filter.selected"
                        @click.prevent="switchFilter(filter)"
                    />
                </div>
            </div>
        </template>
    </DropDown>

    <BaseMap
        :trakable="true"
        :track="true"
        :points="interestPointsResults"
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

<style scoped>
#map {
    height: calc(var(--vh, 1vh) * 100 - 14.06rem);
    z-index: 0;
}

.search-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    gap: 1rem;
    height: 4rem;
}

.search-bar > button {
    @apply bg-primarySurface dark:bg-green-800;
    @apply text-onSurface dark:text-green-300;
    @apply rounded-full;
    @apply flex;
    @apply justify-center;
    @apply items-center;

    cursor: pointer;
    padding: 0.5rem;
}

:deep(input) {
    @apply w-full;
    @apply bg-transparent;

    box-shadow: none;
    border: none;
    z-index: 1;
}

:deep(.trigger) {
    @apply bg-green-50 dark:bg-green-900;

    position: fixed;
    top: 10rem;
    right: 0.5rem;
    cursor: pointer;

    display: flex;
    justify-content: center;
    align-items: center;

    border-radius: 0.2rem;

    height: 2rem;
    width: 2rem;
    z-index: 1000;
}
</style>
