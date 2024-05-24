<script setup>
import { ref, watch, onMounted } from "vue";

onMounted(() => {
    console.log("mounted");
    switch (window.location.pathname) {
        case "/login":
        case "/logout":
            document
                .querySelector('a[href="/autres"]')
                ?.querySelector("span")
                ?.classList.add("active");
            document
                .querySelector('a[href="/profile"]')
                ?.querySelector("span")
                ?.classList.add("active");
            break;

        default:
            document
                .querySelector('a[href="' + window.location.pathname + '"]')
                ?.querySelector("span")
                ?.classList.add("active");
            break;
    }
});
const isOpen = ref(false);

watch(isOpen, (value) => {
    console.log(value);
});

window.addEventListener("load", () => {});
</script>

<template>
    <div>
        <a href="/home"
            ><span class="material-symbols-rounded"> home </span>Accueil</a
        >

        <a href="/search"
            ><span class="material-symbols-rounded"> search </span>Recherche</a
        >
        <a href="/map"
            ><span class="material-symbols-rounded"> map </span>Carte</a
        >

        <a href="/create-trail"
            ><span class="material-symbols-rounded"> add_location_alt </span
            >Créer</a
        >

        <a href="/autres" @click.prevent="isOpen = !isOpen"
            ><span class="material-symbols-rounded"> more_vert </span>Autres</a
        >
    </div>
    <div class="modal" v-show="isOpen" @click="isOpen = !isOpen">
        <div class="fixed">
            <a href="/bookmark"
                ><span class="material-symbols-rounded"> bookmark </span
                >Mes listes</a
            >
            <a href="/favorites"
                ><span class="material-symbols-rounded"> star </span
                >Mes favoris</a
            >
            <a href="/my-trails"
                ><span class="material-symbols-rounded"> conversion_path </span
                >Mes parcours</a
            >
            <a href="/profile"
                ><span class="material-symbols-rounded"> account_circle </span
                >Profil</a
            >
            <a href="/settings"
                ><span class="material-symbols-rounded"> settings </span
                >Paramètres</a
            >
        </div>
    </div>
</template>

<style scoped>
div {
    @apply bg-green-100 dark:bg-green-800;
    display: flex;
    justify-content: space-around;
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 1rem 0rem;
}

.modal {
    @apply bg-transparent dark:bg-transparent;
    width: 100vw;
    height: 100vh;
}

.fixed {
    border-top-left-radius: 2rem;
    border-top-right-radius: 2rem;
    display: flex;
    flex-direction: row;
    flex-flow: row wrap;
    justify-content: center;
    align-items: flex-end;
    position: fixed;
    right: 0rem;
}

.fixed a {
    height: 4.5rem;
    width: 6rem;
    margin: 0.5rem 1rem;
}

a {
    display: flex;
    justify-content: center;
    flex-direction: column;
    align-items: center;
    width: 100%;
    font-size: 0.7rem;
}

span {
    width: 60%;
    margin-bottom: 0.1rem;
    padding: 0.2rem;
    border: none;
    border-radius: 1.2rem;
    display: flex;
    align-self: center;
    justify-content: center;
}

span.active {
    @apply bg-green-300 dark:bg-green-600;
}
</style>
