import { ref } from "vue";
import L from "leaflet";

const map = ref(null);

const marker = ref(null);

const circle = ref(null);

const trail = ref(null);

const customIcon = ref(
    L.icon({
        iconUrl: "/img/location_on.svg",
        iconSize: [30, 34],
        iconAnchor: [15, 34],
    })
);

// get the position of the user
const updatePosition = () => {
    navigator.geolocation.getCurrentPosition(
        (position) => {
            const { latitude, longitude } = position.coords;
            marker.value.setLatLng([latitude, longitude]);
            circle.value.setLatLng([latitude, longitude]);
            circle.value.setRadius(position.coords.accuracy / 2);
            console.log("Position updated", position.coords.accuracy / 2);
        },
        (error) => {
            console.error(error);
        }
    );
};

// get the user precision location
const updateView = () => {
    navigator.geolocation.getCurrentPosition(
        (position) => {
            updatePosition();
            const { latitude, longitude } = position.coords;
            map.value.setView([latitude, longitude], 18);
        },
        (error) => {
            console.error(error);
        }
    );
};

export { map, marker, circle, trail, customIcon, updateView, updatePosition };
