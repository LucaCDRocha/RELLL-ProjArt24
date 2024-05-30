<script setup>
import { computed, onMounted, onUnmounted, ref, watch } from "vue";
import BaseBottomSheet from "@/Components/BaseBottomSheet.vue";
import AppInterestPointInfo from "@/Components/AppInterestPointInfo.vue";
import BaseMap from "@/Components/BaseMap.vue";
import {
    map,
    trail,
    marker,
    circle,
    customIcon,
    updateView,
} from "@/Stores/map.js";
import { SwipeModal } from "@takuma-ru/vue-swipe-modal";
import TheCardNav from "./TheCardNav.vue";

const isOpen = ref(false);
const distance = ref(0);
const time = ref(0);
const name = ref("Trail");
const description = ref("Description");
const tags = ref(["Facile", "Moyen", "Difficile"]);

const data = computed(() => ({
    name: name.value,
    description: description.value,
    tags: tags.value,
    distance: distance.value,
    time: time.value,
}));

const toggleBottomSheet = () => {
    isOpen.value = !isOpen.value;
};

const props = defineProps({
    waypoints: {
        type: Array,
        default: () => [],
    },
});

onMounted(() => {
    // trail.value = L.Routing.control({
    //     waypoints: props.waypoints,
    //     router: new L.Routing.OSRMv1({
    //         serviceUrl: "https://routing.openstreetmap.de/routed-foot/route/v1",
    //     }),
    //     routeWhileDragging: true,
    //     draggableWaypoints: false,
    //     addWaypoints: false,
    //     lineOptions: {
    //         styles: [{ color: "#6938D3", opacity: 0.8, weight: 3 }],
    //     },
    //     show: false,
    //     createMarker: function (i, wp, nWps) {
    //         return L.marker(wp.latLng, {
    //             draggable: false,
    //             icon: L.icon({
    //                 iconUrl: "/img/location_on.svg",
    //                 iconSize: [30, 34],
    //                 iconAnchor: [15, 34],
    //             }),
    //         }).on("click", function () {
    //             name.value = wp.name;
    //             description.value = wp.info;
    //             tags.value = wp.tags;
    //             toggleBottomSheet();
    //         });
    //     },
    // }).addTo(map.value);

    // change the position of the control
    // trail.value.setPosition("bottomleft");

    // get the information of the route
    trail.value.on("routesfound", (e) => {
        const routes = e.routes;
        const summary = routes[0].summary;
        distance.value = summary.totalDistance;
        time.value = summary.totalTime;
    });

    updateView();
});

const updateCardInfo = (point) => {
    name.value = point.name;
    description.value = point.info;
    tags.value = point.tags;
    toggleBottomSheet();
};

onUnmounted(() => {
    trail.value = null;
});
</script>

<template>
    <BaseMap
        :trakable="true"
        :waypoints="props.waypoints"
        @marker-click="updateCardInfo($event)"
    />
    <!-- <BaseBottomSheet
        v-if="isOpen"
        :isOpen="isOpen"
        @handle-open="toggleBottomSheet()"
    >
        <AppInterestPointInfo
            :data="data"
            @handle-close="toggleBottomSheet()"
        />
    </BaseBottomSheet> -->
    <SwipeModal
        v-model="isOpen"
        snapPoint="50dvh"
        :is-backdrop="true"
        :is-full-screen="true"
        :is-drag-handle="true"
        :is-persistent="false"
        :is-scroll-lock="true"
    >
        <template v-slot:backdrop>
            <div class="custom-backdrop-class-name" />
        </template>
        <AppInterestPointInfo
            :data="data"
            @handle-close="toggleBottomSheet()"
        />
    </SwipeModal>
</template>

<style>
#map {
    height: calc(100vh - 5rem);
    height: calc(var(--vh, 1vh) * 100 - 5rem);
    z-index: 0;
}
</style>
