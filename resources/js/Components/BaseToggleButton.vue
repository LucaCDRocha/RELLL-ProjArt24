<script setup>
import useDarkMode from "@/Composables/darkMode.js";

const { isDarkMode, toggleDarkMode } = useDarkMode();

const props = defineProps({
    label: {
        type: String,
    },
});
</script>

<template>
    <div class="toggle-button">
        <p>{{ label }}</p>
        <div
            class="switch-container"
            :class="{ checked: isDarkMode }"
            @click="toggleDarkMode()"
        >
            <input type="checkbox" v-model="isDarkMode" />
            <span class="slider"></span>
        </div>
    </div>
</template>

<style scoped>
.toggle-button {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
}

.switch-container {
    display: inline-block;
    vertical-align: middle;
    width: 60px;
    height: 34px;
    border-radius: 17px;
    position: relative;
    cursor: pointer;
}

.switch-container input[type="checkbox"] {
    opacity: 0;
    width: 0;
    height: 0;
}

/* Style pour l'icone du switch */
.slider {
    @apply bg-primary  ;

    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    transition: 0.4s;
    border-radius: 17px;
}

/* Style pour l'icone lorsqu'elle est cochez */
.slider:before {
    @apply bg-onPrimary;

    content: "";
    position: absolute;
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    transition: 0.4s;
    border-radius: 50%;
}

/* Déplacer l'icone vers la droite lorsqu'elle est coche */
.switch-container input:checked ~ .slider:before {
    transform: translateX(28px);
}
</style>
