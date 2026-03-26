<template>
  <section class="brands-section">
    <div class="container">
      <div class="brands-grid">
        
        <div class="brand-card" @click="selectBrand('Apple')">
          <img src="/assets/img/logos/apple_logo.png" alt="Apple" class="logo-img">
        </div>

        <div class="brand-card" @click="selectBrand('Samsung')">
          <img src="/assets/img/logos/samsung_logo.jpg" alt="Samsung" class="logo-img samsung-fix">
        </div>

        <div class="brand-card" @click="selectBrand('Xiaomi')">
          <img src="/assets/img/logos/xiaomi_logo.png" alt="Xiaomi" class="logo-img">
        </div>

      </div>
    </div>
  </section>
</template>

<script setup>
import { useRouter } from 'vue-router';

const router = useRouter();

const selectBrand = (brandName) => {
  // Переходим в каталог и передаем название бренда в query-параметры
  router.push({ 
    path: '/catalog', 
    query: { brand: brandName } 
  });
};
</script>

<style scoped>
.brands-section { 
  padding: 40px 0; 
  background: #f6f3ee; /* Твой основной цвет фона */
}

.container { 
  max-width: 1200px; 
  margin: 0 auto; 
  padding: 0 20px; 
}

.brands-grid { 
  display: flex; /* Выстраивает карточки в ряд */
  gap: 20px; 
  width: 100%;
}

.brand-card {
  flex: 1; /* Все карточки одинаковой ширины */
  height: 120px; 
  border: 1px solid #e0e0e0; 
  border-radius: 16px;
  display: flex; 
  align-items: center; 
  justify-content: center;
  cursor: pointer; 
  background: #fff; 
  transition: 0.3s; 
  padding: 20px;
}

/* Эффект при наведении как на твоих рабочих макетах */
.brand-card:hover { 
  border-color: #e6652f; 
  transform: translateY(-3px); 
  box-shadow: 0 5px 15px rgba(0,0,0,0.1); 
}

.logo-img { 
  max-width: 80%; 
  max-height: 60%; 
  object-fit: contain; 
}

/* Специальная правка для лого Samsung, чтобы он не выглядел слишком громоздким */
.samsung-fix { 
  max-height: 55px; 
}
</style>