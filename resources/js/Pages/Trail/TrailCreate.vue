<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import BaseRadioButtonGroup from "@/Components/BaseRadioButtonGroup.vue";
import BaseTextArea from "@/Components/BaseTextArea.vue";
import BaseSelect from "@/Components/BaseSelect.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { watch, ref, onMounted } from "vue";
import BaseMap from "@/Components/BaseMap.vue";
import BaseDivider from "@/Components/BaseDivider.vue";
import { map, customIcon } from "@/Stores/map.js";
import TheHeader from "@/Components/TheHeader.vue";
import TheNav from "@/Components/TheNav.vue";
import AppMap from "@/Components/AppMap.vue";
import { trailInfo } from "@/Stores/map.js";

const props = defineProps({
    interestPoints: {
        type: Array,
        default: () => [],
    },
    auth: {
        type: Object,
        default: () => {},
    },
    filters: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    name: "",
    time: "",
    description: "",
    difficulty: 0,
    is_accessible: "",
    near_transport: "",
    info_transports: "",
    is_parking: "",
    location_parking: null,
    img: null,
    user_id: props.auth.user.id, // get the current user id
    location_start: null,
    location_end: null,
    interest_points: null,
});

const submit = () => {
    if (step.value === 6 && !form.interest_points) {
        form.errors.interest_points = "Veuillez choisir des points d'intérêts";
    } else {
        form.errors.interest_points = "";
        form.time = trailInfo.value.summary.totalTime;
        form.post(route("trails.store"), {});
    }
};

const difficulties = [
    { id: 1, name: "Facile" },
    { id: 2, name: "Moyen" },
    { id: 3, name: "Difficile" },
];

//affichage du formulaire en plusieurs pages
const step = ref(1);
const nextStep = () => {
    switch (step.value) {
        case 1:
            if (form.name === "") {
                form.errors.name = "Le nom du sentier est obligatoire";
            } else {
                form.errors.name = "";
            }
            if (form.description === "") {
                form.errors.description =
                    "La description du sentier est obligatoire";
            } else {
                form.errors.description = "";
            }
            if (form.img === null) {
                form.errors.img = "L'image du sentier est obligatoire";
            } else {
                form.errors.img = "";
            }
            if (form.difficulty === 0) {
                form.errors.difficulty =
                    "La difficulté du sentier est obligatoire";
            } else {
                form.errors.difficulty = "";
            }
            if (
                form.errors.name === "" &&
                form.errors.description === "" &&
                form.errors.img === "" &&
                form.errors.difficulty === ""
            ) {
                step.value++;
            }
            break;
        case 2:
            if (form.is_accessible === "") {
                form.errors.is_accessible =
                    "L'accessibilité du sentier est obligatoire";
            } else {
                form.errors.is_accessible = "";
            }
            if (form.near_transport === "") {
                form.errors.near_transport =
                    "La proximité des transports publics est obligatoire";
            } else {
                form.errors.near_transport = "";
            }
            if (form.near_transport === "Oui" && form.info_transports === "") {
                form.errors.info_transports =
                    "Les informations sur les transports publics sont obligatoires";
            } else {
                form.errors.info_transports = "";
            }
            if (
                form.errors.is_accessible === "" &&
                form.errors.near_transport === "" &&
                form.errors.info_transports === ""
            ) {
                step.value++;
            }
            break;
        case 3:
            if (form.is_parking === "") {
                form.errors.is_parking =
                    "La proximité d'un parking est obligatoire";
            } else {
                form.errors.is_parking = "";
            }
            if (form.is_parking === "Oui" && form.location_parking === null) {
                form.errors.location_parking =
                    "La position du parking est obligatoire";
            } else {
                form.errors.location_parking = "";
            }
            if (
                form.errors.is_parking === "" &&
                form.errors.location_parking === ""
            ) {
                step.value++;
            }
            break;
        case 4:
            if (form.location_start === null) {
                form.errors.location_start =
                    "La position du point de départ est obligatoire";
            } else {
                form.errors.location_start = "";
            }
            if (form.errors.location_start === "") {
                step.value++;
            }
            break;
        case 5:
            if (form.location_end === null) {
                form.errors.location_end =
                    "La position du point d'arrivée est obligatoire";
            } else {
                form.errors.location_end = "";
            }
            if (form.errors.location_end === "") {
                step.value++;
            }
            break;
        case 6:

        default:
            break;
    }
};
const previousStep = () => {
    step.value--;
};

const textStart = ref("");
const positionStart = ref(null);
const locationStart = (e) => {
    positionStart.value = e.point;
    waypoints.value.location_start = {
        latitude: e.point.latLng.lat,
        longitude: e.point.latLng.lng,
    };
    form.location_start = e.point;
};

const textEnd = ref("");
const positionEnd = ref(null);
const locationEnd = (e) => {
    positionEnd.value = e.point;
    waypoints.value.location_end = {
        latitude: e.point.latLng.lat,
        longitude: e.point.latLng.lng,
    };
    form.location_end = e.point;
};

