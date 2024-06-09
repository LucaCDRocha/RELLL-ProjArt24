<script setup>
const props = defineProps({
    id: {
        required: true,
        type: Number
    },
    name: {
        required: true,
        type: String
    },
    count: {
        type: Number
    }
});

const form = defineModel({
    type: Array,
    required: true
})
</script>

<template>
    <div class="checkboxGroup">
        <div>
            <input type="checkbox" :name="name" :value="id" :id="id" v-model="form" />
            <label :for="id">{{ name }}</label>
        </div>
        <p v-if="count">{{ count }}</p>
    </div>
</template>

<style scoped>
.checkboxGroup {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom-width: 1px;
    @apply border-b border-customGray dark:border-darkCustomGray;
    padding: 12px 5px;
    width: 100%;
}

input:focus {
    background-color: #ccc;
}

input {
    margin: 0.4rem;
}

input:target {
    @apply bg-error;
}

input:checked {
    @apply bg-onSurface dark:bg-darkOnSurface;
}
</style>
