<template>
  <div class="modal-overlay" @click.self="$emit('close')">
    <div class="modal-content">
      <div class="auth-tabs">
        <button :class="{ active: isLogin }" @click="isLogin = true">Вход</button>
        <button :class="{ active: !isLogin }" @click="isLogin = false">Регистрация</button>
      </div>

      <p v-if="errorMessage" class="error-text">{{ errorMessage }}</p>

      <form @submit.prevent="handleSubmit" class="auth-form">
        <div class="input-group">
          <label>Email</label>
          <input type="email" v-model="formData.email" placeholder="example@mail.com" required>
        </div>

        <div class="input-group">
          <label>Пароль</label>
          <input type="password" v-model="formData.password" placeholder="••••••••" required>
        </div>

        <div v-if="!isLogin" class="input-group">
          <label>Повторите пароль</label>
          <input type="password" v-model="formData.confirmPassword" placeholder="••••••••" required>
        </div>

        <button type="submit" class="submit-btn" :disabled="loading">
          {{ loading ? 'Загрузка...' : (isLogin ? 'Войти в аккаунт' : 'Зарегистрироваться') }}
        </button>
      </form>

      <p class="terms">Входя в аккаунт, вы соглашаетесь с правилами магазина <b>AVE SHOP</b></p>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue';

const emit = defineEmits(['auth-success', 'close']);

const isLogin = ref(true);
const loading = ref(false);
const errorMessage = ref('');

const formData = reactive({
  email: '',
  password: '',
  confirmPassword: ''
});

const handleSubmit = async () => {
  errorMessage.value = '';
  
  // Валидация для регистрации
  if (!isLogin.value && formData.password !== formData.confirmPassword) {
    errorMessage.value = 'Пароли не совпадают!';
    return;
  }

  loading.value = true;

  // Выбираем нужный скрипт в зависимости от вкладки
  const url = isLogin.value 
    ? 'http://vue-project/api/login.php' 
    : 'http://vue-project/api/register.php';

  try {
    const response = await fetch(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        email: formData.email,
        password: formData.password
      })
    });

    const result = await response.json();

    if (result.success) {
      // Сохраняем данные пользователя (без пароля) в браузер
      localStorage.setItem('user', JSON.stringify(result.user));
      emit('auth-success', result.user);
    } else {
      errorMessage.value = result.message || 'Ошибка авторизации';
    }
  } catch (err) {
    errorMessage.value = 'Не удалось связаться с сервером';
    console.error(err);
  } finally {
    loading.value = false;
  }
};
</script>

<style scoped>
/* ТВОИ СТИЛИ БЕЗ ИЗМЕНЕНИЙ */
.modal-overlay {
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(0, 0, 0, 0.7);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
  backdrop-filter: blur(8px);
}

.modal-content {
  background: white;
  padding: 40px;
  border-radius: 24px;
  width: 100%;
  max-width: 400px;
  box-shadow: 0 20px 40px rgba(0,0,0,0.3);
  text-align: center;
}

/* Добавленный стиль для ошибки */
.error-text {
  color: #e6652f;
  font-size: 14px;
  margin-bottom: 15px;
  font-weight: bold;
}

.auth-tabs {
  display: flex;
  justify-content: center;
  gap: 30px;
  margin-bottom: 30px;
  border-bottom: 2px solid #f0f0f0;
}

.auth-tabs button {
  background: none; border: none;
  padding-bottom: 10px;
  font-size: 18px; font-weight: bold;
  cursor: pointer; color: #bbb;
  transition: 0.3s;
  position: relative;
}

.auth-tabs button.active {
  color: #3d497b;
}

.auth-tabs button.active::after {
  content: '';
  position: absolute;
  bottom: -2px; left: 0;
  width: 100%; height: 2px;
  background: #e6652f;
}

.auth-form {
  text-align: left;
}

.input-group {
  margin-bottom: 18px;
}

.input-group label {
  display: block;
  font-size: 13px;
  color: #666;
  margin-bottom: 6px;
  font-weight: 500;
}

.input-group input {
  width: 100%;
  padding: 12px 15px;
  border: 1px solid #ddd;
  border-radius: 10px;
  font-size: 15px;
  outline: none;
  transition: 0.3s;
}

.input-group input:focus {
  border-color: #3d497b;
}

.submit-btn {
  width: 100%;
  background: #3d497b;
  color: white;
  border: none;
  padding: 14px;
  border-radius: 10px;
  font-size: 16px;
  font-weight: bold;
  cursor: pointer;
  transition: 0.3s;
  margin-top: 10px;
}

.submit-btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.submit-btn:hover:not(:disabled) {
  background: #e6652f;
  transform: translateY(-2px);
}

.terms {
  margin-top: 20px;
  font-size: 12px;
  color: #999;
  line-height: 1.4;
}
</style>