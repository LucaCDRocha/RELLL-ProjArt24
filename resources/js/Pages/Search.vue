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

const filters = ref([]);

const filtersSelected = computed(() => {
    return filters.value.filter((filter) => filter.selected);
});

for (const trail of props.trails) {
    filters.value.push({ name: trail.difficulty, selected: false });
    for (const theme of trail.themes) {
        filters.value.push({ name: theme.name, selected: false });
    }
}
for (const interestPoint of props.interestPoints) {
    filters.value.push({ name: interestPoint.tag.name, selected: false });
}
filters.value = filters.value.filter(
    (filter, index, self) =>
        index ===
        self.findIndex(
            (t) => t.name === filter.name && t.selected === filter.selected
        )
);

const switchFilter = (filter) => {
    filters.value = filters.value.map((f) => {
        if (f.name === filter.name) {
            f.selected = !f.selected;
        }
        return f;
    });
};
</script>

<template>
    <Head title="Search" />

    <TheHeader />

    <div class="search">
        <h1>Search</h1>
        <TextInput v-model="search" />
        <BaseTag
            v-for="filter in filters"
            :key="filter.name"
            :tag="filter.name"
            :selected="filter.selected"
            @click.prevent="switchFilter(filter)"
        />
        <h2>Sentiers</h2>
        <div>
            <BaseCard
                v-for="trail in trailsResults"
                :key="trail.id"
                :data="trail"
                @handle-point="BottomSheet($event)"
            />
        </div>

        <h2>Points d'intérêt</h2>
        <div>
            <BaseCard
                v-for="interestPoint in interestPointsResults"
                :key="interestPoint.id"
                :data="interestPoint"
                @handle-point="BottomSheet($event)"
            />
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
</style>
