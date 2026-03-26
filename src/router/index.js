import { createRouter, createWebHistory } from 'vue-router';

// Импортируем "Главную" (где баннер и бренды) и "Каталог"
import Home from '../components/Home.vue';
import CatalogView from '../components/CatalogView.vue';

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home
  },
  {
    path: '/catalog',
    name: 'catalog',
    component: CatalogView
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;