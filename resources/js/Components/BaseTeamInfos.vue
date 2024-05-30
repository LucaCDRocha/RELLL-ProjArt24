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
        <div class="teamCard">
            <img :src="img" alt="">
            <p class="name">{{ name }}</p>
            <p>{{ title }}</p>
        </div>
</template>

<style scoped>
    .teamCard {
        padding: 12px 5px;
        width: 30%;
        flex-direction: column;
    }

    .name{
        font-weight: bold;
    }

    img {
        height: 100px;
        clip-path:ellipse(33% 50%);
    }
</style>