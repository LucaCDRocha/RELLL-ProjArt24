<script setup>
import { ref } from "vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import BaseBottomSheet from "@/Components/BaseBottomSheet.vue";
import MyLists from "@/Pages/Favorite/MyLists.vue";

const isOpen = ref(false);

const toggleBottomSheet = () => {
    isOpen.value = !isOpen.value;
};

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    id: {
        type: Number,
        required: true,
    },
    inDropdown: {
        type: Boolean,
        default: false,
    },
});
const isSave = ref(false);
const isSaved = (e) => {
    e.allLists.find((list) => list.trail_ids.includes(props.id))
        ? (isSave.value = true)
        : (isSave.value = false);
};
</script>

<template>
    <SecondaryButton
        v-if="!inDropdown"
        icon="bookmark"
        @click="toggleBottomSheet()"
        :class="{ active: isSave }"
    >
        Enregistrer</SecondaryButton
    >

    <p v-else :class="{ active: isSave }" @click="toggleBottomSheet()" class="cursor-pointer">
        <span class="material-symbols-rounded">bookmark</span>
        Enregistrer
    </p>

    <BaseBottomSheet
        v-show="isOpen"
        :isOpen="isOpen"
        @handle-close="toggleBottomSheet()"
    >
        <MyLists
            :trailId="props.id"
            :title="props.title"
            @handle-open="toggleBottomSheet()"
            @emit-lists="isSaved($event)"
        />
    </BaseBottomSheet>
</template>

<style scoped>
.lists {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    align-items: flex-start;
    width: 100%;
    height: fit-content;
}

.active :deep(.material-symbols-rounded) {
    font-variation-settings: "FILL" 1;
}

.active .material-symbols-rounded {
    font-variation-settings: "FILL" 1;
}
</style>
