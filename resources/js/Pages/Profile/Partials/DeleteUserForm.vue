<script setup>
import DangerButton from '@/Components/DangerButton.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import Modal from '@/Components/Modal.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import { useForm } from '@inertiajs/vue3'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import { nextTick, ref } from 'vue'

const confirmingUserDeletion = ref(false)
const passwordInput = ref(null)

const form = useForm({
    password: '',
})

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true

    nextTick(() => passwordInput.value.focus())
}

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    })
}

const closeModal = () => {
    confirmingUserDeletion.value = false

    form.reset()
}

const emit = defineEmits(['handle-close'])
</script>

<template>
    <section class="px-4 py-2">
        <header>
            <h2>Voulez-vous vraiment supprimer votre compte ?</h2>

            <p>Toutes vos données seront perdues.</p>
            <div class="choices">
                <a
                    @click="deleteUser"
                    class="underline text-sm text-error dark:text-darkError hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-offset-gray-800"
                >
                    Supprimer le compte</a
                >
                <PrimaryButton @click.self="emit('handle-close')"
                    >Non, annuler</PrimaryButton
                >
            </div>
        </header>

        <!-- <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Are you sure you want to delete your account?
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Once your account is deleted, all of its resources and data will be permanently deleted. Please
                    enter your password to confirm you would like to permanently delete your account.
                </p>

                <div class="mt-6">
                    <InputLabel for="password" value="Password" class="sr-only" />

                    <TextInput
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-3/4"
                        placeholder="Password"
                        @keyup.enter="deleteUser"
                    />

                    <InputError :message="form.errors.password" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        Delete Account
                    </DangerButton>
                </div>
            </div> 
        </Modal>-->
    </section>
</template>

<style scoped>
header {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.choices {
    display: flex;
    gap: 1rem;
    align-items: center;
}
</style>
