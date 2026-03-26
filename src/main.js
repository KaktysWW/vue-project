import './assets/main.css'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router' // импорт созданного роутера

const app = createApp(App)
app.use(router) // подключаем
app.mount('#app')