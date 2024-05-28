<script setup>
import { onMounted, ref, watch } from "vue";
import BaseBottomSheet from "@/Components/BaseBottomSheet.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import BaseTag from "@/Components/BaseTag.vue";

const isOpen = ref(false);
const distance = ref(0);
const time = ref(0);
const name = ref("Trail");
const description = ref("Description");
const tags = ref(["Facile", "Moyen", "Difficile"]);

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
    const map = L.map("map")
        .setView([46.77911, 6.642196], 17)
        .setMaxZoom(19)
        .setMinZoom(10);

    L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
        maxZoom: 19,
        minZoom: 10,
        attribution:
            '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    }).addTo(map);

    L.Control.Button = L.Control.extend({
        options: {
            position: "topleft",
        },
        onAdd: function (map) {
            var container = L.DomUtil.create(
                "div",
                "leaflet-bar leaflet-control"
            );
            var button = L.DomUtil.create(
                "a",
                "leaflet-control-button material-symbols-rounded",
                container
            );
            button.textContent = "target";

            L.DomEvent.disableClickPropagation(button); // Empêche la propagation de clics vers la carte
            L.DomEvent.on(button, "click", function () {
                map.setView([46.77911, 6.642196], 17);
            });

            L.DomEvent.on(button, "mouseover", function () {
                button.style.cursor = "pointer";
                button.style.userSelect = "none";
            });

            container.title = "Center";
            return container;
        },
        onRemove: function (map) {},
    });

    var customControl = new L.Control.Button();
    customControl.addTo(map);

    let control = L.Routing.control({
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
    }).addTo(map);

    // get the information of the route
    control.on("routesfound", (e) => {
        const routes = e.routes;
        const summary = routes[0].summary;
        distance.value = summary.totalDistance;
        time.value = summary.totalTime;
    });
});
</script>

<template>
    <div id="map"></div>
    <BaseBottomSheet
        v-if="isOpen"
        :isOpen="isOpen"
        @handle-open="toggleBottomSheet()"
    >
        <h1>{{ name }}</h1>
        <p>{{ description }}</p>
        <div>
            <BaseTag
                v-for="tag in tags"
                :key="tag"
                :tag="tag"
                >{{ tag }}</BaseTag
            >
        </div>
        <p>Distance: {{ distance }} km</p>
        <p>Temps: {{ time }} min</p>
        <p>Difficulté: Facile</p>
        <p>Points d'intérêts: {{ props.waypoints.length }}</p>
        <p>Commentaires: 0</p>
        <div>
            <PrimaryButton>Valider</PrimaryButton>
            <SecondaryButton icon="close" @click="toggleBottomSheet()"
                >Fermer</SecondaryButton
            >
        </div>
    </BaseBottomSheet>
</template>

<style scoped>
#map {
    height: calc(100vh - 5rem);
    height: calc(var(--vh, 1vh) * 100 - 5rem);
    z-index: 0;
}
</style>
