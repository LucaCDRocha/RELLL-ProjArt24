<script setup>
import { onMounted, ref } from "vue";

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute("autofocus")) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input v-model="model" ref="input" />
</template>

<style scoped>
input {
    @apply bg-green-50 dark:bg-green-900;
    @apply text-green-950 dark:text-green-50;
    @apply border-gray-300 dark:border-gray-700;
    @apply focus:ring-1 focus:ring-green-500 dark:focus:ring-green-600;
    @apply focus:border-green-500 dark:focus:border-green-600;
    @apply placeholder-gray-400 dark:placeholder-gray-500;
    @apply rounded-md shadow-sm;
}
</style>
