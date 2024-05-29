<script setup>
import { computed, onMounted, onUnmounted, ref, watch } from "vue";
import BaseBottomSheet from "@/Components/BaseBottomSheet.vue";
import AppInterestPointInfo from "@/Components/AppInterestPointInfo.vue";
import BaseMap from "@/Components/BaseMap.vue";
import { map, trail, updateView } from "@/Stores/map.js";

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

watch(isOpen, (value) => {
    if (value) {
        document.body.style.overflow = "hidden";
    } else {
        document.body.style.overflow = "auto";
    }
});

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
    trail.value = L.Routing.control({
        waypoints: props.waypoints,
        router: new L.Routing.OSRMv1({
            serviceUrl: "https://routing.openstreetmap.de/routed-foot/route/v1",
        }),
        routeWhileDragging: true,
        draggableWaypoints: false,
        addWaypoints: false,
        lineOptions: {
            styles: [{ color: "#6938D3", opacity: 0.8, weight: 3 }],
        },
        show: false,
        createMarker: function (i, wp, nWps) {
            return L.marker(wp.latLng, {
                draggable: false,
                icon: L.icon({
                    iconUrl: "/img/location_on.svg",
                    iconSize: [30, 34],
                    iconAnchor: [15, 34],
                }),
            }).on("click", function () {
                name.value = wp.name;
                description.value = wp.info;
                tags.value = wp.tags;
                toggleBottomSheet();
            });
        },
    }).addTo(map.value);

    // change the position of the control
    trail.value.setPosition("bottomleft");

    // get the information of the route
    trail.value.on("routesfound", (e) => {
        const routes = e.routes;
        const summary = routes[0].summary;
        distance.value = summary.totalDistance;
        time.value = summary.totalTime;
    });

    updateView();
});

onUnmounted(() => {
    trail.value = null;
});
</script>

<template>
    <BaseMap />
    <BaseBottomSheet
        v-if="isOpen"
        :isOpen="isOpen"
        @handle-open="toggleBottomSheet()"
    >
        <AppInterestPointInfo
            :data="data"
            @handle-close="toggleBottomSheet()"
        />
    </BaseBottomSheet>
</template>

<style scoped>
#map {
    height: calc(100vh - 5rem);
    height: calc(var(--vh, 1vh) * 100 - 5rem);
    z-index: 0;
}
</style>
