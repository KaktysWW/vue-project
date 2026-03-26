<template>
  <div class="modal-overlay">
    <div class="modal-content">
      <div class="auth-tabs">
        <button :class="{ active: isLogin }" @click="isLogin = true">Вход</button>
        <button :class="{ active: !isLogin }" @click="isLogin = false">Регистрация</button>
      </div>

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

        <button type="submit" class="submit-btn">
          {{ isLogin ? 'Войти в аккаунт' : 'Зарегистрироваться' }}
        </button>
      </form>

      <p class="terms">Входя в аккаунт, вы соглашаетесь с правилами магазина <b>AVE SHOP</b></p>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue';

const emit = defineEmits(['auth-success']);

const isLogin = ref(true);
const formData = reactive({
  email: '',
  password: '',
  confirmPassword: ''
});

const handleSubmit = () => {
  // Здесь будет логика отправки на сервер (PHP)
  console.log("Данные формы:", formData);
  
  // Имитируем успешный вход и закрываем окно
  emit('auth-success');
};
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(0, 0, 0, 0.7); /* Темный фон */
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999; /* Поверх всего */
  backdrop-filter: blur(8px); /* Размытие заднего фона */
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
  background: #e6652f; /* Оранжевая полоска под активной вкладкой */
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
  background: #3d497b; /* Твой синий */
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

.submit-btn:hover {
  background: #e6652f; /* Твой оранжевый */
  transform: translateY(-2px);
}

.terms {
  margin-top: 20px;
  font-size: 12px;
  color: #999;
  line-height: 1.4;
}
</style>