<script setup>
import { computed, watch, ref } from "vue";

// defini un props pour le composant avec tag qui est optionnel
const props = defineProps({
    tag: {
        type: String,
        default: () => "None",
    },
    selected: {
        type: Boolean,
        default: () => false,
    },
});

// defini une fonction pour retourner la couleur de fond en fonction de la difficulté
const getTagColor = (tag) => {
    switch (tag.toLowerCase()) {
        case "facile":
            return "bg-green-100 dark:bg-green-900";
        case "moyen":
            return "bg-blue-100 dark:bg-blue-900";
        case "difficile":
            return "bg-red-100 dark:bg-red-900";
        default:
            return "bg-blue-900 text-green-50 dark:bg-blue-100 dark:text-green-950";
    }
};

const getClasses = (tag) => {
    const classes = {
        active: !props.selected,
    };
    classes[getTagColor(tag)] = true;
    return classes;
};

const classes = ref(getClasses(props.tag));

watch(
    () => props.selected,
    () => {
        classes.value = getClasses(props.tag);
    }
);
</script>

<template>
    <div href="/show-tag" class="tag" :class="classes">
        {{ tag }}
    </div>
</template>

<style scoped>
.tag {
    @apply text-sm;

    display: inline-flex;
    justify-content: center;
    align-items: center;

    padding: 0.2rem 0.8rem;
    border-radius: 0.35rem;
}

.tag.active {
    @apply bg-transparent border-2 border-blue-900 text-blue-900 dark:text-blue-900 dark:border-blue-900;
}
</style>
