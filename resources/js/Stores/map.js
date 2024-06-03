import { ref } from "vue";
import L from "leaflet";

const map = ref(null);

const trail = ref(null);
const trailInfo = ref(null);

const trailMarkers = ref([]);

const locate = ref(null);

const customIcon = ref(
    L.icon({
        iconUrl: "/img/icons/location_on.svg",
        iconSize: [30, 34],
        iconAnchor: [15, 34],
    })
);

const customIconActive = ref(
    L.icon({
        iconUrl: "/img/icons/location_on_active.svg",
        iconSize: [34, 38],
        iconAnchor: [17, 38],
    })
);

function calculateDurationBetweenWaypoints(
    routeInstructions,
    startIndex,
    endIndex
) {
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

const flyTo = (location, zoom, duration) => {
    map.value.flyTo([location.latitude, location.longitude], zoom, {
        duration: duration, // Set the duration of the transition in seconds
    });
};

const changeTrailMarker = (waypointId) => {
    for (let i = 0; i < trailMarkers.value.length; i++) {
        if (
            i === waypointId ||
            i === waypointId + trailMarkers.value.length / 2
        ) {
            trailMarkers.value.at(i).setIcon(customIconActive.value);
        } else {
            trailMarkers.value.at(i).setIcon(customIcon.value);
        }
    }
};

export {
    map,
    trail,
    trailInfo,
    trailMarkers,
    customIcon,
    customIconActive,
    locate,
    calculateDurationBetweenWaypoints,
    flyTo,
    changeTrailMarker,
};
