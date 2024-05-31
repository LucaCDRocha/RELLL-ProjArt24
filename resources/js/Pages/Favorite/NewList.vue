<script setup>
import { useForm } from '@inertiajs/vue3';
import BaseBottomSheet from "@/Components/BaseBottomSheet.vue";
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref } from "vue";

const isOpen = ref(true);

const form = useForm({ 
    name : ''
});

const submit = () => {
    form.post(route('bookmark.store'), {});
};

</script>
<template>
    <BaseBottomSheet :isOpen="isOpen">
        <div class="lists">
            <form @submit.prevent="submit">
                <div>
                <InputLabel for="name" value="Quel est le nom de votre liste ?" />
                <TextInput id="name" class="mt-1 block w-full" v-model="form.name" required autofocus
                    placeholder="Nom de la liste"/>
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

                <PrimaryButton type="submit" class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Valider
                </PrimaryButton>

            </form>
        </div>

    </BaseBottomSheet>
</template>
