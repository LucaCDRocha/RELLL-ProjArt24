// transformer une durée en heure et minutes
export function convertTime(time) {
    const parts = time.split(':');
    const hours = parseInt(parts[0], 10);
    const minutes = parseInt(parts[1], 10);

    if (hours === 0) {
        return `${minutes}min`;
    }
    return `${hours}h${minutes}`;
};