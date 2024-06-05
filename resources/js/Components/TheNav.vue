<script setup>
import { onMounted } from "vue";
import BaseNavLink from "@/Components/BaseNavLink.vue";

onMounted(() => {
    console.log(window.location.pathname);
    switch (window.location.pathname) {
        case "/login":
        case "/logout":
        case "/settings":
        case "/register":
        case "/my-trails":
            document
                .querySelector('a[href="/profile"]')
                ?.querySelector("span")
                ?.classList.add("active");
            break;
        case "/search":
            document
                .querySelector('a[href="/home"]')
                ?.querySelector("span")
                ?.classList.add("active");
        default:
            document
                .querySelector(`a[href="${window.location.pathname}"]`)
                ?.querySelector("span")
                ?.classList.add("active");
            break;
    }
});
</script>

<template>
    <div>
        <BaseNavLink icon="home" href="/home">Accueil</BaseNavLink>
        <BaseNavLink icon="map" href="/map">Carte</BaseNavLink>
        <BaseNavLink icon="add_location_alt" href="/create-trail"
            >Créer</BaseNavLink
        >
        <BaseNavLink icon="bookmark" href="/bookmark">Mes listes</BaseNavLink>
        <BaseNavLink icon="account_circle" href="/profile">Profil</BaseNavLink>
    </div>
</template>

<style scoped>
div {
    @apply bg-surfaceVariant dark:bg-green-800;

    display: flex;
    justify-content: space-around;
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 1rem 0rem;
}

a {
    @apply text-xs;

    display: flex;
    justify-content: center;
    flex-direction: column;
    align-items: center;

    width: 100%;
}

span {
    display: flex;
    align-self: center;
    justify-content: center;

    width: 60%;
    margin-bottom: 0.1rem;
    padding: 0.2rem;

    border: none;
    border-radius: 1.2rem;
}
</style>
