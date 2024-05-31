<script setup>
import { Head, useForm, usePage } from '@inertiajs/vue3';
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

const form = useForm({ 
  id:1
});

const { props: pageProps } = usePage();
const successMessage = pageProps.flash?.success;

const submit = () => {
    form.get(route('bookmark.create'), {});
};

</script>
<template>

    <Head title="Vos listes" />

    <h1>Vos listes</h1>
    <BaseDivider/>

    <div v-if="successMessage" class="alert alert-success">
      {{ successMessage }}
    </div>
        
    <BaseLinkList v-for="el in list" :key="el.id" :name="el.name" :id="el.id" 
      :link="route('bookmark.show', { id: el.id })" :numberElem="el.trails_count"/>


    <BasePlainButton @click="submit" type="submit" icon="add_circle">Créer une nouvelle liste</BasePlainButton>

    <TheNav />
</template>

<style scoped>
.alert {
  padding: 1rem;
  margin-bottom: 1rem;
  border: 1px solid transparent;
  border-radius: 0.375rem;
}

.alert-success {
  color: #155724;
  background-color: #d4edda;
  border-color: #c3e6cb;
}</style>
