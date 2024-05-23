import { createApp } from 'vue';
import App from './AppHome.vue';
import "leaflet/dist/leaflet.css";

const myApp = createApp(App)
myApp.mount('#app');