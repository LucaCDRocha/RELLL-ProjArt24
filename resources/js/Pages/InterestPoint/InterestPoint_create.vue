<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import BaseRadioButtonGroup from '@/Components/BaseRadioButtonGroup.vue';
import BaseTextArea from '@/Components/BaseTextArea.vue';
import BaseSelect from '@/Components/BaseSelect.vue';
import BaseMultipleSelect from '@/Components/BaseMultipleSelect.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { watch, ref } from 'vue';

const form = useForm({
    name: '',
    description: '',
    url_point: '',
    seasons : [],
    pictures: [],
    location: '',
    tag_id: 0
});

watch(form, (value) => {
    console.log(form);
})

const submit = () => {
    console.log("test");
    // acitver la fonction Store de TrailController
    form.post(route('interestPoints.store'), {
    });
};

const tagsList = defineProps({
    tags: {
        type: Array,
        default: () => [],
    },
}
);

const tagsMap = tagsList.tags.map((tag) => {
    return { id: tag.id, name: tag.name }
})

const seasons = [
    { id: 1, name: 'Printemps' },
    { id: 2, name: 'Eté' },
    { id: 3, name: 'Automne' },
    { id: 4, name: 'Hiver' },
    { id: 5, name: 'Toutes' }]

const handleFileInput = (event) => {
  form.pictures = Array.from(event.target.files);
}


//affichage du formulaire en plusieurs pages
const step = ref(1);
const nextStep = () => { step.value++ }
const previousStep = () => { step.value-- }

</script>

<template>

    <Head title="Créer un lieu" />
    <form @submit.prevent="submit">
        <p>Création d'un lieu - {{ step }} / 3</p>
        <section v-if="step == 1">
            <div>
                <InputLabel for="name" value="Veuillez choisir le nom du lieu" />
                <TextInput id="name" class="mt-1 block w-full" v-model="form.name" required autofocus
                    placeholder="Nom du lieu"/>
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="description" value="Veuillez mettre une description du lieu" />
                <BaseTextArea id="description" class="mt-1 block w-full" v-model="form.description" required
                    autofocus placeholder="Description" />
                <InputError class="mt-2" :message="form.errors.description" />
            </div>

            <div>
                <InputLabel for="url" value="Veuillez mettre le site web du lieu" />
                <TextInput id="url" class="mt-1 block w-full" v-model="form.url_point" required autofocus
                    placeholder="URL du site web"/>
                <InputError class="mt-2" :message="form.errors.url_point" />
            </div>

            <div>
                <InputLabel for="tag" value="Veuillez indiquer le tag du lieu" />
                <BaseSelect name="tag" :options="tagsMap" v-model="form.tag_id" />
                <InputError class="mt-2" :message="form.errors.tag_id" />
            </div>
        </section>

        <section v-if="step == 2">
            <div>
                <InputLabel for="season" value="Veuillez indiquer la période d’ouverture (saison)" />
                <BaseMultipleSelect name="season" :options="seasons" v-model="form.seasons"/>
                <InputError class="mt-2" :message="form.errors.seasons" />
            </div>

            <div>
                <InputLabel for="images" value="Veuillez choisir des photos pour le lieu  " />
                <input name="images[]" type="file" @input="handleFileInput" multiple />
                <InputError class="mt-2" :message="form.errors.pictures" />
            </div>
        </section>

        <section v-if="step == 3">
            <div>
                <InputLabel for="coordonnees" value="Veuillez choisir le lieu" />
                <TextInput id="coordonnees" class="mt-1 block w-full" v-model="form.location" required autofocus />
                <InputError class="mt-2" :message="form.errors.location" />
            </div>
        </section>
        <div>
            <a v-if="step > 1" @click.prevent="previousStep()" href="">Revenir en arrière</a>
            <PrimaryButton v-if="step < 3" @click.prevent="nextStep()">
                Prochaine étape
            </PrimaryButton>
            <PrimaryButton v-else class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Sauver
            </PrimaryButton>
        </div>
    </form>


</template>

<style scoped></style>
