<script setup>
import { ref, watch } from "vue";
import BaseTag from "@/Components/BaseTag.vue";
import BaseBottomSheet from "@/Components/BaseBottomSheet.vue";
import AppTrailInfo from "@/Components/AppTrailInfo.vue";
import AppInterestPointInfo from "@/Components/AppInterestPointInfo.vue";

const isOpen = ref(false);

const toggleBottomSheet = () => {
    isOpen.value = !isOpen.value;
};

const props = defineProps({
    data: {
        type: Object,
        default: () => {},
    },
});

const img = ref();
if (props.data.imgs) {
    img.value = props.data.imgs[0].img_path;
}else{
    img.value = props.data.img.img_path;
}
</script>

<template>
    <div
        class="card"
        @click="toggleBottomSheet()"
        :style="{
            background: `linear-gradient(180deg, rgba(255, 255, 255, 0.00) 0%, rgba(213, 213, 213, 0.26) 24.3%, rgba(128, 128, 128, 0.75) 62.15%, #2B2B2B 100%), url(${img}) lightgray 50% / cover no-repeat`,
        }"
    >
        <div class="tag">
            <BaseTag v-if="data.difficulty" :tag="data.difficulty" :selected="true">{{
                data.difficulty
            }}</BaseTag>
        </div>
        <p>{{ data.name }}</p>
    </div>
    <BaseBottomSheet
        v-if="isOpen"
        :isOpen="isOpen"
        @handle-open="toggleBottomSheet()"
    >
        <AppTrailInfo v-if="data.note" :data="data" @handle-open="toggleBottomSheet()" />
        <AppInterestPointInfo v-else :data="data" @handle-open="toggleBottomSheet()" />
    </BaseBottomSheet>
</template>

<style scoped>
div.card {
    display: flex;
    flex-direction: column;
    align-self: center;
    justify-content: space-between;

    height: 11rem;
    width: 11rem;
    padding: 1rem;
    margin-bottom: 1rem;

    border-radius: 1.75rem;
    box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);

    /* background-color: beige;
    background: linear-gradient(180deg, rgba(0, 19, 2, 0) 0%, #001a04 94.1%),
        url("") rgb(247, 255, 247) 50% / cover no-repeat; */
}

.card .tag {
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 0.6rem;
    justify-content: flex-end;
}

.card p {
    @apply text-base text-white font-medium;

    width: 11rem;
}
</style>
