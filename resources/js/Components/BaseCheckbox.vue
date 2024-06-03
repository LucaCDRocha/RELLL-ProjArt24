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
    count : {
        type : Number
    }
});

const form = defineModel({
    type: Array,
    required: true
})
</script>

<template>
    <div class="checkboxGroup">
        <input type="checkbox" :name="name" :value="id" :id="id" v-model="form" />
        <label :for="id">{{ name }}</label>
        <p v-if="count">{{ count }}</p>
    </div>
</template>

<style scoped>
.checkboxGroup{
    display: flex;
    align-items: center;
    border-bottom-width: 1px;
    border-color: lightgray;
    padding: 12px 5px;
}

input {
  margin: 0.4rem;
}

p{
    margin-left: 90%;
    font-size: 12px;
}
</style>
