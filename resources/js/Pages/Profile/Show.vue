<script setup>
import { ref, watch } from "vue";
import { Head, useForm, usePage } from "@inertiajs/vue3";
import TheNav from "@/Components/TheNav.vue";
import BaseDivider from "@/Components/BaseDivider.vue";
import DangerButton from "@/Components/DangerButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DeleteUserForm from "./Partials/DeleteUserForm.vue";
import BaseBottomSheet from "@/Components/BaseBottomSheet.vue";
import UpdatePasswordForm from "./Partials/UpdatePasswordForm.vue";
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm.vue";
import TheHeader from "@/Components/TheHeader.vue";
import History from "@/Pages/History.vue";

const isOpen = ref(false);
const witchForm = ref("");

const toggleBottomSheet = () => {
    isOpen.value = !isOpen.value;
};

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
    id: user.id,
});

const logout = () => {
    form.post(route("logout"), {});
};

// const edit = () => {
//     form.get(route("profile.edit"), {});
// };
const editPassword = () => {
    witchForm.value = "password";
    toggleBottomSheet();
};

const edit = () => {
    witchForm.value = "profile";
    toggleBottomSheet();
};

const destroy = () => {
    form.delete(route("profile.destroy"), {});
};
</script>

<template>
    <Head title="Profil" />

    <TheHeader />

    <div class="profil">
        <div>
            <h1>Votre rofil</h1>
            <PrimaryButton @click="$inertia.visit('/settings')"
                >Paramètres de l'app</PrimaryButton
            >
        </div>
        <BaseDivider />

        <!-- <History /> -->
        <PrimaryButton @click="$inertia.visit('/my-trails')"
            >Historique</PrimaryButton
        >

        <BaseDivider />
        <h2>Modifier vos informations</h2>
        <div>
            <p>{{ user.name }}</p>
            <SecondaryButton @click="edit()" icon="edit"
                >Modifier le profil</SecondaryButton
            >
        </div>
        <div>
            <p>{{ user.email }}</p>
            <SecondaryButton @click="edit()" icon="edit"
                >Modifier le profil</SecondaryButton
            >
        </div>
        <div>
            <p>Votre mot de passe</p>
            <SecondaryButton @click="editPassword()" icon="edit"
                >Modifier le profil</SecondaryButton
            >
        </div>
        <BaseDivider />
        <div>
            <p @click="destroy()">Supprimer votre compte</p>
            <DangerButton @click="logout()">Déconnexion</DangerButton>
        </div>
        <DeleteUserForm />
    </div>

    <BaseBottomSheet
        v-if="isOpen"
        :isOpen="isOpen"
        @handle-open="toggleBottomSheet()"
    >
        <span class="material-symbols-rounded" @click="toggleBottomSheet()"
            >close</span
        >
        <UpdatePasswordForm v-if="witchForm === 'password'" />
        <UpdateProfileInformationForm v-else />
    </BaseBottomSheet>

    <TheNav />
</template>

<style scoped>
.profil {
    padding: 1rem 0rem 0rem 1rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}
</style>
