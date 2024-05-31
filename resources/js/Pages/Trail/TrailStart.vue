<script setup>
import { Head } from "@inertiajs/vue3";
import { ref, computed, watch, onMounted } from "vue";
import AppNavTrail from "@/Components/AppNavTrail.vue";
import BaseMap from "@/Components/BaseMap.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import BaseNavLink from "@/Components/BaseNavLink.vue";
import { map } from "@/Stores/map.js";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    trail: {
        type: Object,
        default: () => {},
    },
});

const lastIndex = props.trail.interest_points.length - 1;

const currentPointIndex = ref(0);
const currentPoint = computed(
    () => props.trail.interest_points[currentPointIndex.value]
);

watch(currentPointIndex, (value) => {
    console.log(value);
});

const next = () => {
    if (currentPointIndex.value < lastIndex) {
        currentPointIndex.value++;
    }
};

const previous = () => {
    if (currentPointIndex.value > 0) {
        currentPointIndex.value--;
    }
};

if (window.location.hash) {
    currentPointIndex.value = window.location.hash.substring(1) - 1;
}

onMounted(() => {
    window.location.hash = currentPointIndex.value+1;
    map.value.flyTo(
        [
            props.trail.interest_points[currentPointIndex.value].location
                .latitude,
            props.trail.interest_points[currentPointIndex.value].location
                .longitude,
        ],
        18,
        {
            duration: 2, // Set the duration of the transition in seconds
        }
    );
});

watch(currentPointIndex, (value) => {
    window.location.hash = currentPointIndex.value+1;
    map.value.flyTo(
        [
            props.trail.interest_points[currentPointIndex.value].location
                .latitude,
            props.trail.interest_points[currentPointIndex.value].location
                .longitude,
        ],
        18,
        {
            duration: 2, // Set the duration of the transition in seconds
        }
    );
});
</script>

<template>
    <Head title="Map" />

    <div class="info">
        <div class="info_content">
            <p>15 minutes jusqu'au prochain</p>
            <p>Lieu {{ currentPointIndex + 1 }}/{{ lastIndex + 1 }}</p>
        </div>
        <BaseNavLink class="quit" icon="cancel" @click.prevent="$inertia.visit(`/home`)"
            >Quitter</BaseNavLink
        >
    </div>

    <BaseMap :waypoints="trail" :trakable="true" />

    <div class="bottom-sheet">
        <div class="content">
            <h1>{{ currentPoint.name }}</h1>
            <SecondaryButton icon="volume_up">Audio guide</SecondaryButton>
            <p>{{ currentPoint.description }}</p>
            <PrimaryButton
                class="primary"
                @click="$inertia.visit(`/interest-point/${currentPoint.id}`)"
                >Voir plus</PrimaryButton
            >
        </div>
    </div>

    <AppNavTrail
        :index="currentPointIndex"
        :last-index="lastIndex"
        @next="next()"
        @previous="previous()"
    />
</template>

<style scoped>
#map {
    height: calc(var(--vh, 1vh) * 100 - 10rem);
}

:deep(.leaflet-bottom) {
    bottom: 10rem;
    right: 0.5rem;
    left: 0.5rem;
}

.bottom-sheet {
    @apply bg-green-50 dark:bg-green-950;

    position: fixed;
    bottom: 5rem;
    left: 0;
    width: 100%;
    height: 15rem;
    padding: 1rem;
    z-index: 1000;
    overflow: scroll;
    border-top-left-radius: 1rem;
    border-top-right-radius: 1rem;
    box-shadow: 0px -4px 4px rgba(0, 0, 0, 0.25);
}

.content {
    display: flex;
    align-items: flex-start;
    flex-direction: column;
    gap: 1rem;
}

.info {
    @apply bg-green-50 dark:bg-green-950;
    @apply ring ring-black ring-opacity-30 dark:ring-opacity-30;

    position: fixed;
    top: 1rem;
    left: 1rem;
    right: 1rem;

    display: flex;
    justify-content: space-between;
    align-items: center;
    z-index: 1000;

    padding: 1rem 1.5rem 1rem 1rem;

    border-radius: 0.8rem;
}

.quit {
    width: fit-content;
}

.primary {
    align-self: flex-end;
}
</style>
