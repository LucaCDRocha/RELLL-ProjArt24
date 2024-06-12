import { ref } from "vue";

export default function useDarkMode() {
    const isDarkMode = ref(false);

    const toggleDarkMode = () => {
        document.documentElement.classList.toggle('dark');
        isDarkMode.value = !isDarkMode.value;
        localStorage.setItem('darkMode', JSON.stringify(isDarkMode.value));
        window.location.reload();
    };

    const darkMode = JSON.parse(localStorage.getItem('darkMode'));
    if (darkMode) {
        isDarkMode.value = darkMode;
        if (darkMode === true) {
            document.documentElement.classList.add('dark');
        }
    }

    return { isDarkMode, toggleDarkMode };
}
