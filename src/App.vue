<template>
  <div class="app-container">
    <Header 
      :cartCount="cart.length" 
      @open-auth="showAuth = true" 
      @open-cart="showCart = true" 
    />

    <router-view @add-to-cart="handleAddToCart" />

    <CartWidget 
      v-if="showCart" 
      :items="cart" 
      @close="showCart = false" 
      @remove="handleRemoveFromCart"
      @change-quantity="handleUpdateQuantity" 
    />

    <AuthModal v-if="showAuth" @auth-success="showAuth = false" />

    <Footer />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import Header from './components/Header.vue';
import Footer from './components/Footer.vue';
import AuthModal from './components/AuthModal.vue';
import CartWidget from './components/CartWidget.vue';

const showAuth = ref(false);
const showCart = ref(false);
const cart = ref([]);

onMounted(() => {
  const user = localStorage.getItem('user');
  if (!user) showAuth.value = true;

  const savedCart = localStorage.getItem('cart');
  if (savedCart) cart.value = JSON.parse(savedCart);
});


const handleUpdateQuantity = (payload) => {
  // payload — это объект { id, delta }, который пришел из кнопки
  const item = cart.value.find(product => product.id === payload.id);
  
  if (item) {
    // Прибавляем 1 (если нажали +) или -1 (если нажали -)
    item.quantity += payload.delta;
    
    // Если пользователь нажал минус, когда была 1 штука — ничего не делаем
    if (item.quantity < 1) item.quantity = 1;
    
    // Сохраняем результат в память браузера
    saveCart();
  }
};

const handleAddToCart = (product) => {
  const existingItem = cart.value.find(item => item.id === product.id);
  if (existingItem) {
    existingItem.quantity++;
  } else {
    cart.value.push({ ...product, quantity: 1 });
  }
  saveCart();
};

const handleRemoveFromCart = (productId) => {
  cart.value = cart.value.filter(item => item.id !== productId);
  saveCart();
};

const saveCart = () => {
  localStorage.setItem('cart', JSON.stringify(cart.value));
};
</script>

<style>
* { box-sizing: border-box; }
body { margin: 0; font-family: 'Inter', sans-serif; background: #f6f3ee; }

.app-container {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}
</style>