<script setup>
import { Head } from '@inertiajs/vue3';
import TheNav from "@/Components/TheNav.vue";
import BaseDivider from "@/Components/BaseDivider.vue";
import BaseLinkList from "@/Components/BaseLinkList.vue";
import BasePlainButton from "@/Components/BasePlainButton.vue";

const listes = defineProps({
  list: {
    type: Array,
      default: () => [],
    },
});

</script>
<template>

    <Head title="Vos listes" />

    <h1>Vos listes</h1>
    <BaseDivider/>
        
    <BaseLinkList v-for="el in list" :key="el.id" :name="el.name" :id="el.id" 
      :link="route('bookmark.show', { id: el.id })" :numberElem="el.trails_count"/>

    <BasePlainButton type="button" icon="add_circle">Créer une nouvelle liste</BasePlainButton>

    <TheNav />
</template>
