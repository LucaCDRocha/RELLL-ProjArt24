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
    const day = date.getDate().toString().padStart(2, '0');
    const month = (date.getMonth() + 1).toString().padStart(2, '0');
    const year = date.getFullYear();
    return `${day}.${month}.${year}`;
}