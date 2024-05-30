<script setup>
import { defineProps } from 'vue';

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
        <option v-for="option in options" :value="option.id">{{ option.name }}</option>
    </select>
</template>
