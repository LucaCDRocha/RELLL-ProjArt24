<script setup>
import { computed } from "vue";

const props = defineProps({
    rating: {
        type: String,
        required: true,
    },
});
const integerRating = computed(() => Math.floor(props.rating));
const decimalRating = computed(() => props.rating - Math.floor(props.rating));

</script>

<template>
    <div class="flex items-center space-x-1">
        <template v-for="index in 5" :key="index">
            <span v-if="index <= integerRating" class="material-symbols-rounded full-star">star</span>
            <span v-else-if="index === integerRating + 1 && decimalRating >= 0.5" class="material-symbols-rounded">
                star_half
            </span>
            <span v-else class="material-symbols-rounded">star</span>
        </template>
    </div>
</template>

<style scoped>
span {
    font-size: 1rem;
}

.full-star {
    font-variation-settings: "FILL" 1;
}
</style>
