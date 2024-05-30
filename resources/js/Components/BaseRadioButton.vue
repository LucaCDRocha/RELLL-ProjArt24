<script setup>

import { defineProps } from 'vue';

const props = defineProps({
    option: {
        required: true,
        type: String
    },
    name: {
        required: true,
        type: String
    },
});

const form = defineModel({
    type: String,
    required: true
})

const idName = props.option+props.name;

</script>

<template>
    <label :for="idName">
        <input type="radio" :name="name" :value="option" :id="idName" v-model="form" />
        {{ option }}
    </label><br>
</template>
