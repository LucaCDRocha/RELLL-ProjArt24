<script setup>

import { useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    time: '',
    description: '',
    difficulty: '',
    info_transports: '',
    user_id: '',
    img: '',
    location_start:'',
    location_end: '',
    location_parking: ''
    });

const submit = () => {

    console.log("test");
    // acitver la fonction Store de TrailController
    form.post(route('trails.store'), {
    });
};

</script>

<template>

    <form @submit.prevent="submit">
        <label for="name">Nom du sentier</label> <br>
        <input type="text" id="name" v-model="form.name" /> <br>

        <label for="description">Description</label> <br>
        <input type="text" id="description" v-model="form.description" /> <br>

        <label for="difficulty">Difficulté</label> <br> 
        <select id="difficulty" v-model="form.difficulty"> 
            <option value="">--Choisissez une difficulté--</option>
            <option value="1">Débutant</option>
            <option value="2">Intermédiaire</option>
            <option value="3">Marcheur confirmé</option>
        </select> <br>

        <label for="time">Time</label> <br>
        <input type="time" id="time" v-model="form.time" /> <br>

        <label for="is_accessible">Accessible pour les gens à mobilité réduite ?</label> <br>
        <input type="checkbox" id="is_accessible" > <br>

        <label for="info_transports">Transports en commun disponible ?</label> <br>
        <input type="text" src="" alt=""> <br> 

        <label for="img">Image de votre sentier</label> <br>
        <input type="file" id="img"> <br>

        <!-- Permet de récuppérer l'id de l'utilisateur, ainsi que récupérer les points GPS rentré par l'utilisateur et les envoyer à la requette -->
        <input type="hidden" id="user_id"> 
        <input type="hidden" id="location_start">
        <input type="hidden" id="location_end">
        <input type="hidden" id="location_parking">
        <!-- Je te laisse mettre en place le code permettant de remplir les inputs de données -->
   
        <button type="submit">Submit</button>
    </form>


</template>

<style scoped></style>
