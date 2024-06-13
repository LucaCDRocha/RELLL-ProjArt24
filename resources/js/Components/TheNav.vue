<script setup>
import { usePage } from '@inertiajs/vue3'
import { onMounted } from 'vue'
import BaseNavLink from '@/Components/BaseNavLink.vue'

const addActiveClass = (path) => {
    document
        .querySelector(`nav a[href="/${path}"]`)
        ?.querySelector('span')
        ?.classList.add('active')
}

onMounted(() => {
    const url = window.location.pathname.split('/')
    if (url.some((el) => el === 'home') || url.every((el) => el === '')) {
        addActiveClass('')
    }
    if (url.some((el) => el === 'map')) {
        addActiveClass('map')
    }
    if (url.some((el) => el === 'create') || url.some((el) => el === 'edit')) {
        addActiveClass('create')
    }
    if (url.some((el) => el === 'bookmark')) {
        addActiveClass('bookmark')
    }
    if (
        url.some((el) => el === 'profile') ||
        url.some((el) => el === 'about') ||
        url.some((el) => el === 'register') ||
        url.some((el) => el === 'login')
    ) {
        addActiveClass('profile')
    }
    // switch (window.location.pathname) {
    //     case "/login":
    //     case "/logout":
    //     case "/settings":
    //     case "/register":
    //     case "/my-trails":
    //         document
    //             .querySelector('nav a[href="/profile"]')
    //             ?.querySelector("span")
    //             ?.classList.add("active");
    //         break;
    //     case "/search":
    //         document
    //             .querySelector('nav a[href="/"]')
    //             ?.querySelector("span")
    //             ?.classList.add("active");
    //         break;
    //     case "/trails/create":
    //     case "/interestPoints/create":
    //         document
    //             .querySelector('nav a[href="/create"]')
    //             ?.querySelector("span")
    //             ?.classList.add("active");
    //         break;
    //     default:
    //         document
    //             .querySelector(`nav a[href="${window.location.pathname}"]`)
    //             ?.querySelector("span")
    //             ?.classList.add("active");
    //         break;
    // }
})

const user = usePage().props.auth.user
const isUserLoggedIn = user && Object.keys(user).length > 0
const isUserAdmin = user && user.is_admin === 1

const isAdmin = isUserLoggedIn && isUserAdmin
</script>

<template>
    <nav>
        <BaseNavLink icon="home" href="/">Accueil</BaseNavLink>
        <BaseNavLink icon="map" href="/map">Carte</BaseNavLink>
        <BaseNavLink v-if="isAdmin" icon="add_location_alt" href="/create"
            >Créer</BaseNavLink
        >
        <BaseNavLink icon="bookmark" href="/bookmark">Mes listes</BaseNavLink>
        <BaseNavLink icon="account_circle" href="/profile">Profil</BaseNavLink>
    </nav>
</template>

<style scoped>
nav {
    @apply bg-surfaceVariant dark:bg-darkSurfaceVariant;

    display: flex;
    justify-content: space-around;
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 1rem 0rem;

    z-index: 1000;
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
