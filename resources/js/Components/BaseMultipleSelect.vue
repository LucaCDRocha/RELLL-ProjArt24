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
    type: Array,
    required: true
})
</script>

<template>
    <select :name="name" :id="name" v-model="form" multiple>
        <option v-for="option in options" :key="option.id" :value="option.id">{{ option.name }}</option>
    </select>
</template>
