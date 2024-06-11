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
    currentPointIndex.value = parseInt(window.location.hash.substring(1));
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

// read a summary at loud
const synth = window.speechSynthesis;
const utterThis = computed(() => {
    return new SpeechSynthesisUtterance(currentPoint.value.description);
});
const toggleReading = () => {
    console.log("start reading", currentPoint.value.description);
    if (synth.speaking) {
        synth.cancel();
        document.querySelector(".audio-guide")?.classList.remove("active");
    } else {
        synth.speak(utterThis.value);
        document.querySelector(".audio-guide")?.classList.add("active");
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

    window.location.hash = value;

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
            <SecondaryButton
                icon="volume_up"
                @click="toggleReading()"
                class="audio-guide"
                >Audio guide</SecondaryButton
            >
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
        :trail_id="props.trail.id"
        @next="next()"
        @previous="previous()"
    />
</template>

<style scoped>
#map {
    height: calc(var(--vh, 1vh) * 100 - 10rem);
}

:deep(.leaflet-bottom) {
    bottom: 15vh;
    right: 0.5rem;
    left: 0.5rem;
}

.bottom-sheet {
    @apply bg-surface dark:bg-darkSurface;

    position: fixed;
    bottom: 5rem;
    left: 0;
    width: 100%;
    height: 25vh;
    padding: 1rem;
    z-index: 1000;
    overflow: scroll;
    border-top-left-radius: 1rem;
    border-top-right-radius: 1rem;
    box-shadow: 0 -11px 10px rgba(50, 50, 93, 0.11),
        0 0px 5px rgba(0, 0, 0, 0.08);
}

.content {
    display: flex;
    align-items: flex-start;
    flex-direction: column;
    gap: 1rem;
}

.info {
    @apply bg-surface dark:bg-darkSurface;

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
    @apply text-error dark:text-darkError;

    width: fit-content;
}

.primary {
    align-self: flex-end;
}

.audio-guide.active :deep(.material-symbols-rounded) {
    font-variation-settings: "FILL" 1;
}
</style>
