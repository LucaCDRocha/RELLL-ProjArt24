<script setup>
import { computed, ref } from "vue";
import DangerButton from "@/Components/DangerButton.vue";

const props = defineProps({
    data: {
        type: Object,
        default: () => {},
    },
});

const model = defineModel({
    type: Array,
    default: () => [],
});

const emit = defineEmits(["update:modelValue"]);

const isSelected = computed(() => props.modelValue.includes(props.data.id));

const toggleSelect = () => {
    const updatedValue = isSelected.value
        ? props.modelValue.filter((id) => id !== props.data.id)
        : [...props.modelValue, props.data.id];

    emit("update:modelValue", updatedValue);
};

const img = ref();
if (props.data.imgs) {
    img.value = props.data.imgs[0].img_path;
} else {
    img.value = props.data.img.img_path;
}
</script>

<template>
    <div
        class="card"
        @click="toggleSelect"
        :style="{
            background: `linear-gradient(180deg, rgba(255, 255, 255, 0.00) 0%, rgba(213, 213, 213, 0.26) 24.3%, rgba(128, 128, 128, 0.75) 62.15%, #2B2B2B 100%), url(${img}) lightgray 50% / cover no-repeat`,
        }"
    >
        <div class="toDelete" :class="isSelected ? 'active' : ''">
            <DangerButton type="button">{{
                isSelected ? "Selectionné" : "Supprimer"
            }}</DangerButton>
        </div>
        <p>{{ data.name }}</p>
    </div>
</template>

<style scoped>
div.card {
    display: flex;
    flex-direction: column;
    align-self: center;
    justify-content: space-between;

    height: 9.5rem;
    width: 9.5rem;
    padding: 1rem;
    margin-bottom: 1rem;

    border-radius: 1.75rem;
    box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);
}

.card .toDelete {
    display: flex;
    flex-direction: row;
    gap: 0.6rem;
    justify-content: center;
}

.card p {
    @apply text-base text-onPrimary font-medium;
    width: 9rem;
}

div.toDelete.active :deep(button) {
    @apply bg-red-400;
}

:deep(button){
    @apply focus:bg-red-700;
}
</style>
