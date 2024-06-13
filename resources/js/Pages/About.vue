<script setup>
import { Head, useForm, usePage, Link } from '@inertiajs/vue3'
import TheNav from '@/Components/TheNav.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import BaseDivider from '@/Components/BaseDivider.vue'
import BaseTeamInfos from '@/Components/BaseTeamInfos.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import BaseTextArea from '@/Components/BaseTextArea.vue'

const team = [
    {
        name: 'Laurence Kohli',
        title: 'Cheffe de projet',
        photo: '/img/team/Kohli.png',
    },
    {
        name: 'Luca Correia Da Rocha',
        title: 'Lead technique partie front-end',
        photo: '/img/team/CorreiaDaRocha.png',
    },
    {
        name: 'Robin Frossard',
        title: 'Lead technique partie back-end',
        photo: '/img/team/Frossard.png',
    },
    {
        name: 'Elodie Perring',
        title: 'Responsable UX/UI design',
        photo: '/img/team/Perring.png',
    },
    {
        name: 'Lucas Tschaler',
        title: 'UX/UI design et communication externe',
        photo: '/img/team/Tschaler.png',
    },
]
const user = usePage().props.auth.user

const form = useForm({
    object: '',
    content: '',
    reply_mail: user ? user.email : '',
    name: user ? user.name : '',
})

const submit = () => {
    form.post(route('contact'), {})
}

const goBack = () => {
    window.history.back()
}
</script>

<template>
    <Head title="Contacter" />

    <div class="about">
        <span class="material-symbols-rounded cursor-pointer" @click="goBack()">
            arrow_back
        </span>
        <BaseDivider />

        <div class="infos">
            <h3>Informations sur l'application</h3>
            <p>
                Cette application a été réalisée dans le cadre du projet
                d’articulation en 2ème année d’ingénierie des médias à la
                HEIG-VD, en 2024.
            </p>
            <div class="team">
                <BaseTeamInfos
                    v-for="member in team"
                    :key="member.name"
                    :name="member.name"
                    :title="member.title"
                    :img="member.photo"
                />
            </div>
        </div>

        <BaseDivider />

        <div class="contact">
            <h3>Nous contacter</h3>
            <a href="mailto:contact@vaudsentiers.ch">
                <span class="material-symbols-rounded cursor-pointer"
                    >mail</span
                >
                <p
                    class="underline text-sm font-medium text-onSurface dark:text-darkOnSurface hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-offset-gray-800"
                >
                    contact(at)vaudsentiers.ch
                </p>
            </a>
            <!-- <form @submit.prevent="submit">
                <div>
                    <InputLabel for="nom" value="Quel est votre nom ?" />
                    <TextInput type="text" id="nom" class="mt-1 block w-full" v-model="form.name" required
                        placeholder="Nom" />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>
                <div>
                    <InputLabel for="mail" value="Quel est votre adresse e-mail ?" />
                    <TextInput type="email" id="mail" class="mt-1 block w-full" v-model="form.reply_mail" required
                        placeholder="email@exemple.ch" />
                    <InputError class="mt-2" :message="form.errors.reply_mail" />
                </div>

                <div>
                    <InputLabel for="object" value="Quel est l'objet du message ?" />
                    <TextInput id="object" class="mt-1 block w-full" v-model="form.object" required 
                        placeholder="Objet" />
                    <InputError class="mt-2" :message="form.errors.object" />
                </div>

                <div>
                    <InputLabel for="message" value="Quel est votre message ?" />
                    <BaseTextArea id="message" class="mt-1 block w-full" v-model="form.message" required
                        placeholder="Message" />
                    <InputError class="mt-2" :message="form.errors.message" />
                </div>

                <PrimaryButton class="contactButton" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Nous contacter
                </PrimaryButton>
            </form> -->
        </div>
    </div>

    <div style="height: 5rem"></div>
    <TheNav />
</template>

<style scoped>
.about {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    padding: 1rem;
}

.contact a {
    display: flex;
    flex-direction: row;
    gap: 0.5rem;
    align-items: center;
}

.contactButton {
    width: fit-content;
    margin-left: auto;
}

.about h3 {
    font-size: 1.375rem;
}

.infos {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.infos p {
    @apply text-base font-medium;
}

.team {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    align-items: baseline;
    justify-content: center;
}
</style>
