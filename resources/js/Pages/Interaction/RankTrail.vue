<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue'
import BaseTextArea from '@/Components/BaseTextArea.vue';
import AppStarRanking from '@Compenents/AppStarRanking.vue';

const props = defineProps({
    trail_id: {
        type: Number,
        required: true,
    },
})

const form = useForm({
    trail_id = props.trail_id,
    rank: 0,
    comment: '',    
})

watch(form, (value) => {
    console.log(form);
})

const submit = () => {
    form.post(route('rank.store'), {
    });
};

</script>



<template>
    <Head title="Votre avis sur le sentier" />
    <p>* Champs obligatoires</p>
    <form @submit.prevent="submit">
        <div>
            <InputLabel for="rank" value="Quelle est votre note sur le sentier ? *"/>
            <AppStarRanking id="rank"></AppStarRanking>
            <InputError class="mt-2" :message="form.errors.rank" />
        </div>
        <div>
            <InputLabel for="comment" value="Quelle est votre avis sur le sentier ? *"/>
            <BaseTextArea id="comment" class="mt-1 block w-full" v-model="form.comment" autofocus placeholder="Comment"></BaseTextArea>
            <InputError class="mt-2" :message="form.errors.comment" />
        </div>
    </form>
    <a href="home"></a> <PrimaryButton>Valider</PrimaryButton>
</template>

<style scoped></style>