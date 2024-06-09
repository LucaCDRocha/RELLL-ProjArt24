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
    },
    numberElem :{
        type : Number
    }
});
</script>

<template>
    <a :href="`${link}`">
        <div class="element">
            <div>
                <p>{{ name }}</p>
                <p v-if="numberElem">({{ numberElem }})</p>
            </div>
            <span class="material-symbols-rounded"> arrow_right </span>
        </div>
    </a>
</template>

<style scoped>
    div.element {
        justify-content: space-between;
        border-bottom-width: 1px;
        @apply border-b border-customGray dark:border-darkCustomGray;
        padding: 12px 5px;
    }
    div{
        display: flex;
    }
</style>