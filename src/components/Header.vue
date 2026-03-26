<template>
  <header class="header">
    <div class="main-line-wrapper">
      <div class="container main-flex">
        
        <router-link to="/" class="logo">
          <span class="logo-red">AVE</span>
          <span class="logo-black">SHOP</span>
        </router-link>

        <router-link to="/catalog" class="catalog-btn">
          <div class="burger">
            <span></span><span></span><span></span>
          </div>
          Каталог
        </router-link>

        <div class="search-bar">
          <input type="text" v-model="searchText" placeholder="Поиск" />
          <button class="search-btn">🔍</button>
        </div>

        <div class="user-tools">
          <div class="tool-item" title="Корзина" @click="$emit('open-cart')">
            🛒 <span v-if="cartCount > 0">{{ cartCount }}</span>
          </div>
        </div>
      </div>
    </div>
  </header>
</template>

<script setup>

import { ref } from 'vue';

// Нам больше не нужны emit, так как роутер сам управляет переходами
const searchText = ref('');

defineEmits(['open-cart']);
</script>

<style scoped>
/* Сбрасываем стандартные стили ссылок для роутера */
.logo, .catalog-btn {
  text-decoration: none;
  user-select: none;
}

.header {
  font-family: Arial, Helvetica, sans-serif;
  -webkit-font-smoothing: antialiased;
  position: sticky;
  top: 0;
  z-index: 1000;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
  width: 100%;
  display: flex;
  align-items: center;
}

.main-line-wrapper {
  padding: 15px 0;
  background: #3d497b; /* Темно-синий */
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.main-flex {
  gap: 20px;
}

.logo {
  font-weight: bold;
  font-size: 24px;
  letter-spacing: -0.5px;
  display: flex;
  align-items: center;
  cursor: pointer;
}

.logo-red {
  background: #e6652f; /* Оранжевый */
  color: #f6f3ee;
  padding: 2px 8px;
  border-radius: 4px;
}

.logo-black {
  margin-left: 5px;
  color: #f6f3ee;
}

.catalog-btn {
  background: #e6652f;
  color: white;
  border: none;
  padding: 10px 18px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  gap: 10px;
  font-family: Arial, sans-serif;
  font-weight: bold;
  cursor: pointer;
  transition: transform 0.1s, background 0.3s;
}

.catalog-btn:hover {
  background: #d15624; /* Чуть темнее при наведении */
}

.catalog-btn:active {
  transform: scale(0.95);
}

.burger span {
  display: block;
  width: 16px;
  height: 2px;
  background: #f6f3ee;
  margin: 3px 0;
}

.search-bar {
  flex-grow: 1;
  display: flex;
  background: #f6f3ee;
  border-radius: 8px;
  padding: 2px 10px;
}

.search-bar input {
  width: 100%;
  border: none;
  background: transparent;
  padding: 10px;
  outline: none;
  font-family: Arial, sans-serif;
  font-size: 14px;
}

.search-btn {
  background: transparent;
  border: none;
  cursor: pointer;
  font-size: 18px;
}

.user-tools {
  display: flex;
  gap: 20px;
  font-size: 22px;
  cursor: pointer;
  color: #f6f3ee;
}

/* Стили для нижней линии категорий (если понадобится) */
.category-line-wrapper {
  border-bottom: 1px solid #eee;
  background: #fff;
}

.category-list {
  display: flex;
  list-style: none;
  gap: 30px;
  padding: 12px 0;
  margin: 0;
}
</style>