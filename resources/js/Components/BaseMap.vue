<script setup>
import { map, marker, circle, trail, customIcon, updateView } from "@/Stores/map.js";
import { onMounted, onUnmounted } from "vue";

const props = defineProps({
    points: {
        type: Object,
        required: false,
    },
    waypoints: {
        type: Array,
        default: () => [],
        required: false,
    },
    draggable: {
        type: Boolean,
        default: true,
        required: false,
    },
    centerView: {
        type: Array,
        default: () => [46.77911, 6.642196],
        required: false,
    },
    trakable: {
        type: Boolean,
        default: false,
        required: false,
    },
});

const emit = defineEmits(["marker-click"]);

onMounted(() => {
    map.value = L.map("map")
        .setView(props.centerView, 17)
        .setMaxZoom(19)
        .setMinZoom(10);

    L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
        maxZoom: 19,
        minZoom: 10,
        attribution:
            '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    }).addTo(map.value);

    // change the place of the zoom control
    map.value.zoomControl.setPosition("bottomright");

    if (!props.draggable) {
        // disable dragging
        map.value.dragging.disable();

        // disable zooming
        map.value.touchZoom.disable();
        map.value.doubleClickZoom.disable();
        map.value.scrollWheelZoom.disable();

        // disable zoomControl
        map.value.zoomControl.remove();
    }

    if (props.points) {
        props.points.forEach((point) => {
            L.marker(point, { icon: customIcon.value }).addTo(map.value);
        });
    }

    if (props.waypoints) {
        trail.value = L.Routing.control({
            waypoints: props.waypoints,
            router: new L.Routing.OSRMv1({
                serviceUrl:
                    "https://routing.openstreetmap.de/routed-foot/route/v1",
            }),
            routeWhileDragging: true,
            draggableWaypoints: false,
            addWaypoints: false,
            lineOptions: {
                styles: [{ color: "#6938D3", opacity: 0.8, weight: 3 }],
            },
            createMarker: function (i, wp, nWps) {
                return L.marker(wp.latLng, {
                    draggable: props.draggable,
                    icon: customIcon.value,
                }).on("click", function () {
                    emit("marker-click", { name: wp.name, info: wp.info, tags: wp.tags });
                });
            },
            show: false,
        }).addTo(map.value);

        // change the position of the control
        trail.value.setPosition("bottomleft");

        // find the center of the routing by calculating the coordinates of the middle point
        var lat = 0;
        var lng = 0;
        props.waypoints.forEach((point) => {
            lat += point.latLng.lat;
            lng += point.latLng.lng;
        });

        map.value.setView([lat / props.waypoints.length, lng / props.waypoints.length]);
    }

    if (props.trakable) {
        marker.value = L.marker([0, 0], { icon: customIcon.value }).addTo(map.value);

        circle.value = L.circle([0, 0], {
            color: "blue",
            fillColor: "blue",
            fillOpacity: 0.2,
            radius: 50,
        }).addTo(map.value);

        L.Control.Button = L.Control.extend({
            options: {
                position: "bottomright",
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
                    updateView();
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
        customControl.addTo(map.value);
    }
});

onUnmounted(() => {
    trail.value = null;
});
</script>

<template>
    <div id="map"></div>
</template>

<style scoped></style>
