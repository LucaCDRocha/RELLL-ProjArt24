<script setup>
import { Head, useForm, usePage } from "@inertiajs/vue3";
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
        title: "Responsable UX/Design",
        photo: "https://upload.wikimedia.org/wikipedia/commons/4/4e/Pleiades_large.jpg"
    }, {
        name: "Lucas Tschaler",
        title: "Responsable de la communication externe",
        photo: "https://upload.wikimedia.org/wikipedia/commons/4/4e/Pleiades_large.jpg"
    }
]
const user = usePage().props.auth.user;

const form = useForm({
    object: '',
    message: '',
    reply_mail: user ? user.email : ''
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
            <div class="team">
                <BaseTeamInfos v-for="member in team" :key="member.name" :name="member.name" :title="member.title" :img="member.photo" />
            </div>
        </div>

        <BaseDivider />

        <div class="contact">
            <h2>Nous contacter</h2>
            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="mail" value="Email pour correspondance" />
                    <TextInput type="email" id="mail" class="mt-1 block w-full" v-model="form.reply_mail" required
                        autofocus placeholder="Email" />
                    <InputError class="mt-2" :message="form.errors.reply_mail" />
                </div>

                <div>
                    <InputLabel for="object" value="Objet de votre message" />
                    <TextInput id="object" class="mt-1 block w-full" v-model="form.object" required autofocus
                        placeholder="Objet" />
                    <InputError class="mt-2" :message="form.errors.object" />
                </div>

                <div>
                    <InputLabel for="message" value="Votre message" />
                    <BaseTextArea id="message" class="mt-1 block w-full" v-model="form.message" required autofocus
                        placeholder="Message" />
                    <InputError class="mt-2" :message="form.errors.message" />
                </div>

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Contacter
                </PrimaryButton>
            </form>
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

.infos, .contact, .contact div {
    flex-direction: column;
}

.team {
    flex-direction: row;
    flex-wrap: wrap;
}
</style>
