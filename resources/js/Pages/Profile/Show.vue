<script setup>
import { Head, useForm, usePage } from '@inertiajs/vue3';
import TheNav from "@/Components/TheNav.vue";
import BaseDivider from "@/Components/BaseDivider.vue";
import DangerButton from '@/Components/DangerButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
});

const logout = () => {
    form.post(route('logout'), {
    });
};

const edit = () => {
    form.get(route('profile.edit'), {
    });
};
</script>

<template>

    <Head title="Profile" />
    <p>Votre profil</p>
    <DangerButton @click="logout()">Déconnexion</DangerButton>
    <BaseDivider/>
    <p>{{ user.name }}</p>
    <PrimaryButton @click="edit()">Modifier le profil</PrimaryButton>
    <TheNav />
</template>
