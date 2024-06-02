<script setup>
import { ref } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import BaseTag from "@/Components/BaseTag.vue";
import BaseImgGalery from "@/Components/BaseImgGalery.vue";
import TheCardNav from "@/Components/TheCardNav.vue";
import AppCardList from "@/Components/AppCardList.vue";

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

const emit = defineEmits(["handleOpen"]);
</script>

<template>
    <div class="interest-point">
        <TheCardNav @handle-close="emit('handleOpen')" />
        <h1>{{ data.name }}</h1>
        <div class="ouvertures">
            <p>{{ data.open_season }}</p>
        </div>
        <div class="tags" v-if="!full">
            <BaseTag :tag="data.tag.name" />
        </div>
        <PrimaryButton>Voir le site web</PrimaryButton>
        <BaseImgGalery :imgs="imgs" />
        <h2>Description</h2>
        <div class="tags">
            <BaseTag :tag="data.tag.name" />
        </div>
        <p>{{ data.description }}</p>
        <!-- <AppCardList :datas="dataTest">Les sentier ayant ce lieu</AppCardList> -->
    </div>
</template>

<style scoped>
.interest-point {
    @apply bg-green-50 dark:bg-green-950;
    @apply text-green-950 dark:text-green-50;

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
    padding-right: 1rem;
}
</style>
