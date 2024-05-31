<script setup>
import {
    map,
    marker,
    circle,
    trail,
    locate,
    customIcon,
    customIcon2,
    // updateView,
    // updatePosition,
} from "@/Stores/map.js";
import { icon } from "leaflet";
import { onMounted, onUnmounted } from "vue";

const props = defineProps({
    points: {
        type: Object,
        required: false,
    },
    waypoints: {
        type: Object,
        default: () => {},
        required: false,
    },
    draggable: {
        type: Boolean,
        default: true,
        required: false,
    },
    markerDraggable: {
        type: Boolean,
        default: false,
        required: false,
    },
    centerView: {
        type: Array,
        default: () => [46.5613, 6.6504],
        required: false,
    },
    trakable: {
        type: Boolean,
        default: false,
        required: false,
    },
    track: {
        type: Boolean,
        default: false,
        required: false,
    },
});

const emit = defineEmits(["marker-click"]);

onMounted(() => {
    map.value = L.map("map")
        .setView(props.centerView, 10)
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
        props.points.forEach((elem) => {
            const point = {
                latLng: L.latLng(
                    elem.location.latitude,
                    elem.location.longitude
                ),
                name: elem.name,
                open_season: elem.open_season,
                description: elem.description,
                tag: elem.tag,
                imgs: elem.imgs,
            };
            // create a marker for each point
            L.marker(point.latLng, { icon: customIcon.value })
                .addTo(map.value)
                .on("click", function () {
                    emit("marker-click", {
                        point: elem,
                    });
                });

            // L.marker(point, { icon: customIcon.value }).addTo(map.value);
        });
    }

    if (props.waypoints) {
        const waypoints = [
            {
                name: "Départ",
                latLng: L.latLng(
                    props.waypoints.location_start.latitude,
                    props.waypoints.location_start.longitude
                ),
                description: "Départ",
                tag: "Départ",
                imgs: [props.waypoints.img.img_path],
            },
        ];
        for (const point of props.waypoints.interest_points) {
            waypoints.push({
                name: point.name,
                latLng: L.latLng(
                    point.location.latitude,
                    point.location.longitude
                ),
                description: point.description,
                tag: point.tag,
                imgs: point.imgs,
            });
        }
        waypoints.push({
            name: "Arrivée",
            latLng: L.latLng(
                props.waypoints.location_end.latitude,
                props.waypoints.location_end.longitude
            ),
            description: "Arrivée",
            tag: "Arrivée",
            imgs: [props.waypoints.img.img_path],
        });

        trail.value = L.Routing.control({
            waypoints: waypoints,
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
                    draggable: props.markerDraggable,
                    icon: customIcon.value,
                }).on("click", function () {
                    emit("marker-click", {
                        point: wp,
                    });
                });
            },
            show: false,
        }).addTo(map.value);

        // change the position of the control
        trail.value.setPosition("bottomleft");

        // find the center of the routing by calculating the coordinates of the middle point
        // var lat = 0;
        // var lng = 0;
        // waypoints.forEach((point) => {
        //     lat += point.latLng.lat;
        //     lng += point.latLng.lng;
        // });

        // map.value.setView([lat / waypoints.length, lng / waypoints.length]);

        // calculate the zoom level to fit all the points
        var bounds = L.latLngBounds(waypoints.map((point) => point.latLng));
        map.value.fitBounds(bounds, { padding: [30, 30] });
    }

    if (props.trakable) {
        // marker.value = L.marker([0, 0], { icon: customIcon2.value }).addTo(
        //     map.value
        // );

        // circle.value = L.circle([0, 0], {
        //     color: "blue",
        //     fillColor: "blue",
        //     fillOpacity: 0.2,
        //     radius: 50,
        // }).addTo(map.value);

        // L.Control.Button = L.Control.extend({
        //     options: {
        //         position: "bottomright",
        //     },
        //     onAdd: function (map) {
        //         var container = L.DomUtil.create(
        //             "div",
        //             "leaflet-bar leaflet-control"
        //         );
        //         var button = L.DomUtil.create(
        //             "a",
        //             "leaflet-control-button material-symbols-rounded",
        //             container
        //         );
        //         button.textContent = "target";

        //         L.DomEvent.disableClickPropagation(button); // Empêche la propagation de clics vers la carte
        //         L.DomEvent.on(button, "click", function () {
        //             updateView();
        //         });

        //         L.DomEvent.on(button, "mouseover", function () {
        //             button.style.cursor = "pointer";
        //             button.style.userSelect = "none";
        //         });

        //         container.title = "Center";
        //         return container;
        //     },
        //     onRemove: function (map) {},
        // });

        // var customControl = new L.Control.Button();
        // customControl.addTo(map.value);

        // setInterval(() => {
        //     updatePosition();
        // }, 5000);

        locate.value = L.control
            .locate({
                position: "bottomright",
                setView: `${props.track ? "untilPan" : "false"}`,
                initialZoomLevel: 17,
                showPopup: false,
                enableHighAccuracy: true,
                watch: true,
                flyTo: true,
                icon: "material-symbols-rounded",
                iconElementTag: "span",
                iconLoading: "material-symbols-rounded",
                iconElementTagLoading: "span",
                onclick: function () {
                    map.value.setView();
                },
            })
            .addTo(map.value);

        const material = document.querySelector(".leaflet-control-locate span");
        material.innerHTML = "target";
        material.style.height = "100%";
        material.style.width = "100%";
        material.style.display = "flex";
        material.style.justifyContent = "center";
        material.style.alignItems = "center";

        locate.value.start(
            {
                setView: "untilPan",
                initialZoomLevel: 17,
                showPopup: false,
                enableHighAccuracy: true,
                watch: true,
                flyTo: true,
            },
            true
        );
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
