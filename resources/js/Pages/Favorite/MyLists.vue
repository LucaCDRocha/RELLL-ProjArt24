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
        type: Number,
        required: true,
    },
});

const title = ref(props.title);
const allLists = ref([]);
const listIds = ref([]);
const trailId = ref(props.trailId);

const fetching = async () => {
    fetch(
        route("bookmark.allLists", {
            trailId: trailId.value,
            name: title.value,
        })
    )
        .then((response) => response.json())
        .then((datas) => {
            console.log(datas);
            allLists.value = datas.allLists;
            listIds.value = datas.listIds;
            title.value = datas.title;
            trailId.value = parseInt(datas.trailId);
        });
};

fetching();

const isOpen = ref(false);
const toggleBottomSheet = () => {
    fetching().then(() => {
        isOpen.value = !isOpen.value;
    });
};

const form = useForm({
    trail_id: trailId.value,
    check_ids: listIds.value,
});

watch(form, (value) => {
    console.log(form);
});

const emit = defineEmits(["handleOpen"]);
const submit = () => {
    console.log(form);
    form.post(route("bookmark.addTrail"), {});
    emit("handleOpen");
};
</script>

<template>
    <div>
        <div class="lists">
            <h3>
                Dans quelle(s) liste(s) voulez-vous le sentier {{ title }} ?
            </h3>
            <form @submit.prevent="submit">
                <BaseCheckbox
                    v-for="list in allLists"
                    :key="list.id"
                    :id="list.id"
                    :name="list.name"
                    :count="list.trail_ids?.length ?? 0"
                    :checked="list.trail_ids?.includes(trailId)"
                    v-model="form.check_ids"
                />

                <BasePlainButton
                    @click.prevent="toggleBottomSheet()"
                    type="submit"
                    icon="add_circle"
                    >Créer une nouvelle liste</BasePlainButton
                >
                <BaseBottomSheet
                    v-if="isOpen"
                    :isOpen="isOpen"
                    @handle-close="toggleBottomSheet()"
                >
                    <span
                        class="material-symbols-rounded"
                        @click="toggleBottomSheet()"
                        >close</span
                    >
                    <NewList @send="toggleBottomSheet()" />
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
                        Valider
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </div>
</template>

<style scoped>
div.lists {
    padding: 1rem 1rem 0rem 1rem;
}

.lists h3 {
    font-size: 1.375rem;
}

div.finalLinks {
    display: flex;
    justify-content: flex-end;
    margin-top: 1rem;
    align-items: center;
}
</style>
