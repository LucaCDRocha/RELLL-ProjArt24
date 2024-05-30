<script setup>
import { Head } from "@inertiajs/vue3";
import TheNav from "@/Components/TheNav.vue";
import AppMap from "@/Components/AppMap.vue";
import BaseMap from "@/Components/BaseMap.vue";

const waypoints = [
    {
        name: "Start",
        latLng: L.latLng(46.77911, 6.642196),
        info: "Starting point",
        tags: ["tag1", "tag2"],
    },
    {
        name: "Waypoint 2",
        latLng: L.latLng(46.779657, 6.64246),
        info: "Waypoint 2",
        tags: ["tag3", "tag4"],
    },
    {
        name: "Waypoint 3",
        latLng: L.latLng(46.778904, 6.640619),
        info: "Waypoint 3",
        tags: ["tag5", "tag6"],
    },
    {
        name: "Waypoint 4",
        latLng: L.latLng(46.778527, 6.640818),
        info: "Waypoint 4",
        tags: ["tag7", "tag8"],
    },
    {
        name: "Waypoint 5",
        latLng: L.latLng(46.778488, 6.640374),
        info: "Waypoint 5",
        tags: ["tag9", "tag10"],
    },
    {
        name: "Waypoint 6",
        latLng: L.latLng(46.778659, 6.641027),
        info: "Waypoint 6",
        tags: ["tag11", "tag12"],
    },
    {
        name: "Waypoint 7",
        latLng: L.latLng(46.777941, 6.641481),
        info: "Waypoint 7",
        tags: ["tag13", "tag14"],
    },
    {
        name: "End",
        latLng: L.latLng(46.77911, 6.642196),
        info: "Ending point",
        tags: ["tag15", "tag16"],
    },
];
</script>

<template>
    <Head title="Map" />

    <AppMap :waypoints="waypoints" />
    <!-- <BaseMap :trakable="true" :waypoints="waypoints" /> -->
    
    <TheNav />
</template>

<style scoped>
#map {
    height: calc(var(--vh, 1vh) * 100 - 5rem);
}
</style>
