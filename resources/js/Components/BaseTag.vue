<script setup>
import { computed, watch, ref } from 'vue'

// defini un props pour le composant avec tag qui est optionnel
const props = defineProps({
    tag: {
        type: String,
        default: () => 'None',
    },
    selected: {
        type: Boolean,
        default: () => false,
    },
})

// defini une fonction pour retourner la couleur de fond en fonction de la difficulté
const getTagColor = (tag) => {
    switch (tag.toLowerCase()) {
        case 'facile':
            return 'bg-easy'
        case 'moyen':
            return 'bg-medium'
        case 'difficile':
            return 'bg-hard'
        case 'gastronomique':
            return 'bg-gastronomique'
        case 'nature':
            return 'bg-nature'
        case 'art':
            return 'bg-art'
        case 'musée':
            return 'bg-musee'
        case 'famille':
            return 'bg-famille'
        case 'architecture':
            return 'bg-architecture'
        case 'historique':
            return 'bg-historique'
        case 'panorama':
            return 'bg-panorama'
        default:
            return 'bg-secondary text-onSecondary dark:bg-darkSecondary dark:text-dakrOnSecondary'
    }
}

const getClasses = (tag) => {
    const classes = {
        active: !props.selected,
    }
    classes[getTagColor(tag)] = true
    return classes
}

const classes = ref(getClasses(props.tag))

watch(
    () => props.selected,
    () => {
        classes.value = getClasses(props.tag)
    }
)
</script>

<template>
    <div class="tag" :class="classes">
        {{ tag }}
    </div>
</template>

<style scoped>
.tag {
    @apply text-sm dark:text-darkSurface;

    display: inline-flex;
    justify-content: center;
    align-items: center;

    padding: 0.2rem 0.8rem;
    border-radius: 0.35rem;
}

.tag.active {
    border: 0.06rem solid;
    @apply bg-transparent border-outline dark:text-darkOnSurface;
    @apply text-onSurface dark:bg-darkSurface;
}
</style>
