<script setup>
import BaseDivider from "@/Components/BaseDivider.vue";
import DropDown from "@/Components/Dropdown.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import AppSaveButton from "@/Components/AppSaveButton.vue";

const notOnMap = window.location.pathname !== "/map";
const notOnCreate = window.location.pathname !== "/trails/create";

const props = defineProps({
    isFull: {
        type: Boolean,
        default: false,
    },
    trailId: {
        type: Number,
        default: null,
    },
    trailTitle: {
        type: String,
        default: null,
    },
    interestPointId: {
        type: Number,
        default: null,
    },
    isSave: {
        type: Boolean,
        default: false,
    },
});

const user = usePage().props.auth.user;
const isUserLoggedIn = user && Object.keys(user).length > 0;
const isUserAdmin = user && user.is_admin === 1;

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
    } else {
        // fallback
        const text = `Découvrez ce lieu sur ${url}`;
        const el = document.createElement("textarea");
        el.value = text;
        document.body.appendChild(el);
        el.select();
        document.execCommand("copy");
        document.body.removeChild(el);
        alert("Le lien a été copié dans votre presse-papier !");
    }
};

const print = () => {
    window.print();
};

// const report = () => {
//     if (props.trailId) {
//         window.location.href = `/trails/${props.trailId}/report`;
//     } else if (props.interestPointId) {
//         window.location.href = `/interestPoints/${props.interestPointId}/report`;
//     }
// };

const showModal = ref(false);
const openModal = () => {
    showModal.value = !showModal.value;
};

const deleteItem = () => {
    const form = useForm({
        id: props.trailId || props.interestPointId,
    });
    if (props.trailId) {
        form.delete(route("trails.destroy", { id: props.trailId }), {});
    } else if (props.interestPointId) {
        form.delete(
            route("interestPoints.destroy", { id: props.interestPointId }),
            {}
        );
    }
    openModal();
    setTimeout(() => {
        window.location.href = "/home";
    }, 1000);
};

const emit = defineEmits(["handle-close", "emit-lists"]);
</script>

<template>
    <div class="container">
        <div class="full" v-if="isFull">
            <span
                class="material-symbols-rounded"
                @click.self="emit('handle-close')"
                >keyboard_arrow_down</span
            >
            <div v-if="notOnCreate">
                <span class="material-symbols-rounded" @click="share()"
                    >share</span
                >
                <DropDown v-if="notOnMap">
                    <template #trigger>
                        <span class="material-symbols-rounded">more_vert</span>
                    </template>
                    <template #content>
                        <p v-if="isUserAdmin">
                            <span class="material-symbols-rounded">edit</span>
                            Modifier
                        </p>
                        <AppSaveButton
                            v-if="isUserLoggedIn && props.trailId"
                            :title="props.trailTitle"
                            :id="props.trailId"
                            :in-dropdown="true"
                            :is-save="props.isSave"
                            @emit-lists="emit('emit-lists', $event)"
                        />
                        <p @click="share()">
                            <span class="material-symbols-rounded">share</span>
                            Partager
                        </p>
                        <p v-if="props.trailId" @click="print()">
                            <span class="material-symbols-rounded">print</span>
                            Imprimer
                        </p>
                        <!-- <p v-if="!isUserAdmin" @click="report()">
                            <span class="material-symbols-rounded">flag</span>
                            Signaler
                        </p> -->
                        <p v-if="isUserAdmin" @click="openModal()">
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
    <Modal :show="showModal" @close="openModal()">
        <div class="confirmation-modal">
            <h2>
                Voulez-vous vraiment supprimer ce
                {{ props.trailId ? "sentier" : "point" }} ?
            </h2>
            <p v-if="props.interestPointId">Cette action supprimera également les sentiers qui n'auront plus de lieux.</p>
            <div class="actions">
                <a @click.prevent="deleteItem()"
                class="underline text-sm text-error dark:text-darkError hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-offset-gray-800">
                    Supprimer le {{ props.trailId ? "sentier" : "point" }}
                </a>
                <PrimaryButton @click="openModal()">
                    Non, annuler
                </PrimaryButton>
            </div>
        </div>
    </Modal>
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
    @apply bg-surface dark:bg-darkSurfaceVariant;

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

.confirmation-modal {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-end;
    gap: 2rem;
}

.actions {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 1rem;
}

p {
    cursor: pointer;
}
</style>
