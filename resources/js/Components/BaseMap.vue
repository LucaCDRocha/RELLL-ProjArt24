<script setup>
import { map, marker, circle, updateView } from "@/Stores/map.js";
import { onMounted } from "vue";

onMounted(() => {
    map.value = L.map("map")
        .setView([46.77911, 6.642196], 17)
        .setMaxZoom(19)
        .setMinZoom(10);

    L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
        maxZoom: 19,
        minZoom: 10,
        attribution:
            '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    }).addTo(map.value);

    const customIcon = L.icon({
        iconUrl: "/img/location_on.svg",
        iconSize: [30, 34],
        iconAnchor: [15, 34],
    });

    marker.value = L.marker([0, 0], { icon: customIcon }).addTo(map.value);

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
    // change the place of the zoom control
    map.value.zoomControl.setPosition("bottomright");

    updateView();
});

setTimeout(() => {
    updateView();
}, 1000);
</script>

<template>
    <div id="map"></div>
</template>

<style scoped></style>
