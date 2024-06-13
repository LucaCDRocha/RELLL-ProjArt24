<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <textarea
        v-model="model"
        ref="input"
    ></textarea>
</template>

<style scoped>
textarea{
    @apply focus:ring-1 focus:ring-primary dark:focus:ring-darkPrimary;
    @apply focus:border-primary dark:focus:border-darkPrimary;
    @apply rounded-md shadow-sm;
    @apply bg-surfaceVariant dark:bg-darkSurfaceVariant;
    @apply px-4 py-5;
}

textarea::placeholder {
    @apply text-outline dark:text-outline;
    @apply text-lg;
}
</style>
