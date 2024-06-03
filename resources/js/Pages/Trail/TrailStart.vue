<script setup>
import { Head } from "@inertiajs/vue3";
import { ref, computed, watch, onMounted } from "vue";
import AppNavTrail from "@/Components/AppNavTrail.vue";
import BaseMap from "@/Components/BaseMap.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import BaseNavLink from "@/Components/BaseNavLink.vue";
import {
    trail,
    trailInfo,
    calculateDurationBetweenWaypoints,
    flyTo,
    changeTrailMarker,
} from "@/Stores/map.js";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    trail: {
        type: Object,
        default: () => {},
    },
});

const summary = ref({ time: 0, distance: 0 });

const lastIndex = props.trail.interest_points.length + 1;

const currentPointIndex = ref(0);
const currentPoint = computed(() => {
    if (currentPointIndex.value === 0) {
        return {
            name: "Départ de la randonnée",
            description: `${props.trail.description} ${props.trail.info_transport}`,
        };
    } else if (currentPointIndex.value === lastIndex) {
        return {
            name: "Arrivée de la randonnée",
            description: `Vous êtes arrivé à destination. On espère que vous avez apprécié la randonnée.`,
        };
    } else {
        return props.trail.interest_points[currentPointIndex.value - 1];
    }
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
    currentPointIndex.value = parseInt(window.location.hash.substr(1));
}

const updateVisuelTrail = () => {
    if (currentPointIndex.value === 0) {
        flyTo(props.trail.location_start, 18, 2);
        changeTrailMarker(currentPointIndex.value);
    } else if (currentPointIndex.value === lastIndex) {
        flyTo(props.trail.location_end, 18, 2);
        changeTrailMarker(currentPointIndex.value);
    } else {
        flyTo(
            props.trail.interest_points[currentPointIndex.value - 1].location,
            18,
            2
        );
        changeTrailMarker(currentPointIndex.value);
    }
};

onMounted(() => {
    updateVisuelTrail();

    setTimeout(() => {
        summary.value = calculateDurationBetweenWaypoints(
            trailInfo.value.instructions,
            currentPointIndex.value,
            currentPointIndex.value + 1
        );
    }, 1000);
});

watch(currentPointIndex, (value) => {
    updateVisuelTrail();

    summary.value = calculateDurationBetweenWaypoints(
        trailInfo.value.instructions,
        currentPointIndex.value,
        currentPointIndex.value + 1
    );
});
</script>

<template>
    <Head title="Santier" />

    <div class="info">
        <div class="info_content">
            <p>{{ summary.time }} minutes jusqu'au prochain</p>
            <p>Lieu {{ currentPointIndex }}/{{ lastIndex }}</p>
        </div>
        <BaseNavLink
            class="quit"
            icon="cancel"
            @click.prevent="$inertia.visit(`/home`)"
            >Quitter</BaseNavLink
        >
    </div>

    <BaseMap :waypoints="props.trail" :trakable="true" />

    <div class="bottom-sheet">
        <div class="content">
            <h1>{{ currentPoint.name }}</h1>
            <SecondaryButton icon="volume_up">Audio guide</SecondaryButton>
            <p>{{ currentPoint.description }}</p>
            <PrimaryButton
                v-if="
                    currentPointIndex !== 0 && currentPointIndex !== lastIndex
                "
                class="primary"
                @click="$inertia.visit(`/interestPoints/${currentPoint.id}`)"
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
    @apply text-red-700 dark:text-red-500;

    width: fit-content;
}

.primary {
    align-self: flex-end;
}
</style>
