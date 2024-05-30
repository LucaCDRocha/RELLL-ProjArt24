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
    type: Array,
    required: true
})
</script>

<template>
    <select :name="name" :id="name" v-model="form" multiple>
        <option v-for="option in options" :value="option.id">{{ option.name }}</option>
    </select>
</template>
