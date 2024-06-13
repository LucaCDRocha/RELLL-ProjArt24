<script setup>
import RadioButton from './BaseRadioButton.vue'

const props = defineProps({
    options: {
        type: Array,
        required: true,
    },
    name: {
        type: String,
        required: true,
    },
})

const form = defineModel({
    type: String,
    required: true,
})
</script>

<template>
    <div class="radio-button-group">
        <RadioButton
            v-for="option in options"
            :key="option.id"
            :option="option"
            :name="name"
            v-model="form"
        />
    </div>
</template>
