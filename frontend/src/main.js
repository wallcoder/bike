import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import 'boxicons'
import App from './App.vue'
import router from './router'
import axios from 'axios';
import { createNotivue } from 'notivue'
const notivue = createNotivue(/* Options */)
const app = createApp(App)

app.use(notivue)
axios.defaults.baseURL = 'http://localhost:8000/api'
axios.defaults.withCredentials = true
app.use(createPinia())
app.use(router)

app.mount('#app')