const textParking = ref("");
const positionParking = ref(null);
const locationParking = (e) => {
    positionParking.value = e.point;
    form.location_parking = e.point;
};

const placeMarker = (adresse) => {
    if (adresse === "") return;

    // remove previous marker
    map.value.eachLayer((layer) => {
        if (
            layer instanceof L.Marker &&
            layer.options.icon === customIcon.value
        ) {
            map.value.removeLayer(layer);
        }
    });

    fetch(
        `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(
            adresse
        )}&format=json`
    )
        .then((response) => response.json())
        .then((data) => {
            if (data.length > 0) {
                const point = data[0];
                const latLng = L.latLng(point.lat, point.lon);
                switch (step.value) {
                    case 3:
                        locationParking({ point: { latLng } });
                        break;
                    case 4:
                        locationStart({ point: { latLng } });
                        break;
                    case 6:
                        locationEnd({ point: { latLng } });
                        break;
                }
                L.marker(latLng, {
                    icon: customIcon.value,
                    draggable: true,
                })
                    .addTo(map.value)
                    .on("dragend", function (e) {
                        switch (step.value) {
                            case 3:
                                locationParking({ point: { latLng } });
                                break;
                            case 4:
                                locationStart({ point: { latLng } });
                                break;
                            case 6:
                                locationEnd({ point: { latLng } });
                                break;
                        }
                    });
            } else {
                alert("Adresse introuvable");
            }
        })
        .catch((error) =>
            console.error("Erreur lors de la recherche de l'adresse:", error)
        );
};

// path of points
const waypoints = ref({
    interest_points: [],
});

const addPoint = (point) => {
    if (waypoints.value.interest_points.find((p) => p.id === point.point.id)) {
        // remove the point if it's already added
        waypoints.value.interest_points =
            waypoints.value.interest_points.filter(
                (p) => p.id !== point.point.id
            );
    } else {
        waypoints.value.interest_points.push({
            id: point.point.id,
            name: point.point.name,
            location: point.point.location,
            description: point.point.description,
            tag: point.point.tag,
            imgs: point.point.imgs,
        });
    }
};

const way = ref(waypoints.value);
watch(
    waypoints,
    (value) => {
        way.value = waypoints.value;
        form.interest_points = value.interest_points;
    },
    { deep: true }
);
// TODO: remove that
watch(step, (value) => {
    window.location.hash = value;
});

onMounted(() => {
    if (window.location.hash) {
        step.value = parseInt(window.location.hash.replace("#", ""));
    }
});
</script>

