<script setup>
import { Head } from '@inertiajs/vue3';
import TheNav from "@/Components/TheNav.vue";
import { ref } from "vue";
import AppCardList from "@/Components/AppCardList.vue";
import BaseDivider from "@/Components/BaseDivider.vue";

const data = ref([
    {
        id: 1,
        name: "Château",
        description: "Le château de Lausanne",
        tag: "Facile",
        is_accessible: true,
    },
    {
        id: 2,
        name: "Art en ville de Lausanne",
        description: "Les oeuvres d'art de la ville de Lausanne",
        tag: "Moyen",
        is_accessible: true,
    },
    {
        id: 3,
        name: "33",
        description: "Le parcours du 33",
        tag: "Difficile",
        is_accessible: false,
    },
    {
        id: 4,
        name: "33",
        description: "Le parcours du 33",
        tag: "oui",
        is_accessible: false,
    },
]);

const datas = defineProps({
  historics: {
    type: Array,
      default: () => [],
    },
    myTrails : {
        type: Array,
      default: () => [],
    }
});

</script>

<template>

    <Head title="Historique" />
    <h1>Votre historique de sentiers</h1>
    <AppCardList :datas="historics">Votre historique de sentiers</AppCardList>

    <BaseDivider/>

    <AppCardList :datas="myTrails">Les sentiers que vous avez créés</AppCardList>
    <TheNav />
</template>
