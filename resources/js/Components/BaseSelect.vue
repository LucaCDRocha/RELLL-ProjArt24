<script setup>
const props = defineProps({
    options: {
        required: true,
        type: Array
    },
    name: {
        required: true,
        type: String
    },
});

const form = defineModel({
    type: Number,
    required: true
})
</script>

<template>
    <select :name="name" :id="name" v-model="form">
        <option disabled selected :value="0">-- Choisissez ci-dessous --</option>
        <option v-for="option in options" :key="option.id" :value="option.id">{{ option.name }}</option>
    </select>
</template>

<style scoped>
select {
    appearance: none; /* Removes default styling */
    -webkit-appearance: none; /* Safari */

    @apply bg-transparent dark:bg-transparent;
    @apply border-secondary dark:border-gray-700;
    @apply focus:ring-1 focus:ring-primary dark:focus:ring-green-600;
    @apply focus:border-primary dark:focus:border-green-600;
    @apply rounded-md shadow-sm;
}

select:focus {
    @apply outline-none;
}

option:hover {
    @apply bg-customGray; /* Gray background for hovered option */
}

option{
    @apply bg-surfaceVariant; 
    @apply border-primary;
}
</style>