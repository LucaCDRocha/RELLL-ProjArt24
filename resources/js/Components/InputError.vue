<script setup>
const props = defineProps({
    message: {
        type: String,
    },
})
</script>

<template>
    <div v-show="message">
        <p class="text-sm text-error dark:text-darkError">
            {{ message }}
        </p>
    </div>
</template>
