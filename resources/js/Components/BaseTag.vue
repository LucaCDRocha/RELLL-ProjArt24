<script setup>
// defini un props pour le composant avec tag qui est optionnel
defineProps({
    tag: {
        type: String,
        default: () => "None",
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
</script>

<template>
    <a href="/show-tag" class="tag" :class="getTagColor(tag)">
        {{ tag }}
    </a>
</template>

<style scoped>
.tag {
    display: inline-flex;
    padding: 0.1875rem 1rem;
    justify-content: center;
    align-items: center;
    gap: 0.625rem;

    border-radius: 0.3125rem;
}
</style>
