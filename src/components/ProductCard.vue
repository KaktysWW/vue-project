<template>
  <div class="product-card">
    <div class="product-image">
      <img 
        :src="product.image ? `/assets/img/products/${product.image.replace('.png', '.jpg')}` : 'https://via.placeholder.com/200'" 
        :alt="product.name"
      >
    </div>
    <div class="product-info">
      <h3 class="product-title">{{ product.name }}</h3>
      
      <div class="price-container">
        <span class="current-price">{{ formatPrice(product.price) }}</span>
        <span v-if="product.old_price" class="old-price">{{ formatPrice(product.old_price) }}</span>
      </div>
      
      <button class="add-to-cart" @click="$emit('add-to-cart', product)">
        Купить
      </button>
    </div>
  </div>
</template>

<script setup>
const props = defineProps(['product']);

// Добавили регистрацию события для корректной работы корзины
defineEmits(['add-to-cart']);

// Твоя функция форматирования цены
const formatPrice = (value) => {
  if (!value) return '';
  return new Intl.NumberFormat('ru-RU', { 
    style: 'currency', 
    currency: 'RUB', 
    maximumFractionDigits: 0 
  }).format(value);
};
</script>

<style scoped>
/* Стили остались полностью твоими, без изменений */
.product-card {
  background: #fff;
  border-radius: 12px;
  padding: 15px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.05);
  transition: transform 0.2s;
  display: flex;
  flex-direction: column;
}
.product-card:hover { transform: translateY(-5px); }

.product-image { 
  height: 180px; 
  display: flex; 
  align-items: center; 
  justify-content: center; 
  margin-bottom: 15px;
}
.product-image img { 
  max-width: 100%; 
  max-height: 100%; 
  object-fit: contain; 
}

.product-info {
  display: flex;
  flex-direction: column;
  flex-grow: 1;
}

.product-title { 
  font-size: 14px; 
  margin: 0 0 10px; 
  color: #333; 
  height: 40px; 
  overflow: hidden; 
  line-height: 1.4; 
}

.price-container { 
  display: flex; 
  align-items: baseline; 
  gap: 8px; 
  margin-top: auto; 
  margin-bottom: 15px;
}
.current-price { 
  color: #e6652f; 
  font-weight: bold; 
  font-size: 18px; 
}
.old-price { 
  text-decoration: line-through; 
  color: #999; 
  font-size: 13px; 
}

.add-to-cart { 
  background: #3d497b; 
  color: white; 
  border: none; 
  padding: 12px; 
  border-radius: 8px; 
  cursor: pointer; 
  transition: 0.3s;
  font-weight: bold;
}
.add-to-cart:hover { 
  background: #e6652f; 
}
</style>