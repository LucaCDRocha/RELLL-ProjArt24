// transformer une durée en heure et minutes
export function convertTime(time) {
    const parts = time.split(":");
    const hours = parseInt(parts[0], 10);
    const minutes = parseInt(parts[1], 10);

    if (hours === 0) {
        return `${minutes}min`;
    }
    return `${hours}h${minutes}`;
}

// transformer un timestamp en date jj.mm.aaaa
export function convertDate(timestamp) {
    const date = new Date(timestamp);
    const day = date.getDate().toString().padStart(2, "0");
    const month = (date.getMonth() + 1).toString().padStart(2, "0");
    const year = date.getFullYear();
    return `${day}.${month}.${year}`;
}

// calcule combien de temps c'est passé depuis un timestamp
export function getTimeDifference(timestamp) {
    // le format du timestamp est : 2024-06-10T13:44:56.000000Z
    const date = new Date(timestamp);
    const now = new Date();
    const difference = now - date;
    const seconds = Math.floor(difference / 1000);
    const minutes = Math.floor(seconds / 60);
    const hours = Math.floor(minutes / 60);
    const days = Math.floor(hours / 24);
    const months = Math.floor(days / 30);
    const years = Math.floor(months / 12);

    if (years > 0) {
        return `${years} an${years > 1 ? "s" : ""}`;
    }
    if (months > 0) {
        return `${months} mois`;
    }
    if (days > 0) {
        return `${days} jour${days > 1 ? "s" : ""}`;
    }
    if (hours > 0) {
        return `${hours} heure${hours > 1 ? "s" : ""}`;
    }
    if (minutes > 0) {
        return `${minutes} minute${minutes > 1 ? "s" : ""}`;
    }
    return `${seconds} seconde${seconds > 1 ? "s" : ""}`;
}