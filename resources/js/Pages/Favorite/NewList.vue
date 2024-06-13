<script setup>
import { useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const form = useForm({
    name: "",
    url: window.location.href,
});

const emit = defineEmits(["send"]);

const submit = () => {
    form.post(route("bookmark.store"), {});
    setTimeout(() => {
        emit("send");
    }, 1000);
};

const goBack = () => {
    window.history.back();
};
</script>
<template>
    <div class="lists">
        <form @submit.prevent="submit">
            <div class="input">
                <InputLabel
                    for="name"
                    value="Quel est le nom de votre liste ?"
                />
                <TextInput
                    id="name"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    placeholder="Nom de la liste"
                />
                <InputError :message="form.errors.name" />
            </div>

            <div class="nav">
                <a
                    href=""
                    @click.prevent="emit('send')"
                    class="underline text-sm font-medium text-onSurface dark:text-darkOnSurface hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-offset-gray-800"
                >
                    Annuler</a
                >
                <PrimaryButton
                    type="submit"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    >Valider</PrimaryButton
                >
            </div>
        </form>
    </div>
</template>

<style scoped>
.lists {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    align-items: flex-start;
    width: 100%;
    padding: 1rem 2rem 1rem 1rem;
}

.lists form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    align-items: flex-end;
    width: 100%;
}

.input {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    align-items: flex-start;
    width: 100%;
}

.nav {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    align-items: center;
}
</style>
