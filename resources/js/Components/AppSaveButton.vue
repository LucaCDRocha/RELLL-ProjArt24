<script setup>
import { useForm, Link } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import BaseBottomSheet from "@/Components/BaseBottomSheet.vue";
import BaseCheckbox from "@/Components/BaseCheckbox.vue";
import BasePlainButton from "@/Components/BasePlainButton.vue";
import NewList from "@/Pages/Favorite/NewList.vue";

const isOpen = ref(false);
const toggleBottomSheet = () => {
    isOpen.value = !isOpen.value;
};

const newIsOpen = ref(false);
const toggleBottomSheetNew = () => {
    newIsOpen.value = !newIsOpen.value;
};

const emit = defineEmits(["handleOpen"]);

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    id: {
        type: Number,
        required: true,
    },
    allLists: {
        type: [],
    },
});

const form = useForm({
    trail_id: props.id,
    check_ids: [],
});

watch(form, (value) => {
    console.log(form);
});

const submit = () => {
    console.log(form);
    form.post(route("bookmark.addTrail"), {});
};
</script>

<template>
    <!-- <Link href="route('bookmark.allLists')"> -->
    <SecondaryButton icon="bookmark" @click="toggleBottomSheet()">
        Enregistrer</SecondaryButton
    >
    <!-- </Link> -->

    <BaseBottomSheet
        v-if="isOpen"
        :isOpen="isOpen"
        @handle-close="toggleBottomSheet()"
    >
        <div class="lists">
            <h2>A quelle liste voulez-vous ajouter le sentier {{ title }} ?</h2>
            <form @submit.prevent="submit">
                <BaseCheckbox
                    :id="2"
                    name="favoris"
                    :count="12"
                    v-model="form.check_ids"
                />
                <BaseCheckbox
                    :id="4"
                    name="A faire avec ma famille"
                    :count="12"
                    v-model="form.check_ids"
                />
                <BaseCheckbox
                    :id="5"
                    name="A refaire"
                    :count="12"
                    v-model="form.check_ids"
                />
                <BaseCheckbox
                    :id="6"
                    name="Why not"
                    :count="12"
                    v-model="form.check_ids"
                />

                <BasePlainButton
                    @click.prevent="toggleBottomSheetNew()"
                    type="submit"
                    icon="add_circle"
                    >Créer une nouvelle liste</BasePlainButton
                >
                <BaseBottomSheet
                    v-if="newIsOpen"
                    :isOpen="newIsOpen"
                    @handle-close="toggleBottomSheetNew()"
                >
                    <span
                        class="material-symbols-rounded"
                        @click="toggleBottomSheet()"
                        >close</span
                    >
                    <NewList />
                </BaseBottomSheet>
                <br />

                <Link
                    @click.prevent="toggleBottomSheet()"
                    class="underline text-sm font-medium text-onSurface dark:text-onSurface hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-offset-gray-800"
                >
                    Annuler</Link
                >
                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Ajouter
                </PrimaryButton>
            </form>
        </div>
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
