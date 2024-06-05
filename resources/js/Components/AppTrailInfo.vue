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
import AppSaveButton from "@/Components/AppSaveButton.vue";
import AppStarRanking from "@/Components/AppStarRanking.vue";
import BaseAccordion from "@/Components/BaseAccordion.vue";

const props = defineProps({
    data: {
        type: Object,
        default: () => { },
    },
    full: {
        type: Boolean,
        default: false,
    },
});

const imgs = ref([]);

imgs.value.push(props.data.img.img_path);

for (const point of props.data.interest_points) {
    for (const img of point.imgs) {
        imgs.value.push(img.img_path);
    }
}

const emit = defineEmits(["handleOpen"]);
</script>

<template>
    <div class="trail">
        <TheCardNav @handle-close="emit('handleOpen')" />

        <div class="tags" v-if="!full">
            <div class="tag">
                <BaseTag :tag="data.difficulty" :selected="true" />
            </div>
            <BaseDividerVert />
            <div class="tag">
                <BaseTag v-for="theme in data.themes" :key="theme.id" :tag="theme.name" :selected="true" />
            </div>
        </div>

        <h1>{{ data.name }}</h1>

        <div class="stars">
            <AppStarRanking :rating="data.note" />
        </div>

        <div class="infos" v-if="!full">
            <p>
                <span class="material-symbols-rounded">access_time</span>
                {{ data.time }}
            </p>
            <p>5 km</p>
        </div>

        <div class="actions">
            <PrimaryButton @click="$inertia.visit(`/trail-start/${data.id}`)">Commencer</PrimaryButton>
            <AppSaveButton :title="data.name" :id="data.id" />
            <SecondaryButton icon="star">Favoris</SecondaryButton>
        </div>

        <BaseImgGalery :imgs="imgs" />

        <h2>Description</h2>
        <div class="tag">
            <BaseTag v-for="theme in data.themes" :key="theme.id" :tag="theme.name" :selected="false" />
        </div>
        <p>
            {{ data.description }}
        </p>

        <div class="accordion">
            <BaseAccordion title="Itinéraire" :id="1" :tag="data.difficulty" :multiple="true">
                <div class="infos">
                    <p>
                        <span class="material-symbols-rounded">access_time</span>
                        {{ data.time }}
                    </p>
                    <p>5 km</p>
                </div>
                <BaseMap :draggable="false" :waypoints="data" />
            </BaseAccordion>
        </div>

        <AppCardList :datas="data.interest_points">Points d'intérêt du sentier</AppCardList>

        <div class="accordion">
            <BaseAccordion title="Accessibilité" :id="2">
                <div class="infos accessibilite">
                    <span class="material-symbols-rounded">train</span>
                    <span class="material-symbols-rounded">local_parking</span>
                    <span class="material-symbols-rounded">accessible</span>
                </div>
                <p>Le sentier est accessible</p>
            </BaseAccordion>
        </div>

        <div class="accordion">
            <BaseAccordion title="Avis" :id="3">
                <p>Il n'y a pas encore de commentaires</p>
            </BaseAccordion>
        </div>
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

.accordion {
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

.stars {
    gap: 5rem;
}

.infos {
    display: flex;
    gap: 2.5rem;
    width: 100%;
    align-items: center;
    padding-right: 1rem;
}

.accessibilite {
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

#map {
    height: 20rem;
    width: calc(100% - 1rem);
    border-radius: 1rem;
}
</style>
