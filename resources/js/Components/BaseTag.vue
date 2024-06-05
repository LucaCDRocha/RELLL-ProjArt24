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
            return "bg-easy dark:bg-green-900";
        case "moyen":
            return "bg-medium dark:bg-blue-900";
        case "difficile":
            return "bg-hard dark:bg-red-900";
        case "gastronomique":
            return "bg-gastronomique dark:bg-yellow-900";
        case "nature":
            return "bg-nature dark:bg-green-900";
        case "art":
            return "bg-art dark:bg-blue-900";
        case "musée":
            return "bg-musee dark:bg-red-900";
        case "famille":
            return "bg-famille dark:bg-yellow-900";
        case "architecture":
            return "bg-architecture dark:bg-green-900";
        case "historique":
            return "bg-historique dark:bg-blue-900";
        case "panorama":
            return "bg-panorama dark:bg-red-900";
        default:
            return "bg-secondary text-onSecondary dark:bg-blue-100 dark:text-green-950";
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
    <div class="tag" :class="classes">
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
    border: 0.06rem solid;
    @apply bg-transparent border-outline dark:text-blue-900 dark:border-blue-900;
}
</style>