<script setup>

const props = defineProps({
    name : {
        required: true,
        type: String
    },
    id :{
        required : true,
        type : Number
    },
    link :{
        required: true,
        type : String
    }
});
</script>

<template>
    <a :href="`${link}/${id}`">
        <div>
            <p>{{ name }}</p>
            <span class="material-symbols-rounded"> arrow_right </span>
        </div>
    </a>
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