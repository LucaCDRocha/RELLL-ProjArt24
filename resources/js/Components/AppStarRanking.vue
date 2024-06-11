<script>
export default {
    props: {
        rating: {
            type: String,
            required: true,
        },
    },
    computed: {
        integerRating() {
            return Math.floor(this.rating);
        },
        decimalRating() {
            return this.rating - Math.floor(this.rating);
        },
    },
};
</script>

<template>
    <div class="flex items-center">
        <template v-for="index in 5" :key="index">
            <span
                v-if="index <= integerRating"
                class="material-symbols-rounded full-star"
                >star</span
            >
            <span
                v-else-if="index === integerRating + 1 && decimalRating >= 0.5"
                class="material-symbols-rounded"
            >
                star_half
            </span>
            <span v-else class="material-symbols-rounded">star</span>
        </template>
    </div>
</template>

<style scoped>
span {
    font-size: 1.3rem;
}

.full-star {
    font-variation-settings: "FILL" 1;
}
</style>
