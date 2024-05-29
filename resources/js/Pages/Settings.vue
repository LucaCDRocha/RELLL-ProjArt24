<script setup>
import { Head } from "@inertiajs/vue3";
import TheNav from "@/Components/TheNav.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import BaseToggleButton from "@/Components/BaseToggleButton.vue";
import BaseDivider from "@/Components/BaseDivider.vue";
import BaseTeamInfos from "@/Components/BaseTeamInfos.vue";

const team = [
    {
        name : "Laurence Kohli",
        title : "cheffe de projet",
        photo : "https://upload.wikimedia.org/wikipedia/commons/4/4e/Pleiades_large.jpg"
    },{
        name : "Luca Correia Da Rocha",
        title : "Lead technique partie front-end",
        photo : "https://upload.wikimedia.org/wikipedia/commons/4/4e/Pleiades_large.jpg"
    },{
        name : "Robin Frossard",
        title : "Lead technique partie back-end",
        photo : "https://upload.wikimedia.org/wikipedia/commons/4/4e/Pleiades_large.jpg"
    },{
        name : "Elodie Perring",
        title : "Responsable UX/Design",
        photo : "https://upload.wikimedia.org/wikipedia/commons/4/4e/Pleiades_large.jpg"
    },{
        name : "Robin Frossard",
        title : "Responsable de la communication externe",
        photo : "https://upload.wikimedia.org/wikipedia/commons/4/4e/Pleiades_large.jpg"
    }
]

</script>

<template>

    <Head title="Settings" />

    <div class="settings">
        <h1>Settings</h1>

        <div>
            <PrimaryButton>Toggle dark mode</PrimaryButton>
            <SecondaryButton icon="search">Rechercher</SecondaryButton>
        </div>

        <BaseToggleButton label="Theme sombre" />

        <BaseDivider />

        <div class="infos">
            <h2>Informations sur l'application</h2>
            <p>Cette application a été réalisée dans le cadre du projet d’articulation en 2ème année d’ingénierie des
                médias à la HEIG-VD.</p>
                
            <BaseTeamInfos v-for="member in team" :name="member.name" :title="member.title" :img="member.photo"/>
        </div>
    </div>

    <div style="height: 5rem"></div>
    <TheNav />
</template>

<style scoped>
.settings {
    display: flex;
    flex-direction: column;
    gap: 1rem;

    padding: 1rem;
}

div {
    display: flex;
    flex-direction: row;
    gap: 0.5rem;
}

.infos{
    flex-direction: column;
}
</style>
