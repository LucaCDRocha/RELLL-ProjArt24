import { ref } from "vue";
import L from "leaflet";

const map = ref(null);

const marker = ref(null);

const circle = ref(null);

const trail = ref(null);

const locate = ref(null);

const customIcon = ref(
    L.icon({
        iconUrl: "/img/location_on.svg",
        iconSize: [30, 34],
        iconAnchor: [15, 34],
    })
);

const customIcon2 = ref(
    L.icon({
        iconUrl: "/img/location_on.png",
        iconSize: [30, 34],
        iconAnchor: [15, 34],
    })
);

// get the information of the route
const infoTrail = ref(null);
const getInfoTrail = () => {
    trail.value.on("routesfound", (e) => {
        const routes = e.routes;
        const summary = routes[0].summary;
        infoTrail.value = summary;
    });

    return infoTrail.value;
};

// // getCoordinates()
// // Demande au navigateur de détecter la position actuelle de l'utilisateur et retourne une Promise
// const getCoordinates = () => {
//     return new Promise((res, rej) =>
//         navigator.geolocation.getCurrentPosition(res, rej)
//     );
// };

// // getPosition()
// // Résout la promesse de getCoordinates et retourne un objet {lat: x, long: y}
// const getPosition = async () => {
//     const position = await getCoordinates();
//     return {
//         lat: position.coords.latitude,
//         long: position.coords.longitude,
//         accuracy: position.coords.accuracy,
//     };
// };

// // get the position of the user
// const updatePosition = async () => {
//     const position = await getPosition();
//     marker.value.setLatLng([position.lat, position.long]);
//     circle.value.setLatLng([position.lat, position.long]);
//     circle.value.setRadius(position.accuracy / 2);
//     console.log("Position updated", position.accuracy / 2);
//     return position;
// };

// // get the user precision location
// const updateView = async () => {
//     const position = await updatePosition();
//     map.value.setView([position.lat, position.long], 18);
// };

export {
    map,
    marker,
    circle,
    trail,
    infoTrail,
    customIcon,
    customIcon2,
    locate,
    // updateView,
    // updatePosition,
    getInfoTrail,
};
