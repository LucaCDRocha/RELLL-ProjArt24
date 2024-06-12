<script setup>
import { computed, onMounted, onUnmounted, ref, watch } from "vue";
import AppInterestPointInfo from "@/Components/AppInterestPointInfo.vue";
import BaseMap from "@/Components/BaseMap.vue";
import { trail } from "@/Stores/map.js";
import BaseBottomSheet from "@/Components/BaseBottomSheet.vue";
import AppTrailInfo from "@/Components/AppTrailInfo.vue";
import AppInterestPointAddTrail from "@/Components/AppInterestPointAddTrail.vue";
import TextInput from "@/Components/TextInput.vue";
import BaseDivider from "@/Components/BaseDivider.vue";
import DropDown from "@/Components/Dropdown.vue";
import BaseTag from "@/Components/BaseTag.vue";

const isOpen = ref(false);

const data = ref({});

const bottomSheet = (e) => {
    if (e.point.difficulty) {
        window.location.href = route("trails.show", e.point.id);
    } else {
        fetch(route("interestPoints.showJson", e.point.id))
            .then((response) => response.json())
            .then((datas) => {
                data.value = datas;
                isOpen.value = true;
                if (props.waypoints) {
                    isAdded.value = props.waypoints.interest_points.find(
                        (point) => point.id === data.value.id
                    )
                        ? true
                        : false;
                }
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
    window.location.hash = "";
};

const props = defineProps({
    points: {
        type: Array,
        default: () => [],
    },
    filters: {
        type: Array,
        default: () => [],
    },
    track: {
        type: Boolean,
        default: true,
    },
    waypoints: {
        type: Object,
        default: () => {},
        required: false,
    },
    toBounds: {
        type: Boolean,
        default: true,
        required: false,
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
    if (filter.name === "Tout désélectionner") {
        for (const filter of props.filters) {
            filter.selected = false;
        }
    }
};

const search = ref("");

const interestPointsResults = computed(() => {
    let filtered = props.points;
    if (search.value) {
        filtered = props.points.filter((interestPoint) =>
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

const isAdded = ref(false);
if (props.waypoints) {
    watch(props.waypoints, () => {
        isAdded.value = props.waypoints.interest_points.find(
            (point) => point.id === data.value.id
        )
            ? true
            : false;
    });
}

onUnmounted(() => {
    trail.value = null;
});

const emit = defineEmits(["add-point"]);
</script>

<template>
    <form @submit.prevent="" class="search-bar">
        <TextInput v-model="search" placeholder="Rechercher un lieu" />
        <span class="material-symbols-rounded" @click="search = ''">close</span>
        <button>
            <span class="material-symbols-rounded">search</span>
        </button>
        <DropDown>
            <template #trigger>
                <span class="material-symbols-rounded">filter_list</span>
            </template>
            <template #content>
                <div class="p-2">
                    <h2 class="text-lg font-bold">Filtres</h2>
                    <div class="flex flex-col gap-2">
                        <BaseTag
                            v-for="filter in props.filters"
                            :key="filter.name"
                            :tag="filter.name"
                            :selected="filter.selected"
                            class="cursor-pointer"
                            @click.prevent="switchFilter(filter)"
                        />
                        <BaseDivider class="searchDiv" />
                        <BaseTag
                            tag="Tout désélectionner"
                            :selected="false"
                            @click.prevent="
                                switchFilter({ name: 'Tout désélectionner' })
                            "
                            class="cursor-pointer"
                        />
                    </div>
                </div>
            </template>
        </DropDown>
    </form>
    <BaseDivider />

    <BaseMap
        :trakable="props.track"
        :track="props.track"
        :points="interestPointsResults"
        :waypoints="props.waypoints"
        :toBounds="props.toBounds"
        @marker-click="bottomSheet($event)"
    />
    <BaseBottomSheet
        v-if="isOpen"
        :isOpen="isOpen"
        @handle-close="closeBottomSheet()"
    >
        <AppInterestPointAddTrail
            v-if="props.waypoints"
            :data="data"
            :isAllreadyAdded="isAdded"
            @handle-close="closeBottomSheet()"
            @handle-point="bottomSheet($event)"
            @add-point="emit('add-point', $event)"
        />
        <AppTrailInfo
            v-else-if="data.difficulty"
            :data="data"
            @handle-close="closeBottomSheet()"
            @handle-point="bottomSheet($event)"
        />
        <AppInterestPointInfo
            v-else
            :data="data"
            @handle-close="closeBottomSheet()"
            @handle-point="bottomSheet($event)"
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
    padding: 1rem 0rem;
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

    position: absolute;
    top: 3rem;
    right: 1rem;
    cursor: pointer;

    display: flex;
    justify-content: center;
    align-items: center;

    border-radius: 0.2rem;

    height: 2rem;
    width: 2rem;
    z-index: 1000;
}

:deep(.content) {
    z-index: 1003;
    top: 5.4rem;
}
</style>
