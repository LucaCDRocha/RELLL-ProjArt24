<script setup>
import { ref } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import BaseTag from "@/Components/BaseTag.vue";
import BaseDividerVert from "@/Components/BaseDividerVert.vue";
import TheCardNav from "@/Components/TheCardNav.vue";
import BaseImgGalery from "@/Components/BaseImgGalery.vue";
import AppCardList from "@/Components/AppCardList.vue";
import BaseMap from "@/Components/BaseMap.vue";

defineProps({
    data: {
        type: Object,
        default: () => {},
    },
});

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

const imgs = ref([
    "https://upload.wikimedia.org/wikipedia/commons/4/4e/Pleiades_large.jpg",
    "https://upload.wikimedia.org/wikipedia/commons/thumb/b/b0/Rottenburg_a.N._-_Wurmlingen_-_Kapellenberg_-_Ansicht_von_OSO_im_April_mit_Gegenlicht.jpg/2880px-Rottenburg_a.N._-_Wurmlingen_-_Kapellenberg_-_Ansicht_von_OSO_im_April_mit_Gegenlicht.jpg",
    "https://upload.wikimedia.org/wikipedia/commons/thumb/e/e4/20170920_Lausanne-13.jpg/640px-20170920_Lausanne-13.jpg",
    "https://upload.wikimedia.org/wikipedia/commons/thumb/b/b0/Rottenburg_a.N._-_Wurmlingen_-_Kapellenberg_-_Ansicht_von_OSO_im_April_mit_Gegenlicht.jpg/2880px-Rottenburg_a.N._-_Wurmlingen_-_Kapellenberg_-_Ansicht_von_OSO_im_April_mit_Gegenlicht.jpg",
    "https://upload.wikimedia.org/wikipedia/commons/thumb/e/e4/20170920_Lausanne-13.jpg/640px-20170920_Lausanne-13.jpg",
    "https://upload.wikimedia.org/wikipedia/commons/thumb/b/b0/Rottenburg_a.N._-_Wurmlingen_-_Kapellenberg_-_Ansicht_von_OSO_im_April_mit_Gegenlicht.jpg/2880px-Rottenburg_a.N._-_Wurmlingen_-_Kapellenberg_-_Ansicht_von_OSO_im_April_mit_Gegenlicht.jpg",
    "https://upload.wikimedia.org/wikipedia/commons/thumb/e/e4/20170920_Lausanne-13.jpg/640px-20170920_Lausanne-13.jpg",
]);

const emit = defineEmits(["handleClose"]);
</script>

<template>
    <div class="trail">
        <TheCardNav @handle-close="emit('handleClose')" />

        <div class="tags">
            <div class="tag">
                <BaseTag :tag="data.tag" :selected="true">{{
                    data.tag
                }}</BaseTag>
            </div>
            <BaseDividerVert />
            <div class="tag">
                <BaseTag :tag="data.tag" :selected="false">{{
                    data.tag
                }}</BaseTag>
            </div>
        </div>

        <h1>{{ data.name }}</h1>

        <div class="stars">Stars here</div>

        <div class="infos">
            <p>
                <span class="material-symbols-rounded">access_time</span>
                {{ data.time }}
            </p>
            <span class="material-symbols-rounded">accessible</span>
            <p>5 points d'intérêts</p>
        </div>

        <div class="actions">
            <PrimaryButton>Commencer</PrimaryButton>
            <SecondaryButton icon="bookmark">Enrengistrer</SecondaryButton>
            <SecondaryButton icon="star">Favoris</SecondaryButton>
        </div>

        <BaseImgGalery :imgs="imgs" />

        <h2>Description</h2>
        <div class="tag">
            <BaseTag :tag="data.tag" :selected="false">{{ data.tag }}</BaseTag>
        </div>
        <p>
            {{ data.description }}
        </p>

        <div class="itineraire">
            <h2>Itinéraire</h2>
            <div class="tag">
                <BaseTag :tag="data.tag" :selected="true">{{
                    data.tag
                }}</BaseTag>
            </div>
        </div>
        <div class="infos">
            <p>
                <span class="material-symbols-rounded">access_time</span>
                {{ data.time }}
            </p>
            <p>5 km</p>
        </div>
        <BaseMap />

        <AppCardList :datas="dataTest">Points d'intérêt du sentier</AppCardList>

        <h2>Accessibilité</h2>
        <div class="infos accessibilite">
            <span class="material-symbols-rounded">train</span>
            <span class="material-symbols-rounded">local_parking</span>
            <span class="material-symbols-rounded">accessible</span>
        </div>
        <p>Le sentier est accessible</p>

        <h2>Avis</h2>
        <p>Il n'y a pas encore de commentaires</p>
    </div>
</template>

<style scoped>
.trail {
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

.tag {
    display: flex;
    gap: 0.5rem;
}

.infos {
    display: flex;
    justify-content: space-between;

    width: 100%;
    padding-right: 1rem;
}

.accessibilite{
    justify-content: flex-start;
    gap: 0.5rem;
}

.accessibilite span {
    font-size: 3rem;
}

.actions {
    display: flex;
    gap: 0.5rem;

    width: 100%;
    padding-right: 1rem;

    overflow-x: scroll;
}

.itineraire {
    display: flex;
    flex-direction: row;
    gap: 0.5rem;
    align-items: center;
    height: fit-content;
}

#map {
    height: 20rem;
    width: calc(100% - 1rem);
    border-radius: 1rem;
}
</style>
