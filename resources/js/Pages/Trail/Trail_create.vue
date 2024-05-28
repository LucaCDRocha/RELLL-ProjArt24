<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import BaseRadioButtonGroup from '@/Components/BaseRadioButtonGroup.vue';
import BaseTextArea from '@/Components/BaseTextArea.vue';
import BaseSelect from '@/Components/BaseSelect.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { watch, ref } from 'vue';

const form = useForm({
    name: '',
    time: '',
    description: '',
    difficulty: 0,
    is_accessible: '',
    near_transport: '',
    info_transports: '',
    is_parking: '',
    location_parking: '',
    theme_id: 0,
    img: '',
    user_id: '',
    location_start: '',
    location_end: '',
    interest_point: ''
});

watch(form, (value) => {
    console.log(form);
})

const submit = () => {
    console.log("test");
    // acitver la fonction Store de TrailController
    form.post(route('trails.store'), {
    });
};

const thematiques = defineProps({
    themes: {
        type: Array,
        default: () => [],
    },
}
);

const themesMap = thematiques.themes.map((theme) => {
    return { id: theme.id, name: theme.name }
})

const difficulties = [
    { id: 1, name: 'Débutant' },
    { id: 2, name: 'Intermédiaire' },
    { id: 3, name: 'Marcheur confirmé' }]

//affichage du formulaire en plusieurs pages
const step = ref(1);
const nextStep = () => { step.value++ }
const previousStep = () => { step.value-- }

</script>

<template>

    <Head title="Créer un parcours" />
    <form @submit.prevent="submit">
        <section v-if="step == 1">
            <div>
                <InputLabel for="name" value="Veuillez choisir le nom du sentier" />
                <TextInput id="name" class="mt-1 block w-full" v-model="form.name" required autofocus
                    autocomplete="name" placeholder="Nom du sentier"/>
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="description" value="Veuillez mettre une description du sentier" />
                <BaseTextArea id="description" class="mt-1 block w-full" v-model="form.description" required
                    autofocus placeholder="Description" />
                <InputError class="mt-2" :message="form.errors.description" />
            </div>

            <div>
                <InputLabel for="difficulty" value="Veuillez mettre le niveau du sentier" />
                <BaseSelect name="difficulty" :options="difficulties" v-model="form.difficulty" placeholder="--Choisir--"/>
                <InputError class="mt-2" :message="form.errors.difficulty" />
            </div>
        </section>

        <section v-if="step == 2">
            <div>
                <InputLabel for="is_accessible"
                    value="Est-ce que le sentier est accessible aux chaises roulantes et aux poussettes ?" />
                <BaseRadioButtonGroup name="is_accessible" :options="['Oui', 'Non']" v-model="form.is_accessible" />
                <InputError class="mt-2" :message="form.errors.is_accessible" />
            </div>

            <div>
                <InputLabel for="near_transport" value="Est-ce que le sentier est accessible en transports public ?" />
                <BaseRadioButtonGroup name="near_transport" :options="['Oui', 'Non']" v-model="form.near_transport" />
                <InputError class="mt-2" :message="form.errors.near_transport" />
            </div>

            <div>
                <InputLabel for="info_transports" value="Si oui, veuillez décrire l’accès aux transports public" />
                <BaseTextArea id="info_transports" class="mt-1 block w-full" v-model="form.info_transports" required
                    autofocus />
                <InputError class="mt-2" :message="form.errors.info_transports" />
            </div>
        </section>

        <section v-if="step == 3">
            <div>
                <InputLabel for="is_parking" value="Est-ce qu’il y a un parking proche du sentier ?" />
                <BaseRadioButtonGroup name="is_parking" :options="['Oui', 'Non']" v-model="form.is_parking" />
                <InputError class="mt-2" :message="form.errors.is_parking" />
            </div>

            <div>
                <InputLabel for="theme" value="Veuillez indiquer le thème du sentier" />
                <BaseSelect name="theme" :options="themesMap" v-model="form.theme_id" />
                <InputError class="mt-2" :message="form.errors.theme_id" />
            </div>

            <div>
                <InputLabel for="image" value="Veuillez choisir une photo du sentier  " />
                <input type="file" @input="form.img = $event.target.files[0]" />
                <InputError class="mt-2" :message="form.errors.img" />
            </div>
        </section>

        <section v-if="step == 4">
            <div>
                <InputLabel for="depart" value="Veuillez choisir un lieu de départ du sentier" />
                <TextInput id="depart" class="mt-1 block w-full" v-model="form.location_start" required autofocus />
                <InputError class="mt-2" :message="form.errors.location_start" />
            </div>
        </section>

        <section v-if="step == 5">
            <div>
                <InputLabel for="interest_point"
                    value="Veuillez choisir les lieux que vous souhaitez visiter lors du sentier" />
                <TextInput id="interest_point" class="mt-1 block w-full" v-model="form.interest_point" required
                    autofocus />
                <InputError class="mt-2" :message="form.errors.interest_point" />
            </div>
        </section>

        <section v-if="step == 6">
            <div>
                <InputLabel for="arrivee" value="Veuillez choisir un lieu d'arrivée du sentier" />
                <TextInput id="arrivee" class="mt-1 block w-full" v-model="form.location_end" required autofocus />
                <InputError class="mt-2" :message="form.errors.location_end" />
            </div>

            <!-- Permet de récuppérer l'id de l'utilisateur, ainsi que récupérer les points GPS rentré par l'utilisateur et les envoyer à la requette -->
            <input type="hidden" id="user_id">
            <input type="hidden" id="location_start">
            <input type="hidden" id="location_end">
            <input type="hidden" id="location_parking">
            <input type="hidden" id="time">
            <!-- Je te laisse mettre en place le code permettant de remplir les inputs de données -->

        </section>
        <div>
            <a v-if="step > 1" @click.prevent="previousStep()" href="">Revenir en arrière</a>
            <PrimaryButton v-if="step < 6" @click.prevent="nextStep()" :disabled="form.processing">
                Prochaine étape
            </PrimaryButton>
            <PrimaryButton v-else class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Sauver
            </PrimaryButton>
        </div>
    </form>


</template>

<style scoped></style>
