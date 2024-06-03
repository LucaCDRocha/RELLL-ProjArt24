<script setup>
import { computed, ref, watch } from "vue";
import { Head } from "@inertiajs/vue3";
import TheNav from "@/Components/TheNav.vue";
import BaseCard from "@/Components/BaseCard.vue";
import TextInput from "@/Components/TextInput.vue";
import BaseTag from "@/Components/BaseTag.vue";
import TheHeader from "@/Components/TheHeader.vue";

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

for (const trail of props.trails) {
    switch (trail.difficulty) {
        case 1:
            trail.difficulty = "Facile";
            break;
        case 2:
            trail.difficulty = "Moyen";
            break;
        case 3:
            trail.difficulty = "Difficile";
            break;
    }
}

const search = ref("");

const trailsResults = computed(() => {
    let filtered = props.trails;
    if (search.value) {
        filtered = props.trails.filter((trail) =>
            trail.name.toLowerCase().includes(search.value.toLowerCase())
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
                .includes(search.value.toLowerCase())
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
    console.log(filter);
};

watch(filters, (value) => {
    console.log(value);
});
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
            <a
                v-for="trail in trailsResults"
                :key="trail.id"
                :href="`/trails/${trail.id}`"
                ><img
                    :src="trail.img.img_path"
                    :alt="'Image de ' + trail.name"
                />{{ trail.name }}
                <BaseTag :tag="trail.difficulty" :selected="true" />
            </a>
        </div>

        <h2>Points d'intérêt</h2>
        <div>
            <a
                v-for="interestPoint in interestPointsResults"
                :key="interestPoint.id"
                :href="`/interestPoints/${interestPoint.id}`"
                ><img
                    :src="interestPoint.imgs[0].img_path"
                    :alt="'Image de ' + interestPoint.name"
                />{{ interestPoint.name }}</a
            >
        </div>
    </div>

    <TheNav />
</template>

<style scoped>
    .search {
        display: flex;
        flex-direction: column;
        padding: 1rem;
    }
</style>
