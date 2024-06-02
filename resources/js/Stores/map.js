import { ref } from "vue";
import L from "leaflet";

const map = ref(null);

const marker = ref(null);

const circle = ref(null);

const trail = ref(null);
const trailInfo = ref(null);

const locate = ref(null);

const customIcon = ref(
    L.icon({
        iconUrl: "/img/location_on.svg",
        iconSize: [30, 34],
        iconAnchor: [15, 34],
    })
);

function calculateDurationBetweenWaypoints(
    routeInstructions,
    startIndex,
    endIndex
) {
    console.log(routeInstructions, startIndex, endIndex);
    let numberOfReaches = 0;
    let time = 0;
    let distance = 0;
    let instructions = routeInstructions;
    instructions.forEach((instruction) => {
        if (numberOfReaches >= startIndex && numberOfReaches < endIndex) {
            time += instruction.time;
            distance += instruction.distance;
        }
        if (instruction.type === "WaypointReached") {
            numberOfReaches++;
        }
    });
    time = Math.round(time / 60);
    return {
        time,
        distance,
    };
}

const flyTo = (location,zoom,duration) => {
    map.value.flyTo([location.latitude, location.longitude], zoom, {
        duration: duration, // Set the duration of the transition in seconds
    });
};

export {
    map,
    marker,
    circle,
    trail,
    trailInfo,
    customIcon,
    locate,
    calculateDurationBetweenWaypoints,
    flyTo,
};
