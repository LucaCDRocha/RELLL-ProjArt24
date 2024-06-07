<script setup>
import { convertTime } from '@/Helpers/timeHelper';
// defini un props pour le composant avec tag qui est optionnel
const { tag, time } = defineProps({
    tag: {
        type: String,
        default: () => "None",
    },
    time: {
        type: String,
        default: () => "None",
    },
});

// defini une fonction pour retourner la couleur de fond en fonction de la difficulté
const getTagColor = (tag) => {
    switch (tag.toLowerCase()) {
        case "facile":
            return "bg-easy ";
        case "moyen":
            return "bg-medium";
        case "difficile":
            return "bg-hard";
    }
};

const getClasses = (tag) => {
    return {[getTagColor(tag)] : true};
};
</script>

<template>
    <div class="doubleTags">
        <div class="label tag" :class="getClasses(tag)">
            {{ tag }}
        </div>
        <div class="time label">
            {{ convertTime(time) }}
        </div>
    </div>
</template>

<style scoped>
.doubleTags {
    display: flex;
    flex-direction: column;
    @apply text-sm;
}
.label{
    display: inline-flex;
    justify-content: center;
    align-items: center;
    padding: 0.2rem 0.8rem;
    @apply dark:text-darkSurface;
}
.tag{
    border-top-left-radius: 0.35rem;
    border-top-right-radius: 0.35rem;
}
.time{
    @apply bg-onPrimary dark:bg-white;
    @apply text-xs;
    border-bottom-left-radius: 0.35rem;
    border-bottom-right-radius: 0.35rem;
}
</style>