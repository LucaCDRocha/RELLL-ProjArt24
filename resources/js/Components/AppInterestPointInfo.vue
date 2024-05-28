<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import BaseTag from "@/Components/BaseTag.vue";

defineProps({
    data: {
        type: Object,
        default: () => {},
    },
});

const emit = defineEmits(["handleClose"]);
</script>

<template>
    <h1>{{ data.name }}</h1>
    <p>{{ data.description }}</p>
    <div>
        <BaseTag v-for="tag in data.tags" :key="tag" :tag="tag">{{
            tag
        }}</BaseTag>
    </div>
    <p>Distance: {{ data.distance }} km</p>
    <p>Temps: {{ data.time }} min</p>
    <p>Difficulté: Facile</p>
    <!-- <p>Points d'intérêts: {{ props.waypoints.length }}</p> -->
    <p>Commentaires: 0</p>
    <div>
        <PrimaryButton>Valider</PrimaryButton>
        <SecondaryButton icon="close" @click.self="emit('handleClose')"
            >Fermer</SecondaryButton
        >
    </div>
</template>

<style scoped></style>
