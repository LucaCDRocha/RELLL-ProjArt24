<script setup>
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
            <p class="title">{{ title }}</p>
        </div>
</template>

<style scoped>
    .teamCard {
        display: flex;
        padding: 12px 5px;
        width: 40%;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .name{
    @apply text-base font-medium text-center;
    }

    .title{
        @apply text-xs font-medium text-center;
    }

    img {
        height: 100px;
        object-fit: cover;
        clip-path:ellipse(33% 40%);
    }
</style>