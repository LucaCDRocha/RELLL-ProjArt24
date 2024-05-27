<script setup>
import { ref, defineProps } from "vue";
import BaseTag from "@/Components/BaseTag.vue";
import BaseBottomSheet from "@/Components/BaseBottomSheet.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const isOpen = ref(false);

const toggleBottomSheet = () => {
    isOpen.value = !isOpen.value;
};

defineProps({
    tag: {
        type: String,
        default: () => [],
    },
});
</script>

<template>
    <div class="card" @click="isOpen = !isOpen">
        <div class="tag">
            <BaseTag :tag="tag">{{ tag }}</BaseTag>
        </div>
        <p><slot /></p>
    </div>
    <BaseBottomSheet
        v-if="isOpen"
        :isOpen="isOpen"
        @handle-open="toggleBottomSheet()"
    >
        <h1><slot /></h1>
        <div class="tag">
            <BaseTag :tag="tag">{{ tag }}</BaseTag>
        </div>

        <div>
            <PrimaryButton>Valider</PrimaryButton>

            <SecondaryButton icon="close" @click="toggleBottomSheet()"
                >Fermer</SecondaryButton
            >
        </div>
        <p>
            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quia
            minima quis, ex obcaecati ullam commodi a veniam rerum accusantium
            repellendus quae doloribus veritatis nesciunt corporis? Minima
            quaerat aspernatur nihil et?

            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quia
            minima quis, ex obcaecati ullam commodi a veniam rerum accusantium
            repellendus quae doloribus veritatis nesciunt corporis? Minima
            quaerat aspernatur nihil et?

            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quia
            minima quis, ex obcaecati ullam commodi a veniam rerum accusantium
            repellendus quae doloribus veritatis nesciunt corporis? Minima
            quaerat aspernatur nihil et?
        </p>
    </BaseBottomSheet>
</template>

<style scoped>
div.card {
    display: flex;
    flex-direction: column;
    align-self: center;
    justify-content: flex-end;

    height: 10rem;
    padding: 1rem;
    margin-right: 1rem;
    margin-bottom: 1rem;

    border-radius: 1.75rem;
    box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);

    background-color: beige;
    background: linear-gradient(180deg, rgba(32, 32, 32, 0) 0%, #202020 94.1%),
        white 50% / cover no-repeat;
}

.tag {
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 0.6rem;
}

.card p {
    @apply text-xl text-green-50;

    width: 10rem;
}
</style>
