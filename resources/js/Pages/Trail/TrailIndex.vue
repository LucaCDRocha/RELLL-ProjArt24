<script setup>
import { defineProps } from "vue"

const trails = defineProps({
  trails: {
    type: Array,
      default: () => [],
    },
});

console.log(trails);

</script>

<template>
   
   <h1>hihi</h1>

   <p>{{ trails }}</p>

</template>

<style scoped></style>
