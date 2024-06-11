<script setup>
import { ref, watch } from "vue";
import {
    map,
    trail,
    trailMarkers,
    locate,
    customIcon,
    customIconActive,
    customIconEnd,
    customIconStart,
    trailInfo,
} from "@/Stores/map.js";
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
    selectable: {
        type: Boolean,
        default: false,
        required: false,
    },
    pointsDraggable: {
        type: Boolean,
        default: false,
        required: false,
    },
    toBounds: {
        type: Boolean,
        default: true,
        required: false,
    },
});

const emit = defineEmits(["marker-click", "marker-location"]);

const createPoints = (points) => {
    points.forEach((elem) => {
        if (!elem.latLng) {
            elem.latLng = L.latLng(
                elem.location.latitude,
                elem.location.longitude
            );
        }
        // create a marker for each point
        L.marker(elem.latLng, {
            icon: customIcon.value,
            draggable: props.pointsDraggable,
        })
            .addTo(map.value)
            .on("click", function () {
                emit("marker-click", {
                    point: elem,
                });
            })
            .on("dragend", function (e) {
                emit("marker-location", {
                    point: {
                        latLng: e.target.getLatLng(),
                    },
                });
            });
    });
};

const updatePoints = (points) => {
    map.value.eachLayer((layer) => {
        if (
            layer instanceof L.Marker &&
            layer.options.icon === customIcon.value
        ) {
            map.value.removeLayer(layer);
        }
    });
    createPoints(points);
};

const createWaypoints = (dataWay) => {
    if (trail.value) {
        trail.value.remove();
    }

    const waypoints = [];
    if (dataWay.location_start) {
        waypoints.push({
            name: "Départ",
            latLng: L.latLng(
                dataWay.location_start.latitude,
                dataWay.location_start.longitude
            ),
            description: "Départ",
            tag: "Départ",
        });
    }
    if (dataWay.interest_points) {
        for (const point of dataWay.interest_points) {
            waypoints.push({
                id: point.id,
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
    }
    if (dataWay.location_end) {
        waypoints.push({
            name: "Arrivée",
            latLng: L.latLng(
                dataWay.location_end.latitude,
                dataWay.location_end.longitude
            ),
            description: "Arrivée",
            tag: "Arrivée",
        });
    }

    trail.value = L.Routing.control({
        waypoints: waypoints,
        router: new L.Routing.OSRMv1({
            serviceUrl: "https://routing.openstreetmap.de/routed-foot/route/v1",
        }),
        routeWhileDragging: true,
        draggableWaypoints: false,
        addWaypoints: false,
        lineOptions: {
            styles: [{ color: "#6938D3", opacity: 0.8, weight: 3 }],
        },
        createMarker: function (i, wp, nWps) {
            const marker = L.marker(wp.latLng, {
                draggable: props.markerDraggable,
                icon:
                    wp.name === "Départ"
                        ? customIconStart.value
                        : wp.name === "Arrivée"
                        ? customIconEnd.value
                        : customIcon.value,
            }).on("click", function () {
                if (wp.name === "Départ" || wp.name === "Arrivée") {
                    return;
                } else {
                    emit("marker-click", {
                        point: wp,
                    });
                }
            });
            trailMarkers.value.push(marker);
            return marker;
        },
        show: false,
    }).addTo(map.value);

    // change the position of the control
    trail.value.setPosition("bottomleft");

    trail.value.on("routesfound", (e) => {
        trailInfo.value = e.routes[0];
    });

    if (props.toBounds) {
        // calculate the zoom level to fit all the points
        var bounds = L.latLngBounds(waypoints.map((point) => point.latLng));
        if (bounds.isValid()) {
            map.value.fitBounds(bounds, { padding: [30, 30] });
        }
    }
};

watch(
    () => props.points,
    (points) => {
        updatePoints(points);
    }
);

watch(
    () => props.waypoints,
    (waypoints) => {
        createWaypoints(waypoints);
    },
    { deep: true }
);

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
        createPoints(props.points);
    }

    if (props.waypoints) {
        createWaypoints(props.waypoints);
    }

    if (props.trakable) {
        locate.value = L.control
            .locate({
                position: "bottomright",
                setView: `${props.track ? "untilPan" : "false"}`,
                initialZoomLevel: 17,
                showPopup: false,
                enableHighAccuracy: true,
                watch: true,
                flyTo: true,
                maximumAge: 1000,
                timeout: 10000,
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
                maximumAge: 1000,
                timeout: 10000,
                enableHighAccuracy: true,
                watch: true,
                flyTo: true,
            },
            true
        );
    }

    // make that we can click on the map and create a marker that we can move
    if (props.selectable) {
        map.value.on("click", function (e) {
            // make a if statement to remove the previous marker
            map.value.eachLayer((layer) => {
                if (
                    layer instanceof L.Marker &&
                    layer.options.icon === customIcon.value
                ) {
                    map.value.removeLayer(layer);
                }
            });

            createPoints([
                {
                    latLng: e.latlng,
                },
            ]);

            emit("marker-location", {
                point: {
                    latLng: e.latlng,
                },
            });
        });
    }
});

onUnmounted(() => {
    if (locate.value) {
        locate.value = null;
    }
    if (trail.value) {
        trail.value = null;
    }
    if (trailMarkers.value) {
        trailMarkers.value = [];
    }
});
</script>

<template>
    <div id="map"></div>
</template>

<style scoped>
:deep(.leaflet-routing-container) {
    display: none;
}
</style>
