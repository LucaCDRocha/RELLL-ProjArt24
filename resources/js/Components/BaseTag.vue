<script setup>
import { onMounted } from "vue";

// defini un props pour le composant avec tag qui est optionnel
const { tag, selected } = defineProps({
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
    switch (tag) {
        case "Facile":
            return "bg-green-100 dark:bg-green-900";
        case "Moyen":
            return "bg-yellow-100 dark:bg-yellow-900";
        case "Difficile":
            return "bg-red-100 dark:bg-red-900";
        default:
            return "bg-blue-100 dark:bg-blue-900";
    }
};

const getClasses = (tag) => {
    const classes = {
        "active": selected,
    };
    classes[getTagColor(tag)] = true;
    return classes;
};
</script>

<template>
    <a href="/show-tag" class="tag" :class="getClasses(tag)">
        {{ tag }}
    </a>
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
    @apply bg-transparent border-2 border-teal-400 text-teal-400 dark:text-teal-400 dark:border-teal-400;
}
</style>
