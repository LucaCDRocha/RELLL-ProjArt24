<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    name : {
        required: true,
        type: String
    },
    img :{
        required : true,
        type : String
    },
    title :{
        required: true,
        type : String
    }
});
</script>

<template>
        <div>
            <p>{{ name }}</p>
            <p>{{ title }}</p>
        </div>
</template>

<style scoped>
    div {
        display: flex;
        justify-content: space-between;
        border-bottom-width: 1px;
        border-color: lightgray;
        padding: 12px 5px;
    }
</style>