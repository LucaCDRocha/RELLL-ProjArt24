<script setup>
import { onMounted, ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import BaseTag from "@/Components/BaseTag.vue";
import BaseDividerVert from "@/Components/BaseDividerVert.vue";
import TheCardNav from "@/Components/TheCardNav.vue";
import BaseImgGalery from "@/Components/BaseImgGalery.vue";
import AppCardList from "@/Components/AppCardList.vue";
import BaseMap from "@/Components/BaseMap.vue";
import AppSaveButton from "@/Components/AppSaveButton.vue";
import AppStarRanking from "@/Components/AppStarRanking.vue";
import BaseAccordion from "@/Components/BaseAccordion.vue";
import AppReviewCard from "@/Components/AppReviewCard.vue";
import {
    convertTime,
    convertDate,
    getTimeDifference,
} from "@/Helpers/timeHelper.js";
import { trailInfo } from "@/Stores/map";

const props = defineProps({
    data: {
        type: Object,
        default: () => {},
    },
    full: {
        type: Boolean,
        default: false,
    },
});

props.data.time = convertTime(props.data.time);

const tags = ref([]);
for (const interestPoint of props.data.interest_points) {
    for (const tag of interestPoint.tags) {
        if (!tags.value.find((t) => t.name === tag.name)) {
            tags.value.push(tag);
        }
    }
}

const user = usePage().props.auth.user;
const isUserLoggedIn = user && Object.keys(user).length > 0;

const imgs = ref([]);

imgs.value.push(props.data.img.img_path);

for (const point of props.data.interest_points) {
    for (const img of point.imgs) {
        imgs.value.push(img.img_path);
    }
}

const trailDistance = ref(0);
onMounted(() => {
    setTimeout(() => {
        trailDistance.value =
            Math.round((trailInfo.value.summary.totalDistance / 1000) * 10) /
            10;
    }, 1000);
});

const emit = defineEmits(["handle-close", "handle-point"]);
</script>

<template>
    <div class="trail">
        <div class="header">
            <TheCardNav
                @handle-close="emit('handle-close')"
                :is-full="full"
                :trail-id="data.id"
            />

            <div class="tags" v-if="!full">
                <div class="tag">
                    <BaseTag :tag="data.difficulty" :selected="true" />
                </div>

                <BaseDividerVert style="padding-left: 0.06rem" />

                <div class="tag">
                    <BaseTag
                        v-for="tag in tags"
                        :key="tag.id"
                        :tag="tag.name"
                        :selected="true"
                    />
                </div>
            </div>

            <div>
                <h1>{{ data.name }}</h1>

                <div class="stars" v-if="data.note">
                    <AppStarRanking :rating="data.note" />
                </div>
            </div>

            <div class="infos" v-if="!full">
                <p>
                    <span class="material-symbols-rounded">access_time</span>
                    {{ data.time }}
                </p>
                <span class="material-symbols-rounded" v-if="data.is_accessible"
                    >accessible</span
                >
                <p>{{ data.interest_points.length }} lieux</p>
            </div>

            <div class="actions">
                <PrimaryButton
                    @click="$inertia.visit(`/trail-start/${data.id}`)"
                    >Commencer</PrimaryButton
                >
                <AppSaveButton
                    v-if="isUserLoggedIn"
                    :title="data.name"
                    :id="data.id"
                />
            </div>

            <BaseImgGalery :imgs="imgs" />
        </div>

        <div class="desciption">
            <h2>Description</h2>
            <div class="tags">
                <BaseTag
                    v-for="tag in tags"
                    :key="tag.id"
                    :tag="tag.name"
                    :selected="true"
                />
            </div>
            <p>
                {{ data.description }}
            </p>
        </div>

        <div class="accordion">
            <BaseAccordion
                title="Itinéraire"
                :id="1"
                :tag="data.difficulty"
                :multiple="true"
            >
                <div class="content">
                    <div class="infos">
                        <p>
                            <span class="material-symbols-rounded"
                                >access_time</span
                            >
                            {{ data.time }}
                        </p>
                        <p>{{ trailDistance }} km</p>
                    </div>
                    <BaseMap :draggable="false" :waypoints="data" />
                </div>
            </BaseAccordion>
        </div>

        <AppCardList
            :datas="data.interest_points"
            @handle-point="emit('handle-point', $event)"
            >Les {{ data.interest_points.length }} lieux présents dans ce
            sentier</AppCardList
        >

        <div class="accordion">
            <BaseAccordion title="Accessibilité" :id="2">
                <div class="content">
                    <div class="infos accessibilite">
                        <span
                            class="material-symbols-rounded"
                            v-if="data.info_transports"
                            >train</span
                        >
                        <span
                            class="material-symbols-rounded"
                            v-if="data.location_parking_id"
                            >local_parking</span
                        >
                        <span
                            class="material-symbols-rounded"
                            v-if="data.is_accessible"
                            >accessible</span
                        >
                    </div>
                    <p v-if="data.info_transports">
                        {{ data.info_transports }}
                    </p>
                </div>
            </BaseAccordion>
        </div>

        <div class="accordion">
            <BaseAccordion
                :title="`Avis (${data['reactions'].length})`"
                :id="3"
            >
                <div v-if="!data['reactions']" class="content">
                    <p>Il n'y a pas encore de commentaires</p>
                </div>
                <div v-else class="content">
                    <div class="note_stars">
                        <p>{{ Math.floor(data.note * 10) / 10 }}</p>
                        <AppStarRanking :rating="data.note" />
                    </div>
                    <AppReviewCard
                        v-for="data in data['reactions']"
                        :key="data.user.id"
                        :data="data"
                    />
                </div>
            </BaseAccordion>
        </div>

        <div class="information">
            <h2>Informations sur le sentier</h2>
            <p>
                Ce sentier a été créé par {{ data.user.name }} le
                {{ convertDate(data.created_at) }}
            </p>
            <p>Dernière modification le {{ convertDate(data.updated_at) }}</p>
        </div>
    </div>
</template>

<style scoped>
.trail {
    display: flex;
    flex-direction: column;
    gap: 2rem;
    align-items: flex-start;
    width: 100%;
    height: fit-content;
}

.header {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    align-items: flex-start;
    width: 100%;
}

.accordion {
    width: 100%;
    height: fit-content;
}

.tags {
    display: flex;
    gap: 0.5rem;
    max-width: 100%;
    overflow-x: scroll;
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

.infos p {
    display: flex;
    gap: 0.2rem;
}

.accessibilite {
    justify-content: flex-start;
    gap: 0.5rem;
}

.accessibilite span {
    font-size: 2rem;
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
    width: 100%;
    border-radius: 1rem;
}

.desciption {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    align-items: flex-start;
    width: 100%;
    height: fit-content;
}

.desciption p {
    padding-right: 1rem;
}

.content {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    padding-top: 1rem;
}

.information {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    align-items: flex-start;
    width: 100%;
    height: fit-content;
}

.accordion {
    padding-right: 1rem;
}

.note_stars {
    display: flex;
    gap: 0.5rem;
}
</style>
