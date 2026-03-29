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
          <input 
            type="text" 
            v-model="searchText" 
            placeholder="Поиск" 
            @keyup.enter="handleSearch"
          />
          <button class="search-btn" @click="handleSearch">🔍</button>
        </div>

        <div class="user-tools">
          
          <div class="profile-container" v-if="user">
            <div class="tool-item" @click="toggleUserMenu">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
              </svg>
            </div>

            <div v-if="isMenuOpen" class="user-widget">
              <div class="widget-info">
                <p class="widget-label">Аккаунт</p>
                <p class="widget-email">{{ user.email }}</p>
              </div>
              <div class="widget-divider"></div>
              <button class="widget-logout" @click="handleLogout">
                Выйти из профиля
              </button>
            </div>
          </div>

          <div v-else class="tool-item" title="Войти" @click="$emit('open-auth')">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
              <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
              <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
            </svg>
          </div>

          <div class="tool-item cart-item" title="Корзина" @click="$emit('open-cart')">
            🛒 <span v-if="cartCount > 0" class="cart-badge">{{ cartCount }}</span>
          </div>
        </div>
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { useRouter } from 'vue-router';

defineProps({
  cartCount: { type: Number, default: 0 }
});

const searchText = ref('');
const user = ref(null);
const isMenuOpen = ref(false); // Состояние виджета
const router = useRouter();
const emit = defineEmits(['open-cart', 'open-auth']);

const toggleUserMenu = () => {
  isMenuOpen.value = !isMenuOpen.value;
};

// Закрытие меню при клике вне его
const closeMenu = (e) => {
  if (!e.target.closest('.profile-container')) {
    isMenuOpen.value = false;
  }
};

const checkUser = () => {
  const savedUser = localStorage.getItem('user');
  user.value = savedUser ? JSON.parse(savedUser) : null;
};

const handleLogout = () => {
  localStorage.removeItem('user');
  user.value = null;
  isMenuOpen.value = false;
  router.push('/');
};

onMounted(() => {
  checkUser();
  window.addEventListener('click', closeMenu);
});

onUnmounted(() => {
  window.removeEventListener('click', closeMenu);
});

defineExpose({ checkUser });

const handleSearch = () => {
  if (searchText.value.trim()) {
    router.push({ path: '/catalog', query: { search: searchText.value } });
  } else {
    router.push('/catalog');
  }
};
</script>

<style scoped>
/* ТВОИ СТИЛИ БЕЗ ИЗМЕНЕНИЙ */
.logo, .catalog-btn { text-decoration: none; user-select: none; }
.header { font-family: Arial, sans-serif; position: sticky; top: 0; z-index: 1000; }
.container { max-width: 1200px; margin: 0 auto; padding: 0 20px; width: 100%; display: flex; align-items: center; }
.main-line-wrapper { padding: 15px 0; background: #3d497b; border-bottom: 1px solid rgba(255, 255, 255, 0.1); }
.main-flex { gap: 20px; }
.logo { font-weight: bold; font-size: 24px; display: flex; align-items: center; }
.logo-red { background: #e6652f; color: #f6f3ee; padding: 2px 8px; border-radius: 4px; }
.logo-black { margin-left: 5px; color: #f6f3ee; }
.catalog-btn { background: #e6652f; color: white; border: none; padding: 10px 18px; border-radius: 8px; display: flex; align-items: center; gap: 10px; font-weight: bold; cursor: pointer; transition: 0.3s; }
.catalog-btn:hover { background: #d15624; }
.burger span { display: block; width: 16px; height: 2px; background: #f6f3ee; margin: 3px 0; }
.search-bar { flex-grow: 1; display: flex; background: #f6f3ee; border-radius: 8px; padding: 2px 10px; }
.search-bar input { width: 100%; border: none; background: transparent; padding: 10px; outline: none; font-size: 14px; }
.search-btn { background: transparent; border: none; cursor: pointer; font-size: 18px; }
.user-tools { display: flex; gap: 20px; color: #f6f3ee; align-items: center; position: relative; }
.tool-item { cursor: pointer; display: flex; align-items: center; transition: 0.2s; }
.tool-item:hover { color: #e6652f; }
.cart-badge { background: #e6652f; color: white; font-size: 12px; padding: 2px 6px; border-radius: 10px; margin-left: -5px; font-weight: bold; }

/* НОВЫЕ СТИЛИ ДЛЯ ВИДЖЕТА */
.profile-container {
  position: relative;
  display: flex;
  align-items: center;
}

.user-widget {
  position: absolute;
  top: 45px;
  right: 0;
  background: white;
  color: #333;
  width: 220px;
  border-radius: 12px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.2);
  padding: 15px;
  z-index: 1001;
  border: 1px solid #eee;
}

.user-widget::before {
  content: '';
  position: absolute;
  top: -6px;
  right: 12px;
  width: 12px;
  height: 12px;
  background: white;
  transform: rotate(45deg);
  border-left: 1px solid #eee;
  border-top: 1px solid #eee;
}

.widget-info {
  margin-bottom: 12px;
}

.widget-label {
  font-size: 12px;
  color: #999;
  margin-bottom: 4px;
}

.widget-email {
  font-size: 14px;
  font-weight: bold;
  word-break: break-all;
}

.widget-divider {
  height: 1px;
  background: #eee;
  margin: 10px 0;
}

.widget-logout {
  width: 100%;
  background: #f8f9fa;
  border: 1px solid #ddd;
  color: #e6652f;
  padding: 8px;
  border-radius: 6px;
  font-weight: bold;
  cursor: pointer;
  transition: 0.2s;
}

.widget-logout:hover {
  background: #e6652f;
  color: white;
  border-color: #e6652f;
}
</style>