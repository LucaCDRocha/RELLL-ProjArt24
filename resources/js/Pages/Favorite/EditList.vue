<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import SecondaryButton from "@/Components/SecondaryButton.vue";
import BaseDeleteCard from "@/Components/BaseDeleteCard.vue";
import TheNav from "@/Components/TheNav.vue";
import { watch } from "vue";

const items = defineProps({
    trailsList: {
        type: Object,
        default: () => [],
    },
    listDetails: {
        type: Object,
        default: () => [],
    }
});
const form = useForm({
    id: items.listDetails.id,
    aSupprimer: []
});

watch(form, (value) => {
    console.log(form);
})

const submit = () => {
    form.put(route('bookmark.update', {id: items.listDetails.id}), {});
};
</script>
<template>

    <Head :title="listDetails.name" />

    <h1>{{ listDetails.name }}</h1>
    <Link :href="route('bookmark.show', { id: listDetails.id })"
        class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-offset-gray-800">
    Retour
    </Link>

    <SecondaryButton @click="submit" class="ms-4" icon="edit">
        Valider
    </SecondaryButton>

    <div class="trailsList">
        <form @submit.prevent="submit">
            <BaseDeleteCard v-for="trail in trailsList" :key="trail.id" :data="trail" v-model="form.aSupprimer" ></BaseDeleteCard>
        </form>
    </div>

    <TheNav />
</template>
