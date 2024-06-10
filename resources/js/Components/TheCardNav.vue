<script setup>
import BaseDivider from "@/Components/BaseDivider.vue";
import DropDown from "@/Components/Dropdown.vue";
import { usePage } from "@inertiajs/vue3";

const notOnMap = window.location.pathname !== "/map";

const props = defineProps({
    isFull: {
        type: Boolean,
        default: false,
    },
    trailId: {
        type: Number,
        default: null,
    },
    interestPointId: {
        type: Number,
        default: null,
    },
});

const isUserLoggedIn = usePage().props.auth.user;
const isUserAdmin = isUserLoggedIn && user.is_admin === 1;

const share = () => {
    let url = window.location.origin;
    let title = document.title;

    if (props.trailId) {
        url += `/trails/${props.trailId}`;
        title = `Découvrez ce sentier !`;
    } else if (props.interestPointId) {
        url += `/interestPoints/${props.interestPointId}`;
        title = `Découvrez ce lieu !`;
    }

    // make a share of the current page
    if (navigator.share) {
        navigator
            .share({
                title,
                url,
            })
            .then(() => console.log("Successful share", url, title, text))
            .catch((error) => console.log("Error sharing", error));
    }
};

const emit = defineEmits(["handle-close"]);
</script>

<template>
    <div class="container">
        <div class="full" v-if="isFull">
            <span
                class="material-symbols-rounded"
                @click.self="emit('handle-close')"
                >keyboard_arrow_down</span
            >
            <div v-if="notOnMap">
                <span class="material-symbols-rounded" @click="share()"
                    >share</span
                >
                <DropDown>
                    <template #trigger>
                        <span class="material-symbols-rounded">more_vert</span>
                    </template>
                    <template #content>
                        <p v-if="isUserAdmin">
                            <span class="material-symbols-rounded">edit</span>
                            Modifier
                        </p>
                        <p v-if="isUserLoggedIn">
                            <span class="material-symbols-rounded"
                                >bookmark</span
                            >
                            Enregistrer
                        </p>
                        <p>
                            <span
                                class="material-symbols-rounded"
                                @click="share()"
                                >share</span
                            >
                            Partager
                        </p>
                        <p>
                            <span class="material-symbols-rounded">print</span>
                            Imprimer
                        </p>
                        <p v-if="!isUserAdmin">
                            <span class="material-symbols-rounded">flag</span>
                            Signaler
                        </p>
                        <p v-if="isUserAdmin">
                            <span class="material-symbols-rounded">delete</span>
                            Supprimer
                        </p>
                    </template>
                </DropDown>
            </div>
        </div>
        <div class="small" v-else>
            <span class="material-symbols-rounded">drag_handle</span>
        </div>
    </div>
</template>

<style scoped>
.full {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    padding-right: 1rem;
}

.full div {
    display: flex;
    flex-direction: row;
    gap: 1rem;
}

.small {
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    gap: 1rem;
}

span.material-symbols-rounded {
    font-size: 1.5rem;
    cursor: pointer;
}

:deep(.trigger) {
    z-index: 1004;
}

:deep(.content) {
    @apply bg-surface dark:bg-darkSurface;

    z-index: 1003;
    top: 1rem;
    right: -1rem;

    box-shadow: 0 0 0.4rem rgba(0, 0, 0, 0.2);
}

:deep(.content p) {
    display: flex;
    flex-direction: row;
    gap: 0.5rem;
    align-items: center;
    padding: 0.8rem 0.5rem;
}
</style>
