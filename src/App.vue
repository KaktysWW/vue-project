<template>
  <div class="app-container">
    <Header @open-auth="showAuth = true" />

    <router-view @add-to-cart="handleAddToCart" />

    <AuthModal v-if="showAuth" @auth-success="showAuth = false" />

    <Footer />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import Header from './components/Header.vue';
import Footer from './components/Footer.vue';
import AuthModal from './components/AuthModal.vue';

const showAuth = ref(false);

// Как только сайт загрузился — показываем окно
onMounted(() => {
  // Проверяем, не залогинен ли уже пользователь (опционально)
  const user = localStorage.getItem('user');
  if (!user) {
    showAuth.value = true;
  }
});

const handleAddToCart = (product) => {
  console.log("Товар добавлен:", product);
  // Тут твоя логика корзины
};
</script>

<style>
/* Общие стили для всего приложения */
* { box-sizing: border-box; }
body { margin: 0; font-family: 'Inter', sans-serif; background: #f6f3ee; }

.app-container {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}
</style>