<script setup>
import BaseCard from "@/Components/BaseCard.vue";
import { onMounted } from "vue";

const props = defineProps({
    datas: {
        type: Array,
        default: () => [],
    },
});
onMounted(() => {
    if (props.datas.length != 0) {
        document.querySelector("#onNoData").classList = "hidden";
    }
})

const emit = defineEmits(["handle-point"]);
</script>

<template>
    <div>
        <h2>
            <slot />
        </h2>
        <div class="cardList">
            <BaseCard v-for="data in datas" :key="data.id" :data="data" @handle-point="emit('handle-point', $event)" />
            <p id="onNoData">Aucun sentier n'utilise ce point</p>
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

div h2 {
    padding-right: 1rem;
}

div.cardList {
    display: flex;
    flex-direction: row;
    overflow: scroll;
    height: 100%;
    padding-right: 1rem;
}

.hidden {
    opacity: 0,
}
</style>
