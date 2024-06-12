<script setup>
import { ref } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import BaseTag from "@/Components/BaseTag.vue";
import BaseImgGalery from "@/Components/BaseImgGalery.vue";
import TheCardNav from "@/Components/TheCardNav.vue";
import AppCardList from "@/Components/AppCardList.vue";
import { convertDate } from "@/Helpers/timeHelper.js";

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

const imgs = ref([]);

for (const img of props.data.imgs) {
    imgs.value.push(img.img_path);
}

const emit = defineEmits(["handle-close", "handle-point"]);
</script>

<template>
    <div class="interest-point">
        <div class="header">
            <TheCardNav
                @handle-close="emit('handle-close')"
                :is-full="full"
                :interest-point-id="data.id"
            />
            <div class="tags" v-if="!full">
                <BaseTag
                    v-for="tag in data.tags"
                    :key="tag.id"
                    :tag="tag.name"
                    :selected="true"
                />
            </div>
            <div>
                <h1>{{ data.name }}</h1>
                <div class="ouvertures">
                    <p>{{ data.open_seasons }}</p>
                </div>
            </div>
            <a
                v-if="data.url !== '-' && full"
                :href="data.url"
                target="_blank"
                rel="noopener noreferrer"
            >
                <PrimaryButton>Voir le site web</PrimaryButton>
            </a>
            <BaseImgGalery :imgs="imgs" />
        </div>

        <div class="description">
            <h2>Description</h2>
            <div class="tags">
                <BaseTag
                    v-for="tag in data.tags"
                    :key="tag.id"
                    :tag="tag.name"
                    :selected="true"
                />
            </div>
            <p>{{ data.description }}</p>
        </div>

        <AppCardList
            :datas="data.trails"
            @handle-point="emit('handle-point', $event)"
            >Les sentiers menant à ce lieu</AppCardList
        >

        <div class="information">
            <h2>Informations sur le sentier</h2>
            <p>Ce sentier a été créé le {{ convertDate(data.created_at) }}</p>
            <p>Dernière modification le {{ convertDate(data.updated_at) }}</p>
        </div>
    </div>
</template>

<style scoped>
.interest-point {
    display: flex;
    flex-direction: column;
    gap: 2rem;
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
    padding-right: 1rem;
}

.description {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    width: 100%;
    padding-right: 1rem;
}

.header {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    align-items: flex-start;
    width: 100%;
}

.information {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    align-items: flex-start;
    width: 100%;
    padding-right: 1rem;
}
</style>
