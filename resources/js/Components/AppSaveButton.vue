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
    }
});

</script>

<template>
    <Link :href="route('bookmark.allLists', { name : title, trailId : id })">
    <SecondaryButton icon="bookmark" @click="toggleBottomSheet()">
        Enregistrer</SecondaryButton>
    </Link>

    <BaseBottomSheet v-if="isOpen" :isOpen="isOpen" @handle-close="toggleBottomSheet()">
        <MyLists />
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
</style>
