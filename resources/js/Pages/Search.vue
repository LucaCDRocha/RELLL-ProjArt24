<script setup>
import { computed, ref, watch } from "vue";
import { Head } from "@inertiajs/vue3";
import TheNav from "@/Components/TheNav.vue";
import BaseCard from "@/Components/BaseCard.vue";
import TextInput from "@/Components/TextInput.vue";
import BaseTag from "@/Components/BaseTag.vue";
import TheHeader from "@/Components/TheHeader.vue";
import BaseBottomSheet from "@/Components/BaseBottomSheet.vue";
import AppTrailInfo from "@/Components/AppTrailInfo.vue";
import AppInterestPointInfo from "@/Components/AppInterestPointInfo.vue";
import BaseDivider from "@/Components/BaseDivider.vue";

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
    filters: {
        type: Array,
        default: () => [],
    },
    difficulties: {
        type: Array,
        default: () => [],
    },
});

const search = ref("");

const trailsResults = computed(() => {
    let filtered = props.trails;
    if (search.value) {
        filtered = props.trails.filter((trail) =>
            trail.name
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
    return filtered.filter(
        (trail) =>
            filtersSelected.value.find(
                (filter) => filter.name === trail.difficulty
            ) ||
            trail.themes.find((theme) =>
                filtersSelected.value.find(
                    (filter) => filter.name === theme.name
                )
            )
    );
});

const interestPointsResults = computed(() => {
    let filtered = props.interestPoints;
    if (search.value) {
        filtered = props.interestPoints.filter((interestPoint) =>
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
        filtersSelected.value.find(
            (filter) => filter.name === interestPoint.tag.name
        )
    );
});

const filtersSelected = computed(() => {
    let selected = [];
    for (const filter of props.filters) {
        if (filter.selected) {
            selected.push(filter);
        }
    }
    for (const difficulty of props.difficulties) {
        if (difficulty.selected) {
            selected.push(difficulty);
        }
    }
    return selected;
});

const switchFilter = (filter) => {
    if (props.filters.find((f) => f.name === filter.name)) {
        props.filters.find((f) => f.name === filter.name).selected =
            !filter.selected;
    }
    if (props.difficulties.find((f) => f.name === filter.name)) {
        props.difficulties.find((f) => f.name === filter.name).selected =
            !filter.selected;
    }
};

const store = () => {
    // store the 5 last searches in the local storage
    if (search.value === "") return;

    let searches = JSON.parse(localStorage.getItem("searches")) || [];

    if (searches.includes(search.value)) {
        searches.splice(searches.indexOf(search.value), 1);
    }

    if (searches.length === 5) {
        searches.shift();
    }

    searches.push(search.value);
    localStorage.setItem("searches", JSON.stringify(searches));

    searchs.value = searches.reverse();
};

const searchs = ref(
    JSON.parse(localStorage.getItem("searches"))?.reverse() || []
);

const goBack = () => {
    window.history.back();
};
</script>

<template>
    <Head title="Search" />

    <TheHeader />

    <form @submit.prevent="" @change="store()" class="search-bar">
        <span class="material-symbols-rounded" @click="goBack()">arrow_back</span>
        <TextInput v-model="search" placeholder="Rechercher" />
        <span class="material-symbols-rounded" @click="search = ''">close</span>
        <button>
            <span class="material-symbols-rounded">search</span>
        </button>
    </form>
    <BaseDivider />

    <div class="search">
        <div>
            <BaseTag
                v-for="difficulty in props.difficulties"
                :key="difficulty.name"
                :tag="difficulty.name"
                :selected="difficulty.selected"
                @click.prevent="switchFilter(difficulty)"
            />
        </div>
        <BaseDivider />
        <div>
            <BaseTag
                v-for="filter in props.filters"
                :key="filter.name"
                :tag="filter.name"
                :selected="filter.selected"
                @click.prevent="switchFilter(filter)"
            />
        </div>

        <div
            class="resultats"
            v-if="search !== '' || filtersSelected.length !== 0"
        >
            <h2>
                Résultats ({{
                    interestPointsResults.length + trailsResults.length
                }})
            </h2>
            <h3>Sentiers</h3>
            <div>
                <BaseCard
                    v-for="trail in trailsResults"
                    :key="trail.id"
                    :data="trail"
                    @handle-point="BottomSheet($event)"
                />
            </div>

            <h3>Points d'intérêt</h3>
            <div>
                <BaseCard
                    v-for="interestPoint in interestPointsResults"
                    :key="interestPoint.id"
                    :data="interestPoint"
                    @handle-point="BottomSheet($event)"
                />
            </div>
        </div>
        <div v-else>
            <h2>Vos dernières recherches</h2>
            <ul v-if="searchs">
                <li v-for="sea in searchs" :key="sea" @click="search = sea">
                    {{ sea }}
                </li>
            </ul>
        </div>
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
.search {
    display: flex;
    flex-direction: column;
    padding: 1rem;
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
    @apply bg-green-100 dark:bg-green-800;
    @apply text-green-500 dark:text-green-300;
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
</style>
