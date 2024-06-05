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
    @apply focus:ring-1 focus:ring-primary dark:focus:ring-green-600;
    @apply focus:border-primary dark:focus:border-green-600;
    @apply rounded-md shadow-sm;
    @apply bg-surfaceVariant dark:bg-green-900;
    @apply px-4 py-5;
}

::placeholder {
    @apply text-onSurfaceVariant dark:text-green-100;
    @apply text-lg;
}
</style>
