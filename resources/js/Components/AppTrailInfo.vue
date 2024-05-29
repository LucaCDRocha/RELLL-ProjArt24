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
    <TheCardNav @handle-close="emit('handleClose')" />
    <h1>{{ data.name }}</h1>
    <div class="tag">
        <BaseTag :tag="data.tag" :selected="true">{{ data.tag }}</BaseTag>
    </div>

    <div>
        <PrimaryButton>Valider</PrimaryButton>

        <SecondaryButton icon="close" @click.self="emit('handleClose')"
            >Fermer</SecondaryButton
        >
    </div>
    <p>
        {{ data.description }}
    </p>
</template>

<style scoped></style>
