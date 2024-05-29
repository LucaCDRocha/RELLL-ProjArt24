<script setup>
import { defineProps, defineEmits, ref } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import BaseTag from "@/Components/BaseTag.vue";
import BaseImgGalery from "@/Components/BaseImgGalery.vue";
import TheCardNav from "@/Components/TheCardNav.vue";
import AppCardList from "@/Components/AppCardList.vue";

const dataTest = ref([
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

defineProps({
    data: {
        type: Object,
        default: () => {},
    },
});

const imgs = ref([
    "https://upload.wikimedia.org/wikipedia/commons/4/4e/Pleiades_large.jpg",
    "https://upload.wikimedia.org/wikipedia/commons/thumb/b/b0/Rottenburg_a.N._-_Wurmlingen_-_Kapellenberg_-_Ansicht_von_OSO_im_April_mit_Gegenlicht.jpg/2880px-Rottenburg_a.N._-_Wurmlingen_-_Kapellenberg_-_Ansicht_von_OSO_im_April_mit_Gegenlicht.jpg",
    "https://upload.wikimedia.org/wikipedia/commons/thumb/e/e4/20170920_Lausanne-13.jpg/640px-20170920_Lausanne-13.jpg",
    "https://upload.wikimedia.org/wikipedia/commons/4/4e/Pleiades_large.jpg",
    "https://upload.wikimedia.org/wikipedia/commons/4/4e/Pleiades_large.jpg",
]);

const emit = defineEmits(["handleClose"]);
</script>

<template>
    <div class="interest-point">
        <TheCardNav @handle-close="emit('handleClose')" />
        <h1>{{ data.name }}</h1>
        <div class="ouvertures">
            <p>Toute les saisons</p>
            <p>Distance: {{ data.distance }} km</p>
        </div>
        <div class="tags">
            <BaseTag v-for="tag in data.tags" :key="tag" :tag="tag">{{
                tag
            }}</BaseTag>
        </div>
        <PrimaryButton>Voir le site web</PrimaryButton>
        <BaseImgGalery :imgs="imgs" />
        <h2>Description</h2>
        <div class="tags">
            <BaseTag v-for="tag in data.tags" :key="tag" :tag="tag">{{
                tag
            }}</BaseTag>
        </div>
        <p>{{ data.description }}</p>
        <AppCardList :datas="dataTest">Les sentier ayant ce lieu</AppCardList>
    </div>
</template>

<style scoped>
.interest-point {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    align-items: flex-start;
    width: 100%;
    height: fit-content;
}

.tags {
    display: flex;
    gap: 0.5rem;
}

.ouvertures {
    display: flex;
    justify-content: space-between;

    width: 100%;
}
</style>
