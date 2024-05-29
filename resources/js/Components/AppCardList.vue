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
    <div>
        <h2><slot /></h2>
        <div class="cardList">
            <BaseCard v-for="data in datas" :key="data.id" :data="data" />
        </div>
    </div>
</template>

<style scoped>
div {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    width: 100%;
}

div.cardList {
    display: flex;
    flex-direction: row;
    overflow: scroll;
    height: 100%;
}
</style>
