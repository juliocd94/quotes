import { createRouter, createWebHistory } from 'vue-router';
import FavoriteQuotes from '../src/FavoriteQuotes.vue';
import Quotes from '../src/Quotes.vue';
import Login from '../src/auth/Login.vue';
import Profile from '../src/auth/Profile.vue';
import Users from '../src/Users.vue';

const routes = [
    {
        path: '/',
        component: Quotes
    },
    { 
        path: '/login', 
        component: Login 
    },
    { 
        path: '/users', 
        component: Users 
    },
    { 
        path: '/profile', 
        component: Profile 
    },
    {
        path: '/favorite-quotes',
        component: FavoriteQuotes
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
