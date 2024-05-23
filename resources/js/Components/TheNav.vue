<script>
window.addEventListener("load", () => {
    switch (window.location.pathname) {
        case "/login":
        case "/logout":
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

        <a href="/create"
            ><span class="material-symbols-rounded"> add_location_alt </span
            >Créer</a
        >

        <a href="/profile"
            ><span class="material-symbols-rounded"> account_circle </span
            >Profil</a
        >
    </div>
</template>

<style scoped>
div {
    @apply bg-green-100 dark:bg-green-900;
    display: flex;
    justify-content: space-around;
    padding: 10px 0;
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
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
    margin-bottom: 1px;
    padding: 3px;
    border: none;
    border-radius: 20px;
    display: flex;
    align-self: center;
    justify-content: center;
}

span.active {
    @apply bg-green-600 dark:bg-green-500 text-white;
}
</style>
