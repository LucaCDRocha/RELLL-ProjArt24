<script setup>
const props = defineProps({
    option: {
        required: true,
        type: String,
    },
    name: {
        required: true,
        type: String,
    },
})

const form = defineModel({
    type: String,
    required: true,
})

const idName = props.option + props.name
</script>

<template>
    <label :for="idName">
        <input
            type="radio"
            :name="name"
            :value="option"
            :id="idName"
            v-model="form"
        />
        {{ option }} </label
    ><br />
</template>

<style scoped>
input {
    @apply dark:bg-transparent dark:border-darkOnSurface;
    @apply focus:ring-1 focus:ring-primary dark:focus:ring-darkPrimary;
    @apply focus:border-primary dark:focus:border-darkPrimary;
}
input:checked {
    @apply bg-onSurface dark:bg-darkOnSurface;
}
</style>
