import { ref } from "vue";
import L from "leaflet";

const map = ref(null);

const marker = ref(null);

const circle = ref(null);

// get and return the position of the user
const getPosition = () => {
    return new Promise((resolve, reject) => {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                resolve(position);
            },
            (error) => {
                reject(error);
            }
        );
    });
};

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
            const { latitude, longitude } = position.coords;
            map.value.setView([latitude, longitude], 18);
            updatePosition();
        },
        (error) => {
            console.error(error);
        }
    );
};

const trail = ref(null);

setInterval(() => {
    updatePosition();
}, 5000);

export { map, marker, circle, trail, updateView, updatePosition, getPosition };
