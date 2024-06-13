<script setup>
const props = defineProps({
    value: {
        type: String,
    },
})
</script>

<template>
    <label
        class="block font-medium text-sm text-onSurface dark:text-darkOnSurface"
    >
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>

<style scoped>
label {
    @apply block font-medium text-lg;
}
</style>
