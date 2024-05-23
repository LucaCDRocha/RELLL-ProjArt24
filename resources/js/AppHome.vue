<script setup>
import { onMounted } from "vue";
import L from "leaflet";

// getCoordinates()
// Demande au navigateur de détecter la position actuelle de l'utilisateur et retourne une Promise
const getCoordinates = () => {
    return new Promise((res, rej) =>
        navigator.geolocation.getCurrentPosition(res, rej)
    );
};

// getPosition()
// Résout la promesse de getCoordinates et retourne un objet {lat: x, long: y}
const getPosition = async () => {
    const position = await getCoordinates();
    return {
        lat: position.coords.latitude,
        long: position.coords.longitude,
    };
};

onMounted(() => {
    getPosition().then((position) => {
        const map = L.map("map").setView([position.lat, position.long], 17);

        L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
            maxZoom: 20,
            attribution:
                '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        }).addTo(map);

        // L.tileLayer("https://wmts.geo.admin.ch/1.0.0/ch.swisstopo.pixelkarte-farbe/default/current/3857/{z}/{x}/{y}.jpeg", {
        //     maxZoom: 20,
        //     attribution:
        //     '&copy; <a href="https://www.swisstopo.admin.ch/">swisstopo</a>',
        // }).addTo(map);

        let marker = L.marker([position.lat, position.long]).addTo(map);
        marker.bindPopup("Vous êtes ici !");

        // listen the deplacement of the user and update the leaflet map and the marker
        navigator.geolocation.watchPosition((position) => {
            console.log(
                "position",
                position.coords.latitude,
                position.coords.longitude
            );
            map.panTo([position.coords.latitude, position.coords.longitude]);
            // remove the old marker
            map.removeLayer(marker);
            // add a new marker
            marker = L.marker([
                position.coords.latitude,
                position.coords.longitude,
            ]).addTo(map);
            marker.bindPopup("Vous êtes ici !");
        });
    });
});
</script>

<template>
    <div>
        <h1>Map</h1>
        <div id="map"></div>
    </div>
</template>

<style scoped>
#map {
    height: 40vh;
}
</style>
