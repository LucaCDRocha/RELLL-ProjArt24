<script setup>
import { ref } from 'vue'
import { Head, useForm, usePage, Link } from '@inertiajs/vue3'
import TheNav from '@/Components/TheNav.vue'
import BaseDivider from '@/Components/BaseDivider.vue'
import DangerButton from '@/Components/DangerButton.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import DeleteUserForm from './Partials/DeleteUserForm.vue'
import BaseBottomSheet from '@/Components/BaseBottomSheet.vue'
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue'
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue'
import TheHeader from '@/Components/TheHeader.vue'
import BaseToggleButton from '@/Components/BaseToggleButton.vue'
import History from '@/Pages/History.vue'
import TertiaryButton from '@/Components/TertiaryButton.vue'
import Modal from '@/Components/Modal.vue'

const isOpen = ref(false)
const witchForm = ref('')

const toggleBottomSheet = () => {
    isOpen.value = !isOpen.value
}

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    historics: {
        type: Array,
        default: () => [],
    },
    myTrails: {
        type: Array,
        default: () => [],
    },
})

const user = usePage().props.auth.user

const form = useForm({
    id: user?.id,
})

const logout = () => {
    form.post(route('logout'), {})
}

// const edit = () => {
//     form.get(route("profile.edit"), {});
// };
const editPassword = () => {
    witchForm.value = 'password'
    toggleBottomSheet()
}

const edit = () => {
    witchForm.value = 'profile'
    toggleBottomSheet()
}

const destroy = () => {
    witchForm.value = 'delete'
    toggleBottomSheet()
    // form.delete(route("profile.destroy"), {});
}

const closeBottomSheet = () => {
    isOpen.value = false
}
</script>

<template>
    <Head title="Profil" />

    <TheHeader />

    <div class="profil">
        <div class="title">
            <h1>Votre profil</h1>
            <DangerButton v-if="user" @click="logout()"
                >Déconnexion</DangerButton
            >
            <Link
                v-else
                :href="route('login')"
                class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-offset-gray-800"
            >
                <PrimaryButton> Se connecter </PrimaryButton>
            </Link>
        </div>
        <BaseDivider />

        <div class="settings">
            <h1>Paramètres</h1>
            <BaseToggleButton label="Thème sombre" />
            <TertiaryButton
                v-if="!user"
                @click="$inertia.visit('/about')"
                class="contactButton"
                >A propos</TertiaryButton
            >
        </div>

        <BaseDivider v-if="user" />
        <h2 v-if="user">Vos informations</h2>
        <div v-if="user" class="editForm">
            <p>{{ user.name }}</p>
            <SecondaryButton @click="edit()" icon="edit"
                >Modifier</SecondaryButton
            >
        </div>
        <div v-if="user" class="editForm">
            <p>{{ user.email }}</p>
            <SecondaryButton @click="edit()" icon="edit"
                >Modifier</SecondaryButton
            >
        </div>
        <div v-if="user" class="editForm">
            <p>Votre mot de passe</p>
            <SecondaryButton @click="editPassword()" icon="edit"
                >Modifier</SecondaryButton
            >
        </div>
        <BaseDivider v-if="user" />

        <History
            v-if="user"
            :historics="historics"
            :myTrails="myTrails"
            :isAdmin="user.is_admin"
        />

        <BaseDivider v-if="user" />
        <div v-if="user" class="destroy">
            <a
                href=""
                @click.prevent="destroy()"
                class="underline text-sm text-error dark:text-darkError hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-offset-gray-800"
            >
                Supprimer votre compte
            </a>
            <PrimaryButton
                @click="$inertia.visit('/about')"
                class="contactButton"
                >A propos</PrimaryButton
            >
        </div>
    </div>

    <Modal v-if="isOpen" :show="isOpen" @close="toggleBottomSheet()">
        <UpdatePasswordForm v-if="witchForm === 'password'" class="form" />
        <DeleteUserForm
            v-else-if="witchForm === 'delete'"
            class="form"
            @handle-close="closeBottomSheet()"
        />
        <UpdateProfileInformationForm v-else class="form" />
    </Modal>

    <TheNav />
</template>

<style scoped>
.profil {
    padding: 1rem 1rem 0rem 1rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

div.title {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 1.25rem;
    margin-bottom: 1rem;
}

div.settings {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.contactButton {
    width: fit-content;
    margin-left: auto;
}

.editForm {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.destroy {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 1.25rem;
    margin-bottom: 2rem;
}

.form {
    padding-right: 1rem;
}
</style>
