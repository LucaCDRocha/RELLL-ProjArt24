<script setup>
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

<style scoped>
input{
    @apply focus:ring-1 focus:ring-primary dark:focus:ring-green-600;
    @apply focus:border-primary dark:focus:border-green-600;
}
input:checked {
    @apply bg-onSurface;
}
</style>
