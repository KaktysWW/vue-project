<template>
  <section class="new-arrivals">
    <div class="container">
      <div class="header-row">
        <h2>Новинки</h2>
        <router-link to="/catalog" class="view-all">Всё <span class="arrow">›</span></router-link>
      </div>

      <div class="products-grid">
        <div v-if="isLoading">Загрузка товаров...</div>
        
        <ProductCard 
          v-else 
          v-for="product in products" 
          :key="product.id" 
          :product="product" 
          @add-to-cart="$emit('add-to-cart', $event)" 
        />
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import ProductCard from './ProductCard.vue';

// РЕГИСТРИРУЕМ событие, чтобы компонент мог его передавать
defineEmits(['add-to-cart']);

const products = ref([]);
const isLoading = ref(true);

const fetchProducts = async () => {
  try {
    const response = await fetch('http://vue-project/api/get_products.php');
    if (!response.ok) throw new Error('Ошибка сервера');
    
    const data = await response.json();
    // Берем первые 4 товара для блока новинок
    products.value = data.slice(0, 4); 
    
  } catch (error) {
    console.error("Не удалось загрузить товары:", error);
  } finally {
    isLoading.value = false;
  }
};

onMounted(fetchProducts);
</script>

<style scoped>
/* Твои оригинальные стили */
.new-arrivals { padding: 40px 0; }
.container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
.header-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
.header-row h2 { font-size: 32px; font-weight: bold; }
.view-all { color: #007bff; text-decoration: none; font-weight: 500; }
.products-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }

@media (max-width: 992px) {
  .products-grid { grid-template-columns: repeat(2, 1fr); }
}
</style>