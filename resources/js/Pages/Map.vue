<script setup>
import { Head } from "@inertiajs/vue3";
import TheNav from "@/Components/TheNav.vue";
import { onMounted } from "vue";
import L from "leaflet";
import "leaflet-routing-machine";

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
        const map = L.map("map").setView([position.lat, position.long], 16);

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

        // L.marker([46.778904, 6.640619]).addTo(map);
        // L.marker([46.78074, 6.63875]).addTo(map);
        // L.marker([46.778488, 6.640374]).addTo(map);

        let control = L.Routing.control({
            waypoints: [
                L.latLng(46.779110, 6.642196),
                L.latLng(46.779657, 6.642460),
                L.latLng(46.778904, 6.640619),
                L.latLng(46.778527, 6.640818),
                L.latLng(46.778488, 6.640374),
                L.latLng(46.778659, 6.641027),
                L.latLng(46.777941, 6.641481),
                L.latLng(46.779110, 6.642196),
                
            ],
            router: new L.Routing.OSRMv1({
                serviceUrl:
                    "https://routing.openstreetmap.de/routed-foot/route/v1",
            }),
            routeWhileDragging: true,
            draggableWaypoints: false,
            addWaypoints: false,
        }).addTo(map);

        console.log("control", control.getPlan());

        // listen the deplacement of the user and update the leaflet map and the marker
        // navigator.geolocation.watchPosition((position) => {
        //     console.log(
        //         "position",
        //         position.coords.latitude,
        //         position.coords.longitude
        //     );
        //     map.panTo([position.coords.latitude, position.coords.longitude]);
        //     // remove the old marker
        //     map.removeLayer(marker);
        //     // add a new marker
        //     marker = L.marker([
        //         position.coords.latitude,
        //         position.coords.longitude,
        //     ]).addTo(map);
        //     marker.bindPopup("Vous êtes ici !");
        // });
    });
});
</script>

<template>
    <Head title="Map" />

    <div id="map"></div>

    <div style="height: 5rem"></div>
    <TheNav />
</template>

<style scoped>
#map {
    height: calc(100vh - 5rem);
}

.leaflet-routing-collapse-btn {
    height: 2rem;
    width: 2rem;
}
</style>
