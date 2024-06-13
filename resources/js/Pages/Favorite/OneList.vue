<script setup>
import { onMounted, ref } from "vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import TheNav from "@/Components/TheNav.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import BaseCard from "@/Components/BaseCard.vue";
import BaseBottomSheet from "@/Components/BaseBottomSheet.vue";
import AppTrailInfo from "@/Components/AppTrailInfo.vue";
import AppInterestPointInfo from "@/Components/AppInterestPointInfo.vue";
import TheHeader from "@/Components/TheHeader.vue";
import DangerButton from "@/Components/DangerButton.vue";
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const items = defineProps({
    trailsList: {
        type: Array,
        default: () => [],
    },
    listDetails: {
        type: Object,
        default: () => [],
    },
});
const form = useForm({
    id: items.listDetails.id,
});
const submit = () => {
    form.get(route("bookmark.edit", { id: items.listDetails.id }), {});
};

const deleteList = () => {
    form.delete(route("bookmark.destroy", { id: items.listDetails.id }), {});
};

const showModal = ref(false);
const openModal = () => {
    showModal.value = !showModal.value;
};

const isOpen = ref(false);

const data = ref({});

const bottomSheet = (e) => {
    if (e.point.difficulty) {
        fetch(route("trails.showJson", e.point.id))
            .then((response) => response.json())
            .then((datas) => {
                data.value = datas;
                isOpen.value = true;
                const scroll = document.querySelector(
                    ".base-overlay-card__content"
                );
                scroll ? (scroll.scrollTop = 0) : null;
            });
    } else {
        fetch(route("interestPoints.showJson", e.point.id))
            .then((response) => response.json())
            .then((datas) => {
                data.value = datas;
                isOpen.value = true;
                const scroll = document.querySelector(
                    ".base-overlay-card__content"
                );
                scroll ? (scroll.scrollTop = 0) : null;
            });
    }
    window.location.hash = "bottom-sheet";
};

const closeBottomSheet = () => {
    isOpen.value = false;
    full.value = false;
    window.location.hash = "";
};

const full = ref(false);
const toggleFull = () => {
    full.value = true;
};
</script>
<template>
    <Head :title="listDetails.name" />

    <TheHeader />

    <div class="oneList">
        <div class="title">
            <h1>{{ listDetails.name }}</h1>
            <div>
                <Link
                    :href="route('bookmark.index')"
                    class="underline text-sm font-medium text-onSurface dark:text-onSurface hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-offset-gray-800"
                >
                    Retour</Link
                >
                <SecondaryButton @click="submit" class="ms-4" icon="edit">
                    Modifier
                </SecondaryButton>
            </div>
        </div>
        <div class="trailsList">
            <BaseCard
                v-for="trail in trailsList"
                :key="trail.id"
                :data="trail"
                @click="bottomSheet(trail)"
            ></BaseCard>
        </div>
        <div
            v-if="items.listDetails.name.toLowerCase() !== 'favoris'"
            class="dangerButton"
        >
            <DangerButton @click="openModal()" icon="delete">
                Supprimer la liste
            </DangerButton>
        </div>
    </div>

    <Modal :show="showModal" @close="openModal()">
        <div class="confirmation-modal">
            <h2>Voulez-vous vraiment supprimer cette liste ?</h2>
            <div class="actions">
                <a
                    @click.prevent="deleteList()"
                    class="cursor-pointer underline text-sm font-medium text-error dark:text-darkError hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-offset-gray-800"
                >
                    Supprimer la liste
                </a>
                <PrimaryButton @click="openModal()">
                    Non, annuler
                </PrimaryButton>
            </div>
        </div>
    </Modal>

    <BaseBottomSheet
        v-if="isOpen"
        :isOpen="isOpen"
        @handle-close="closeBottomSheet()"
        @handle-full="toggleFull()"
    >
        <AppTrailInfo
            v-if="data.difficulty"
            :data="data"
            :full="full"
            @handle-close="closeBottomSheet()"
            @handle-point="bottomSheet($event)"
        />
        <AppInterestPointInfo
            v-else
            :data="data"
            :full="full"
            @handle-close="closeBottomSheet()"
            @handle-point="bottomSheet($event)"
        />
    </BaseBottomSheet>
    <TheNav />
</template>

<style scoped>
.oneList {
    padding: 1rem 1rem 0rem 1rem;
}

.title {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 1.25rem;
    margin-bottom: 2.25rem;
}

div.trailsList {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    column-gap: 1.25rem;
}

.actions {
    display: flex;
    justify-content: center;
    align-items: center;
    align-self: flex-end;
    gap: 1rem;
    margin-top: 1rem;
}

.confirmation-modal {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 2rem;
}
.actions a {
    @apply text-red-500 dark:text-red-400;
}
</style>
