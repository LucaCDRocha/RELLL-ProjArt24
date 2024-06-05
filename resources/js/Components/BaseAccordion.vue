<script setup>
import { ref, onMounted } from 'vue';
import BaseTag from "@/Components/BaseTag.vue";

const accordionOpen = ref(false)

const props = defineProps({
    title: {
        type: String,
        required: true
    },
    tag: {
        type: String,
        required: false
    },
    id: {
        type: Number,
        required: true
    },
    active: {
        type: Boolean,
        default: true
    },
    multiple: {
        type: Boolean,
        default: false
    }
})

onMounted(() => {
    accordionOpen.value = props.active
})
</script>

<template>
    <div>
        <h2>
            <button :id="id" class="flex justify-between w-full" @click.prevent="accordionOpen = !accordionOpen"
                :aria-expanded="accordionOpen" :aria-controls="id">
                <div :class="multiple ? 'accordion' : 'accordion-single'">
                    {{ title }}
                    <div v-if="tag" class="tag">
                        <BaseTag :tag="tag" :selected="true" />
                    </div>
                </div>
                <span v-if="accordionOpen" class="material-symbols-rounded">
                    keyboard_arrow_up
                </span>
                <span v-else class="material-symbols-rounded">
                    keyboard_arrow_down
                </span>
            </button>
        </h2>
        <div :id="id" role="region" :aria-labelledby="id"
            class="grid overflow-hidden transition-all duration-300 ease-in-out"
            :class="accordionOpen ? 'grid-rows-[1fr] opacity-100' : 'grid-rows-[0fr] opacity-0'">
            <div class="overflow-hidden">
                <slot />
            </div>
        </div>
    </div>
</template>

<style scoped>
.accordion {
    display: flex;
    flex-direction: row;
    gap: 1rem;
    align-items: center;
}
</style>