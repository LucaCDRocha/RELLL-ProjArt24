<script setup>
import BaseCard from "@/Components/BaseCard.vue";

defineProps({
    datas: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <p><slot /></p>
    <div class="cardList">
        <BaseCard v-for="data in datas" :key="data.name" :tag="data.tag">{{
            data.name
        }}</BaseCard>
    </div>
</template>

<style scoped>
div.cardList {
    display: flex;
    flex-direction: row;
    overflow: scroll;
    scrollbar-width: none;
}

p {
    @apply text-2xl;
    
    margin-left: 1rem;
}

div.cardList:first-child {
    margin-left: 1rem;
}
</style>
