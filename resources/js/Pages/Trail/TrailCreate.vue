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
import BaseBottomSheet from "@/Components/BaseBottomSheet.vue";
import AppTrailInfo from "@/Components/AppTrailInfo.vue";
import AppInterestPointInfo from "@/Components/AppInterestPointInfo.vue";
import AppMap from "@/Components/AppMap.vue";

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
const isOpen = ref(false);

const data = ref({});

const BottomSheet = (e) => {
    if (e.point.difficulty) {
        window.location.href = route("trails.show", e.point.id);
    } else {
        fetch(route("interestPoints.showJson", e.point.id))
            .then((response) => response.json())
            .then((datas) => {
                data.value = datas;
                isOpen.value = true;
            });
    }
};

const closeBottomSheet = () => {
    isOpen.value = false;
};

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

watch(form, (value) => {
    console.log(form);
});

const submit = () => {
    console.log("test");
    // acitver la fonction Store de TrailController
    form.post(route("trails.store"), {});
};

const difficulties = [
    { id: 1, name: "Facile" },
    { id: 2, name: "Moyen" },
    { id: 3, name: "Difficile" },
];

//affichage du formulaire en plusieurs pages
const step = ref(1);
const nextStep = () => {
    step.value++;
};
const previousStep = () => {
    step.value--;
};

const textStart = ref("");
const positionStart = ref(null);
const locationStart = (e) => {
    console.log("locationStart", e.point);
    positionStart.value = e.point;
    waypoints.value = { location_start: e.point };
    form.location_start = e.point;
};

const textEnd = ref("");
const positionEnd = ref(null);
const locationEnd = (e) => {
    console.log("locationEnd", e.point);
    positionEnd.value = e.point;
    waypoints.value = { location_end: e.point };
    form.location_end = e.point;
};

const textParking = ref("");
const positionParking = ref(null);
const locationParking = (e) => {
    console.log("locationParking", e.point);
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
            <h2>Création d'un sentier - {{ step }}/6</h2>
            <p><span>*</span> Champs obligatoires</p>
        </div>
        <section v-if="step == 1">
            <div>
                <InputLabel for="name" value="Quel est le nom du sentier ? *" />
                <TextInput
                    id="name"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autocomplete="name"
                    placeholder="Nom du sentier"
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
                    placeholder="Description"
                />
                <InputError class="mt-2" :message="form.errors.description" />
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

            <div>
                <InputLabel
                    for="image"
                    value="Veuillez choisir une photo du sentier *"
                />
                <input
                    type="file"
                    name="image"
                    @input="form.img = $event.target.files[0]"
                />
                <InputError class="mt-2" :message="form.errors.img" />
            </div>
        </section>

        <section v-if="step == 2">
            <div>
                <InputLabel
                    for="is_accessible"
                    value="Est-ce que le sentier est accessible aux chaises roulantes ?"
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
                    value="Est-ce que le sentier est accessible en transports public ?"
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

            <div>
                <InputLabel
                    for="info_transport"
                    value="Si oui, à quoi ressemble l'accès en transports publics ?"
                />
                <BaseTextArea
                    id="info_transport"
                    class="mt-1 block w-full"
                    v-model="form.info_transports"
                    placeholder="Description"
                />
                <InputError
                    class="mt-2"
                    :message="form.errors.info_transports"
                />
            </div>
        </section>

        <section v-if="step == 3">
            <div>
                <InputLabel
                    for="is_parking"
                    value="Est-ce qu’il y a un parking proche du sentier ?"
                />
                <BaseRadioButtonGroup
                    name="is_parking"
                    :options="['Oui', 'Non']"
                    v-model="form.is_parking"
                />
                <InputError class="mt-2" :message="form.errors.is_parking" />
            </div>

            <TextInput
                v-if="step === 3 && form.is_parking === 'Oui'"
                id="depart"
                class="mt-1 block w-full"
                v-model="textParking"
                required
                placeholder="Nom de la rue, numéro, ville"
                @change="placeMarker($event.target.value)"
            />
            <BaseMap
                v-if="step === 3 && form.is_parking === 'Oui'"
                :selectable="true"
                :draggable="true"
                :points="positionParking ? [positionParking] : []"
                @marker-location="locationParking($event)"
            />
        </section>

        <section v-if="step == 4">
            <div>
                <InputLabel
                    for="depart"
                    value="Veuillez choisir un lieu de départ du sentier"
                />
                <TextInput
                    id="depart"
                    class="mt-1 block w-full"
                    v-model="textStart"
                    placeholder="Nom de la rue, numéro, ville"
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
                <InputError
                    class="mt-2"
                    :message="form.errors.location_start"
                />
            </div>
        </section>

        <section v-if="step == 5">
            <div>
                <!-- <InputLabel
                    for="interest_points"
                    value="Veuillez choisir les lieux que vous souhaitez visiter lors du sentier"
                />
                <TextInput
                    id="interest_points"
                    class="mt-1 block w-full"
                    v-model="form.interest_points"
                    placeholder="Nom du lieu"
                />
                <InputError
                    class="mt-2"
                    :message="form.errors.interest_point"
                />

                <SecondaryButton>Créer un lieu</SecondaryButton>

                <BaseMap
                    :draggable="true"
                    :points="props.interestPoints"
                    :waypoints="waypoints"
                    @marker-click="BottomSheet($event)"
                />
                <BaseBottomSheet
                    v-if="isOpen"
                    :isOpen="isOpen"
                    @handle-close="closeBottomSheet()"
                >
                    <AppTrailInfo
                        v-if="data.difficulty"
                        :data="data"
                        @handle-close="closeBottomSheet()"
                        @handle-point="BottomSheet($event)"
                    />
                    <AppInterestPointInfo
                        v-else
                        :data="data"
                        @handle-close="closeBottomSheet()"
                        @handle-point="BottomSheet($event)"
                    />
                </BaseBottomSheet> -->
                <AppMap :waypoints="interestPoints" :filters="filters" :track="false" />
            </div>
        </section>

        <section v-if="step == 6">
            <div>
                <InputLabel
                    for="arrivee"
                    value="Veuillez choisir un lieu d'arrivée du sentier"
                />
                <TextInput
                    id="arrivee"
                    class="mt-1 block w-full"
                    v-model="textEnd"
                    placeholder="Nom de la rue, numéro, ville"
                    @change="placeMarker($event.target.value)"
                />
                <BaseMap
                    v-if="step === 6"
                    :selectable="true"
                    :draggable="true"
                    :points="positionEnd ? [positionEnd] : []"
                    :pointsDraggable="true"
                    @marker-location="locationEnd($event)"
                />
                <InputError class="mt-2" :message="form.errors.location_end" />
            </div>

            <!-- Permet de récuppérer l'id de l'utilisateur, ainsi que récupérer les points GPS rentré par l'utilisateur et les envoyer à la requette -->
            <input type="hidden" id="user_id" value="1" />
            <input type="hidden" id="location_start" />
            <input type="hidden" id="location_end" />
            <input type="hidden" id="location_parking" />
            <input type="hidden" id="time" />
            <!-- Je te laisse mettre en place le code permettant de remplir les inputs de données -->
        </section>
        <div class="nav">
            <a v-if="step > 1" @click.prevent="previousStep()" href=""
                >Revenir en arrière</a
            >
            <a v-else href="/home">Annuler</a>
            <PrimaryButton v-if="step < 6" @click.prevent="nextStep()">
                Prochaine étape
            </PrimaryButton>
            <PrimaryButton
                v-else
                class="ms-4"
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
