<script setup>
import { ref, watch } from "vue";
import BaseTag from "@/Components/BaseTag.vue";
import BaseBottomSheet from "@/Components/BaseBottomSheet.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import AppTrailInfo from "@/Components/AppTrailInfo.vue";
import AppInterestPointInfo from "@/Components/AppInterestPointInfo.vue";

const isOpen = ref(false);

watch(isOpen, (value) => {
    if (value) {
        document.body.style.overflow = "hidden";
    } else {
        document.body.style.overflow = "auto";
    }
});

const toggleBottomSheet = () => {
    isOpen.value = !isOpen.value;
};

defineProps({
    data: {
        type: Object,
        default: () => {},
    },
});
</script>

<template>
    <div class="card" @click="toggleBottomSheet()">
        <div class="tag">
            <BaseTag :tag="data.tag" :selected="true">{{ data.tag }}</BaseTag>
        </div>
        <p>{{ data.name }}</p>
    </div>
    <BaseBottomSheet
        v-if="isOpen"
        :isOpen="isOpen"
        @handle-open="toggleBottomSheet()"
    >
        <AppTrailInfo :data="data" @handle-open="toggleBottomSheet()" />
    </BaseBottomSheet>
</template>

<style scoped>
div.card {
    display: flex;
    flex-direction: column;
    align-self: center;
    justify-content: space-between;

    height: 10rem;
    padding: 1rem;
    margin-bottom: 1rem;

    border-radius: 1.75rem;
    box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);

    background-color: beige;
    background: linear-gradient(180deg, rgba(0, 19, 2, 0) 0%, #001a04 94.1%),
        url("https://upload.wikimedia.org/wikipedia/commons/4/4e/Pleiades_large.jpg")
            rgb(247, 255, 247) 50% / cover no-repeat;
}

.card .tag {
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 0.6rem;
    justify-content: flex-end;
}

.card p {
    @apply text-xl text-green-50;

    width: 10rem;
}
</style>
