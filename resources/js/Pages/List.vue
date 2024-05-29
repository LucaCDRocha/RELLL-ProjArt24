<script setup>
import { Head } from '@inertiajs/vue3';
import TheNav from "@/Components/TheNav.vue";
import { ref } from "vue";
import BaseDivider from "@/Components/BaseDivider.vue";
import BaseLinkList from "@/Components/BaseLinkList.vue";
import BasePlainButton from "@/Components/BasePlainButton.vue";

const list = ref([{
    id: 1,
    name : "A faire cet été"
},{
    id: 2,
    name : "A faire avec Camille"
},
{
    id: 3,
    name : "Favoris"
}]);
</script>
<template>

    <Head title="Vos listes" />

    <h1>Vos listes</h1>
    <BaseDivider/>
    
    <BaseLinkList v-for="el in list" :name="el.name" :id="el.id" link="bookmark"/>

    <BasePlainButton :type="button" icon="add_circle">Créer une nouvelle liste</BasePlainButton>

    <TheNav />
</template>