<template>
    <Head title="Créer un parcours" />

    <TheHeader />

    <form @submit.prevent="submit">
        <div class="title">
            <h1>Création d'un sentier - {{ step }}/6</h1>
            <small><span>*</span> Champs obligatoires</small>
        </div>
        <section v-if="step === 1">
            <div>
                <InputLabel for="name" value="Quel est le nom du sentier ? *" />
                <TextInput
                    id="name"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autocomplete="name"
                    placeholder="Art en ville de Lausanne"
                />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel
                    for="description"
                    value="A quoi ressemble le sentier ? *
                    (description)"
                />
                <BaseTextArea
                    id="description"
                    class="mt-1 block w-full"
                    v-model="form.description"
                    required
                    placeholder="C’est un peu le nouveau quartier..."
                />
                <InputError class="mt-2" :message="form.errors.description" />
            </div>

            <div>
                <InputLabel
                    for="image"
                    value="Ajoutez une photo du sentier *"
                />
                <input
                    type="file"
                    name="image"
                    @input="form.img = $event.target.files[0]"
                />
                <InputError class="mt-2" :message="form.errors.img" />
            </div>

            <div>
                <InputLabel
                    for="difficulty"
                    value="Quel est le niveau du sentier ? *"
                />
                <BaseSelect
                    name="difficulty"
                    :options="difficulties"
                    v-model="form.difficulty"
                />
                <InputError class="mt-2" :message="form.errors.difficulty" />
            </div>
        </section>

        <section v-if="step === 2">
            <div>
                <InputLabel
                    for="is_accessible"
                    value="Est-ce que le sentier est accessible en chaises roulantes ? *"
                />
                <BaseRadioButtonGroup
                    name="is_accessible"
                    :options="['Oui', 'Non']"
                    v-model="form.is_accessible"
                />
                <InputError class="mt-2" :message="form.errors.is_accessible" />
            </div>

            <div>
                <InputLabel
                    for="near_transport"
                    value="Est-ce que le sentier est proche des transports public ? *"
                />
                <BaseRadioButtonGroup
                    name="near_transport"
                    :options="['Oui', 'Non']"
                    v-model="form.near_transport"
                />
                <InputError
                    class="mt-2"
                    :message="form.errors.near_transport"
                />
            </div>

            <div v-if="form.near_transport === 'Oui'">
                <InputLabel
                    for="info_transport"
                    value="Si oui, à quoi ressemble l'accès aux transports publics ? *"
                />
                <BaseTextArea
                    id="info_transport"
                    class="mt-1 block w-full"
                    v-model="form.info_transports"
                    placeholder="Le départ est à la gare de..."
                />
                <InputError
                    class="mt-2"
                    :message="form.errors.info_transports"
                />
            </div>
        </section>

        <section v-if="step === 3">
            <div>
                <InputLabel
                    for="is_parking"
                    value="Est-ce qu’il y a un parking proche du sentier ? *"
                />
                <BaseRadioButtonGroup
                    name="is_parking"
                    :options="['Oui', 'Non']"
                    v-model="form.is_parking"
                />
                <InputError class="mt-2" :message="form.errors.is_parking" />
            </div>

            <div v-if="step === 3 && form.is_parking === 'Oui'">
                <InputLabel
                    for="parking"
                    value="Sélectionnez la position du lieu sur la carte ou entrez l'adresse. *"
                />
                <InputError
                    class="mt-2"
                    :message="form.errors.location_parking"
                />
                <TextInput
                    id="parking"
                    class="mt-1 block w-full"
                    v-model="textParking"
                    required
                    placeholder="Pl. de la gare 16, Lausanne"
                    @change="placeMarker($event.target.value)"
                />
                <BaseMap
                    :selectable="true"
                    :draggable="true"
                    :points="positionParking ? [positionParking] : []"
                    :pointsDraggable="true"
                    @marker-location="locationParking($event)"
                />
            </div>
        </section>

        <section v-if="step === 4">
            <div>
                <InputLabel
                    for="depart"
                    value="Sélectionnez le point de départ du sentier sur la carte ou entrez l'adresse. *"
                />
                <InputError
                    class="mt-2"
                    :message="form.errors.location_start"
                />
                <TextInput
                    id="depart"
                    class="mt-1 block w-full"
                    v-model="textStart"
                    placeholder="Pl. de la gare 16, Lausanne"
                    @change="placeMarker($event.target.value)"
                />

                <BaseMap
                    v-if="step === 4"
                    :selectable="true"
                    :draggable="true"
                    :points="positionStart ? [positionStart] : []"
                    :pointsDraggable="true"
                    @marker-location="locationStart($event)"
                />
            </div>
        </section>

        <section v-if="step === 5">
            <div>
                <InputLabel
                    for="arrivee"
                    value="Sélectionnez le point d'arrivée du sentier sur la carte ou entrez l'adresse. *"
                />
                <InputError class="mt-2" :message="form.errors.location_end" />
                <TextInput
                    id="arrivee"
                    class="mt-1 block w-full"
                    v-model="textEnd"
                    placeholder="Pl. de la gare 16, Lausanne"
                    @change="placeMarker($event.target.value)"
                />
                <BaseMap
                    v-if="step === 5"
                    :selectable="true"
                    :draggable="true"
                    :points="positionEnd ? [positionEnd] : []"
                    :pointsDraggable="true"
                    @marker-location="locationEnd($event)"
                />
            </div>

            <!-- Permet de récuppérer l'id de l'utilisateur, ainsi que récupérer les points GPS rentré par l'utilisateur et les envoyer à la requette -->
            <input type="hidden" id="user_id" value="1" />
            <input type="hidden" id="location_start" />
            <input type="hidden" id="location_end" />
            <input type="hidden" id="location_parking" />
            <input type="hidden" id="time" />
            <!-- Je te laisse mettre en place le code permettant de remplir les inputs de données -->
        </section>

        <section v-if="step === 6">
            <div>
                <InputLabel
                    for="interest_points"
                    value="Veuillez choisir les lieux que vous souhaitez visiter lors du sentier *"
                />
                <small
                    >Veuillez les choisir dans l'ordre que vous souhaitez
                    réaliser le parcous</small
                >
                <InputError
                    class="mt-2"
                    :message="form.errors.interest_points"
                />
                <AppMap
                    v-if="step === 6"
                    :points="interestPoints"
                    :filters="filters"
                    :track="false"
                    :waypoints="waypoints"
                    :toBounds="false"
                    @add-point="addPoint($event)"
                />
            </div>
        </section>

        <div class="nav">
            <a v-if="step > 1" @click.prevent="previousStep()" href=""
                >Revenir en arrière</a
            >
            <a v-else href="/create">Annuler</a>
            <PrimaryButton v-if="step < 6" @click.prevent="nextStep()">
                Prochaine étape
            </PrimaryButton>
            <PrimaryButton
                v-else
                class="ms-4"
                @click.prevent="submit()"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                Sauver
            </PrimaryButton>
        </div>
    </form>

    <TheNav />
</template>

<style scoped>
:deep(#map) {
    height: 400px;
    width: 100%;
}

.nav {
    @apply bg-surface;

    position: fixed;
    bottom: 5rem;

    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    align-items: center;
    padding: 1rem;
    width: 100vw;
    box-shadow: 0px -5px 5px rgba(0, 0, 0, 0.1);
    z-index: 1000;
}

form section {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    padding: 1rem 1rem 7rem 1rem;
    z-index: 10;
}

.title {
    padding: 1rem;
}
</style>
