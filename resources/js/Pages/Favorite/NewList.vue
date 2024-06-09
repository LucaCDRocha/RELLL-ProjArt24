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

            <PrimaryButton
                type="submit"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                >Valider</PrimaryButton
            >
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
</style>
