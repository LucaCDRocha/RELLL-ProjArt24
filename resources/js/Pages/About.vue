<script setup>
import { Head, useForm, usePage, Link } from "@inertiajs/vue3";
import TheNav from "@/Components/TheNav.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import BaseToggleButton from "@/Components/BaseToggleButton.vue";
import BaseDivider from "@/Components/BaseDivider.vue";
import BaseTeamInfos from "@/Components/BaseTeamInfos.vue";
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from "@/Components/TextInput.vue";
import BaseTextArea from "@/Components/BaseTextArea.vue";
import { watch } from 'vue';

const team = [
    {
        name: "Laurence Kohli",
        title: "Cheffe de projet",
        photo: "https://upload.wikimedia.org/wikipedia/commons/4/4e/Pleiades_large.jpg"
    }, {
        name: "Luca Correia Da Rocha",
        title: "Lead technique partie front-end",
        photo: "https://upload.wikimedia.org/wikipedia/commons/4/4e/Pleiades_large.jpg"
    }, {
        name: "Robin Frossard",
        title: "Lead technique partie back-end",
        photo: "https://upload.wikimedia.org/wikipedia/commons/4/4e/Pleiades_large.jpg"
    }, {
        name: "Elodie Perring",
        title: "Responsable UX/UI design",
        photo: "https://upload.wikimedia.org/wikipedia/commons/4/4e/Pleiades_large.jpg"
    }, {
        name: "Lucas Tschaler",
        title: "UX/UI design et communication externe",
        photo: "https://upload.wikimedia.org/wikipedia/commons/4/4e/Pleiades_large.jpg"
    }
]
const user = usePage().props.auth.user;

const form = useForm({
    object: '',
    message: '',
    reply_mail: user ? user.email : '',
    name: user ? user.name : '',
});

watch(form, (value) => {
    console.log(form);
})

const submit = () => {
    console.log("test");
    form.post(route('settings'), {
    });
};

</script>

<template>

    <Head title="Contacter" />

    <div class="about">
        <!-- <Link
            href="{{ route('profile.show') }}"
            class="underline text-sm text-customGray dark:text-darkCustomGray hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-offset-gray-800"
                >
                <span class="material-symbols-rounded"> arrow_back </span></Link
                >         -->
        <BaseDivider />

        <div class="infos">
            <h3>Informations sur l'application</h3>
            <p>Cette application a été réalisée dans le cadre du projet d’articulation en 2ème année d’ingénierie des
                médias à la HEIG-VD, en 2024.</p>
            <div class="team">
                <BaseTeamInfos v-for="member in team" :key="member.name" :name="member.name" :title="member.title" :img="member.photo" />
            </div>
        </div>

        <BaseDivider />

        <div class="contact">
            <h3>Nous contacter</h3>
            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="mail" value="Quel est votre nom ?" />
                    <TextInput type="text" id="nom" class="mt-1 block w-full" v-model="form.name" required
                        autofocus placeholder="Nom" />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>
                <div>
                    <InputLabel for="mail" value="Quel est votre adresse e-mail ?" />
                    <TextInput type="email" id="mail" class="mt-1 block w-full" v-model="form.reply_mail" required
                        autofocus placeholder="email@exemple.ch" />
                    <InputError class="mt-2" :message="form.errors.reply_mail" />
                </div>

                <div>
                    <InputLabel for="object" value="Quel est l'objet du message ?" />
                    <TextInput id="object" class="mt-1 block w-full" v-model="form.object" required autofocus
                        placeholder="Objet" />
                    <InputError class="mt-2" :message="form.errors.object" />
                </div>

                <div>
                    <InputLabel for="message" value="Quel est votre message ?" />
                    <BaseTextArea id="message" class="mt-1 block w-full" v-model="form.message" required autofocus
                        placeholder="Message" />
                    <InputError class="mt-2" :message="form.errors.message" />
                </div>

                <PrimaryButton class="contactButton" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Nous contacter
                </PrimaryButton>
            </form>
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

.contact form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.contactButton {
    width: fit-content;
    margin-left: auto;
}

.about h3 {
    font-size: 1.375rem;
}

.infos{
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.infos p{
    @apply text-base font-medium;
}

.team {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    align-items:baseline;
    justify-content: center;
}
</style>
