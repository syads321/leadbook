import Home from './pages/Home.vue';
import Register from './pages/Register.vue';
import FindCompany from './pages/FindCompany.vue';

export const routes = [
    {
        name: 'home',
        path: '/',
        component: Home
    },
    {
        name: 'home-redirect',
        path: '/home',
        component: Home
    },
    {
        name: 'register',
        path: '/register',
        component: Register
    },
    {
        name: 'findcompany',
        path: '/findcompany',
        component: FindCompany
    }
];