<script setup>
const emit = defineEmits(["handleClose"]);

const notOnMap = window.location.pathname !== "/map"

</script>

<template>
    <div class="container">
        <span class="material-symbols-rounded" @click.self="emit('handleClose')"
            >close</span
        >
        <div v-if="notOnMap">
            <span class="material-symbols-rounded">share</span>
            <span class="material-symbols-rounded">more_vert</span>
        </div>
    </div>
</template>

<style scoped>
.container {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
}

.container div {
    display: flex;
    flex-direction: row;
    gap: 1rem;
}

span.material-symbols-rounded {
    font-size: 1.5rem;
    cursor: pointer;
}
</style>