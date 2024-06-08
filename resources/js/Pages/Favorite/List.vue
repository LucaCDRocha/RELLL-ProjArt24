<script setup>
import { Head, usePage } from "@inertiajs/vue3";
import TheNav from "@/Components/TheNav.vue";
import BaseDivider from "@/Components/BaseDivider.vue";
import BaseLinkList from "@/Components/BaseLinkList.vue";
import BaseBottomSheet from "@/Components/BaseBottomSheet.vue";
import BasePlainButton from "@/Components/BasePlainButton.vue";
import NewList from "@/Pages/Favorite/NewList.vue";
import { ref, watch } from "vue";
import TheHeader from "@/Components/TheHeader.vue";
import BaseImgGrid from "@/Components/BaseImgGrid.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const isOpen = ref(false);

const toggleBottomSheet = () => {
    isOpen.value = !isOpen.value;
};

const listes = defineProps({
    list: {
        type: Array,
        default: () => [],
    },
});

const { props: pageProps } = usePage();
const successMessage = pageProps.flash?.success;
</script>
<template>
    <Head title="Vos listes" />

    <TheHeader />

    <div class="lists">
        <div class="title">
            <h2>Vos listes</h2>
            <SecondaryButton icon="add_circle" @click="toggleBottomSheet()"
                >Ajouter une liste</SecondaryButton
            >
        </div>
        <BaseDivider />

        <div v-if="successMessage" class="alert alert-success">
            {{ successMessage }}
        </div>

        <BaseLinkList
            v-for="el in list"
            :key="el.id"
            :name="el.name"
            :id="el.id"
            :link="route('bookmark.show', { id: el.id })"
            :numberElem="el.trails_count"
        />
    </div>

    <BaseBottomSheet
        v-if="isOpen"
        :isOpen="isOpen"
        @handle-close="toggleBottomSheet()"
    >
        <NewList @send="toggleBottomSheet()" />
    </BaseBottomSheet>

    <!-- <BaseImgGrid v-if="list.length > 0" :imgs="list" /> -->
    <TheNav />
</template>

<style scoped>
.lists {
    padding: 1rem 0rem 0rem 1rem;
}

.alert {
    padding: 1rem;
    margin-bottom: 1rem;
    border: 1px solid transparent;
    border-radius: 0.375rem;
}

.alert-success {
    color: #155724;
    background-color: #d4edda;
    border-color: #c3e6cb;
}

.title {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 1.25rem;
    margin-bottom: 2.25rem;
    padding-right: 1rem;
}
</style>
