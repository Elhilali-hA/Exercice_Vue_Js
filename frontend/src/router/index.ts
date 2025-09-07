import { createRouter, createWebHistory } from 'vue-router';
import Login from '@/pages/Login.vue';
import Register from '@/pages/Register.vue';
import Tasks from '@/pages/Tasks.vue';

const routes = [
  { path: '/login', name: 'Login', component: Login },
  { path: '/register', name: 'Register', component: Register },
  { path: '/', name: 'Tasks', component: Tasks }, // maybe your dashboard
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
