<script setup>
import { computed } from "vue";
import DangerButton from "@/Components/DangerButton.vue";

const props = defineProps({
    data: {
        type: Object,
        default: () => {},
    },
});

const model = defineModel({
    type: Array,
    default: () => []
});

const emit = defineEmits(['update:modelValue']);

const isSelected = computed(() => props.modelValue.includes(props.data.id));

const toggleSelect = () => {
  const updatedValue = isSelected.value
    ? props.modelValue.filter(id => id !== props.data.id)
    : [...props.modelValue, props.data.id];

  emit('update:modelValue', updatedValue);
};

</script>

<template>
    <div class="card" @click="toggleSelect">
        <div>
            <DangerButton type="button">Supprimer</DangerButton>
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

    height: 10rem;
    padding: 1rem;
    margin-bottom: 1rem;

    border-radius: 1.75rem;
    box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);

    background-color: beige;
    background: linear-gradient(180deg, rgba(0, 19, 2, 0) 0%, #001a04 94.1%),
        url("https://upload.wikimedia.org/wikipedia/commons/4/4e/Pleiades_large.jpg")
            rgb(247, 255, 247) 50% / cover no-repeat;
}

.card p {
    @apply text-xl text-green-50;

    width: 10rem;
}

.card button {
    @apply bg-red-500 text-white;
    width: fit-content;
}
</style>
