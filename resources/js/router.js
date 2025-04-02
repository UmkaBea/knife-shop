import { createRouter, createWebHistory } from 'vue-router';

import Login from './components/Login.vue';
import Register from './components/Register.vue';
import KnifeCatalog from './components/KnifeCatalog.vue';
import Cart from './components/Cart.vue';
import Inventory from './components/Inventory.vue';

const routes = [
  { path: '/', component: KnifeCatalog },
  { path: '/login', component: Login },
  { path: '/register', component: Register },
  { path: '/cart', component: Cart },
  { path: '/inventory', component: Inventory },
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
