import { createApp } from 'vue'
import './style.css'
import App from './App.vue'

window.API = 'http://localhost:8000/api/'
// window.API = '/api/'

createApp(App).mount('#app');
