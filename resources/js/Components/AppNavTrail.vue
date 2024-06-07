<script setup>
import { ref, onMounted } from "vue";
import BaseNavLink from "@/Components/BaseNavLink.vue";
import BaseBottomSheet from "@/Components/BaseBottomSheet.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    index: {
        type: Number,
        default: 0,
    },
    lastIndex: {
        type: Number,
        default: 0,
    },
});

const isOpen = ref(false);

const BottomSheet = (e) => {
    isOpen.value = true;
};

const closeBottomSheet = () => {
    isOpen.value = false;
};

const id = window.location.href.split("/").pop().split("#")[0];

const emit = defineEmits(["next", "previous"]);
</script>

<template>
    <div class="nav">
        <BaseNavLink
            v-if="props.index === 0"
            @click.prevent="$inertia.visit(`/home`)"
            icon="cancel"
            class="quit"
            >Quitter</BaseNavLink
        >
        <BaseNavLink v-else @click.prevent="emit('previous')" icon="arrow_back"
            >Point précédent</BaseNavLink
        >
        <BaseNavLink
            v-if="props.index !== props.lastIndex"
            @click.prevent="emit('next')"
            icon="arrow_forward"
            >Point suivant</BaseNavLink
        >
        <BaseNavLink v-else icon="check_circle" @click.prevent="BottomSheet()"
            >Terminer</BaseNavLink
        >
    </div>
    <BaseBottomSheet
        v-if="isOpen"
        :isOpen="isOpen"
        @handle-close="closeBottomSheet()"
        class="base-overlay-card"
    >
        <div class="content">
            <div>
                <h1>Bravo !</h1>
                <p>Vous avez terminé le sentier !</p>
            </div>
            <div class="buttons">
                <a href="/home">Quitter</a>
                <PrimaryButton
                    @click.prevent="$inertia.visit(`/rankTrail/${id}`)"
                    >Noter le sentier</PrimaryButton
                >
            </div>
        </div>
    </BaseBottomSheet>
</template>

<style scoped>
.nav {
    @apply bg-surfaceVariant dark:bg-darkSurfaceVariant;

    display: flex;
    justify-content: space-around;
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 1rem 0rem;

    z-index: 1001;
}

.quit {
    @apply text-error dark:text-darkError;
}

.base-overlay-card {
    z-index: 1004;
}

.content {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 1rem;
    width: 100%;
}

.buttons {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    align-items: center;
}

:deep(.base-overlay-card__content) {
    height: 15rem;
}
</style>
