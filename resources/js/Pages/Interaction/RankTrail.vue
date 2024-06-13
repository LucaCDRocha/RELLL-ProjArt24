<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import BaseTextArea from "@/Components/BaseTextArea.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { watch, ref } from "vue";

const props = defineProps({
    trail_id: {
        type: String,
        required: true,
    },
});

const form = useForm({
    trail_id: parseInt(props.trail_id),
    rank: 0,
    comment: "",
});

// const formComment = useForm({
//     trail_id: parseInt(props.trail_id),
//     comment: "",
// })

const rank = ref(0);

const rankStars = (e) => {
    rank.value = e;
    form.rank = e;
};

const submit = () => {
    if (form.rank === 0) {
        form.errors.rank = "Veuillez notez le sentier";
    } else {
        form.errors.rank = "";
    }
    if (form.errors.rank === "") {
        // if (formComment.comment != "") {
        //     console.log("ON RENTRE");
        //     formComment.post(route("comments.store"), {});
        // }
        form.post(route("rank.store"), {});
    }
};
</script>

<template>

    <Head title="Rank" />
    <div class="rank">
        <div>
            <h1>Votre avis sur le sentier</h1>
            <small>* Champs obligatoires</small>
        </div>
        <form @submit.prevent="submit()">
            <div>
                <InputLabel
                    for="rank"
                    value="Notez le sentier *"
                />
                <div class="stars">
                    <span v-for="num in 5" :key="num" @click="rankStars(num)" class="material-symbols-rounded"
                        :class="{ 'full-star': num <= rank }">star</span>
                </div>
                <InputError class="mt-2" :message="form.errors.rank" />
            </div>
            <div>
                <InputLabel
                    for="comment"
                    value="Quel est votre avis sur le sentier ?"
                />
                <BaseTextArea
                    id="comment"
                    class="mt-1 block w-full"
                    v-model="form.comment"
                    placeholder="Comment"
                ></BaseTextArea>
                <InputError class="mt-2" :message="form.errors.comment" />
            </div>
            <div class="actions">
                <a href="/"
                class="underline text-sm font-medium text-onSurface dark:text-darkOnSurface hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-offset-gray-800"
                >annuler</a>
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    >Valider</PrimaryButton
                >
            </div>
        </form>
    </div>
</template>

<style scoped>
.full-star {
    font-variation-settings: "FILL" 1;
}

.material-symbols-rounded {
    @apply text-5xl;
}

.stars {
    display: flex;
    justify-content: center;
}

.rank {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem;
}

form {
    width: 100%;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.actions {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    align-items: center;
}
</style>
