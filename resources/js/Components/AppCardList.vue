<script setup>
import { ref, watch, onMounted } from "vue";
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
    margin-left: 1rem;
    font-size: 1.5rem;
}

div:first-child {
    margin-left: 1rem;
}
</style>
