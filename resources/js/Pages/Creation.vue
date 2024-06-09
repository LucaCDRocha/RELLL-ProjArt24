<script setup>
import { ref } from "vue";
import { Head } from "@inertiajs/vue3";
import TheNav from "@/Components/TheNav.vue";
import TheHeader from "@/Components/TheHeader.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
</script>

<template>
    <Head title="Home" />

    <TheHeader />

    <div class="creation">
        <p>
            Les lieux que vous créet sont mis à disposition de tous le monde
            afin d'agrandir la communauté VaudSentiers.
        </p>
        <section>
            <h2>Créez votre propre lieu</h2>
            <p>
                Vous avez trouvé un lieu extraordinaire qui n'est pas sur la
                carte ? Créez un nouveau lieu !
            </p>
            <div class="creation_action">
                <span class="material-symbols-rounded">add_location_alt</span>
                <SecondaryButton
                    icon="add_circle"
                    @click="$inertia.visit('/interestPoints/create')"
                    >Créer un lieu</SecondaryButton
                >
            </div>
        </section>
        <section>
            <h2>Créez votre propre sentier</h2>
            <p>
                Vous n'avez trouvé aucun sentier à votre goût ? Créez votre
                propre sentier en fonction des lieux déjà existant. C'est simple
                et rapide !
            </p>
            <div class="creation_action">
                <span class="material-symbols-rounded">conversion_path</span>
                <SecondaryButton
                    icon="add_circle"
                    @click="$inertia.visit('/trails/create')"
                    >Créer un parcours</SecondaryButton
                >
            </div>
        </section>
    </div>

    <TheNav />
</template>

<style scoped>
.creation {
    padding: 1rem;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 1rem;
}

.creation_action {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    align-items: center;
    justify-content: center;
    padding: 1rem;
}

.creation_action span {
    @apply text-6xl font-black;
}
</style>
