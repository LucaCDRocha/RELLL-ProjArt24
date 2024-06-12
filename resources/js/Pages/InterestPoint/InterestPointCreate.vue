<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import BaseTextArea from "@/Components/BaseTextArea.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { watch, ref, computed, onMounted } from "vue";
import TheNav from "@/Components/TheNav.vue";
import TheHeader from "@/Components/TheHeader.vue";
import BaseTag from "@/Components/BaseTag.vue";
import BaseMap from "@/Components/BaseMap.vue";
import { customIcon, map } from "@/Stores/map.js";

const form = useForm({
    name: "",
    description: "",
    url: "",
    seasons: [],
    tags: [],
    imgs: [],
    location: null,
});

const submit = () => {
    if (form.location === null) {
        form.errors.location = "Indiquez une localisation";
    } else {
        form.errors.location = "";
        form.post(route("interestPoints.store"), {});
    }
};

const props = defineProps({
    tags: {
        type: Array,
        default: () => [],
    },
});
const tagsSelected = computed(() => {
    let selected = [];
    for (const tag of props.tags) {
        if (tag.selected) {
            selected.push(tag);
        }
    }
    return selected;
});
const switchTag = (tag) => {
    if (props.tags.find((f) => f.name === tag.name)) {
        props.tags.find((f) => f.name === tag.name).selected = !tag.selected;
    }
};
watch(tagsSelected, (value) => {
    form.tags = value;
});

const seasons = ref([
    { name: "Printemps", selected: false },
    { name: "Eté", selected: false },
    { name: "Automne", selected: false },
    { name: "Hiver", selected: false },
    // { name: "Toutes", selected: false },
]);
const seasonsSelected = computed(() => {
    let selected = [];
    for (const season of seasons.value) {
        if (season.selected) {
            selected.push(season);
        }
    }
    return selected;
});
const switchSeason = (season) => {
    if (seasons.value.find((f) => f.name === season.name)) {
        seasons.value.find((f) => f.name === season.name).selected =
            !season.selected;
    }
};
watch(seasonsSelected, (value) => {
    form.seasons = value;
});

const handleFileInput = (event) => {
    form.imgs = event.target.files; // Array.from(event.target.files);
};

const textPoint = ref("");
const positionPoint = ref(null);
const locationPoint = (e) => {
    positionPoint.value = e.point;
    form.location = e.point;
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
                locationPoint({ point: { latLng } });
                L.marker(latLng, {
                    icon: customIcon.value,
                    draggable: true,
                })
                    .addTo(map.value)
                    .on("dragend", function (e) {
                        locationPoint({ point: { latLng } });
                    });
            } else {
                alert("Adresse introuvable");
            }
        })
        .catch((error) =>
            console.error("Erreur lors de la recherche de l'adresse:", error)
        );
};

//affichage du formulaire en plusieurs pages
const step = ref(1);
const nextStep = () => {
    switch (step.value) {
        case 1:
            if (form.name === "") {
                form.errors.name = "Le nom du lieu est obligatoire";
            } else {
                form.errors.name = "";
            }
            if (form.description === "") {
                form.errors.description =
                    "La description du lieu est obligatoire";
            } else {
                form.errors.description = "";
            }
            if (form.errors.name === "" && form.errors.description === "") {
                step.value++;
            }
            break;

        case 2:
            if (tagsSelected.value.length === 0) {
                form.errors.tag_id = "Le tag du lieu est obligatoire";
            } else {
                form.errors.tag_id = "";
            }
            if (seasonsSelected.value.length === 0) {
                form.errors.seasons = "Indiquez au moins une saison d'ouverture";
            } else {
                form.errors.seasons = "";
            }
            if (form.imgs.length === 0) {
                form.errors.imgs = "Il faut au moins une image du lieu";
            } else {
                form.errors.imgs = "";
            }
            if (
                form.errors.tag_id === "" &&
                form.errors.seasons === "" &&
                form.errors.imgs === ""
            ) {
                step.value++;
            }
            break;

        default:
            break;
    }
};
const previousStep = () => {
    step.value--;
};

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
    <Head title="Créer un lieu" />

    <TheHeader />

    <form @submit.prevent="submit">
        <div class="title">
            <h1>Création d'un lieu - {{ step }}/3</h1>
            <small><span>*</span> Champs obligatoires</small>
        </div>
        <section v-if="step === 1">
            <div>
                <InputLabel for="name" value="Quel est le nom du lieu ? *" />
                <TextInput
                    id="name"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    placeholder="Plateforme 10"
                />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel
                    for="description"
                    value="Veuillez mettre une description du lieu *"
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
                    for="url"
                    value="Veuillez indiquer le site web du lieu"
                />
                <TextInput
                    id="url"
                    class="mt-1 block w-full"
                    v-model="form.url"
                    required
                    placeholder="https://plateforme10.ch"
                />
                <InputError class="mt-2" :message="form.errors.url_point" />
            </div>
        </section>

        <section v-if="step === 2">
            <div>
                <InputLabel
                    for="tag"
                    value="Quel(s) tag(s) correspond(ent) à ce lieu ? *"
                />
                <BaseTag
                    v-for="tag in props.tags"
                    :key="tag.name"
                    :tag="tag.name"
                    :selected="tag.selected"
                    @click.prevent="switchTag(tag)"
                />
                <InputError class="mt-2" :message="form.errors.tag_id" />
            </div>

            <div>
                <InputLabel
                    for="season"
                    value="Pendant quels saisons le lieu est-il ouvert ? *"
                />
                <BaseTag
                    v-for="season in seasons"
                    :key="season.name"
                    :tag="season.name"
                    :selected="season.selected"
                    @click.prevent="switchSeason(season)"
                />
                <InputError class="mt-2" :message="form.errors.seasons" />
            </div>
            <div>
                <InputLabel
                    for="imgs"
                    value="Ajoutez une ou plusieurs image(s) à ce lieu *"
                />
                <input
                    id="imgs"
                    name="imgs[]"
                    type="file"
                    @input="handleFileInput"
                    multiple
                />
                <InputError class="mt-2" :message="form.errors.imgs" />
            </div>
        </section>

        <section v-if="step === 3">
            <div>
                <InputLabel
                    for="coordonnees"
                    value="Sélectionnez la position du lieu sur la carte ou entrez l'adresse. *"
                />
                <InputError class="mt-2" :message="form.errors.location" />
                <TextInput
                    id="depart"
                    class="mt-1 block w-full"
                    v-model="textPoint"
                    placeholder="Pl. de la gare 16, Lausanne"
                    @change="placeMarker($event.target.value)"
                />

                <BaseMap
                    v-if="step === 3"
                    :selectable="true"
                    :draggable="true"
                    :points="positionPoint ? [positionPoint] : []"
                    :pointsDraggable="true"
                    @marker-location="locationPoint($event)"
                />
            </div>
        </section>
        <div>
            <div class="nav">
                <a v-if="step > 1" @click.prevent="previousStep()" href=""
                    >Revenir en arrière</a
                >
                <a v-else href="/create">Annuler</a>
                <PrimaryButton v-if="step < 3" @click.prevent="nextStep()">
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
    @apply bg-surface dark:bg-darkSurface;

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
