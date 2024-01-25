import './bootstrap';
import App from '../src/App.vue'
import { createApp } from "vue";
import router from './router';
import axios from 'axios';
import store from './store';
import style from 'bootstrap/dist/css/bootstrap.css';
import js from 'bootstrap/dist/js/bootstrap.js';


axios.defaults.withCredentials = true;
const app = createApp(App);


app.use(router);
app.use(store);
app.use(style);
app.use(js);


app.mount("#app");