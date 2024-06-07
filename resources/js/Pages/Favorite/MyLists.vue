<script setup>
import { useForm, Link } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import BaseCheckbox from "@/Components/BaseCheckbox.vue";
import BasePlainButton from "@/Components/BasePlainButton.vue";
import NewList from "@/Pages/Favorite/NewList.vue";
import BaseBottomSheet from "@/Components/BaseBottomSheet.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    trailId: {
        type: String,
        required: true,
    },
    allLists: {
        type: Object
    },
    listIds: {
        type: Array
    }
});

const newIsOpen = ref(false);
const toggleBottomSheetNew = () => {
    newIsOpen.value = !newIsOpen.value;
};

const form = useForm({
    trail_id: props.trailId,
    check_ids: props.listIds,
});

watch(form, (value) => {
    console.log(form);
});

const submit = () => {
    console.log(form);
    form.post(route("bookmark.addTrail"), {});
};

const emit = defineEmits(["handleOpen"]);

</script>

<template>
    <div>
        <div class="lists">
            <h3>A quelle liste voulez-vous ajouter le sentier {{ title }} ?</h3>
            <form @submit.prevent="submit">

                <BaseCheckbox v-for="list in allLists"
                    :id="list.id"
                    :name="list.name"
                    :count="list.trail_ids.length"
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
                        @click="toggleBottomSheetNew()"
                        >close</span
                    >
                    <NewList />
                </BaseBottomSheet>

                <div class="finalLinks">
                <Link
                    href=""
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
            </div>
            </form>
        </div>
    </div>
</template>



<style scoped>
div.lists{
    padding: 1rem 1rem 0rem 1rem;
}

.lists h3 {
    font-size: 1.375rem;
}

div.finalLinks{
    display: flex;
    justify-content: flex-end;
    margin-top: 1rem;
    align-items: center;
}
</style>