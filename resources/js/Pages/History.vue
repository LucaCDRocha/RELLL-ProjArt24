<script setup>
import { Head } from '@inertiajs/vue3';
import TheNav from "@/Components/TheNav.vue";
import AppCardList from "@/Components/AppCardList.vue";
import BaseDivider from "@/Components/BaseDivider.vue";

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
