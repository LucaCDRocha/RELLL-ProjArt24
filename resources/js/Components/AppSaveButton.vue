<script setup>
import { Link } from "@inertiajs/vue3";
import { ref, watch } from "vue";
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
});
const isSave = ref(false);
const isSaved = (e) => {
    console.log(e.allLists);
    e.allLists.find((list) => list.trail_ids.includes(props.id))
        ? (isSave.value = true)
        : (isSave.value = false);
    console.log(isSave.value);
};
</script>

<template>
    <!-- <Link :href="route('bookmark.allLists', { name: title, trailId: id })"> -->
    <SecondaryButton
        icon="bookmark"
        @click="toggleBottomSheet()"
        :class="{ active: isSave }"
    >
        Enregistrer</SecondaryButton
    >
    <!-- </Link> -->

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
</style>
