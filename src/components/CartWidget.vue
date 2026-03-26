<template>
  <div class="cart-overlay" @click.self="$emit('close')">
    <div class="cart-widget">
      <div class="cart-header">
        <h2>Корзина</h2>
        <button class="close-btn" @click="$emit('close')">✕</button>
      </div>

      <div class="cart-content">
        <div v-if="items.length === 0" class="empty-msg">
          Ваша корзина пока пуста
        </div>
        
        <div v-else class="cart-items">
          <div v-for="item in items" :key="item.id" class="cart-item">
            <span>{{ item.name }}</span>
            <div class="item-info">
              <strong>{{ item.price }} ₽</strong>
              <button @click="$emit('remove', item.id)">🗑️</button>
            </div>
          </div>
        </div>
      </div>

      <div class="cart-footer" v-if="items.length > 0">
        <div class="total">Итого: {{ totalSum }} ₽</div>
        <button class="checkout-btn">Оформить заказ</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
const props = defineProps(['items']);
const totalSum = computed(() => props.items.reduce((sum, item) => sum + item.price, 0));
</script>

<style scoped>
.cart-overlay {
  position: fixed; top: 0; left: 0; width: 100%; height: 100%;
  background: rgba(0,0,0,0.5); z-index: 2000;
}
.cart-widget {
  position: absolute; right: 0; top: 0; width: 350px; height: 100%;
  background: white; display: flex; flex-direction: column;
  box-shadow: -5px 0 15px rgba(0,0,0,0.1); padding: 20px;
}
.cart-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eee; padding-bottom: 15px; }
.close-btn { background: none; border: none; font-size: 20px; cursor: pointer; }
.cart-content { flex: 1; overflow-y: auto; padding: 20px 0; }
.cart-item { display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 14px; }
.empty-msg { text-align: center; color: #999; margin-top: 50px; }
.cart-footer { border-top: 1px solid #eee; padding-top: 20px; }
.total { font-size: 18px; font-weight: bold; margin-bottom: 15px; }
.checkout-btn { width: 100%; background: #e6652f; color: white; border: none; padding: 12px; border-radius: 8px; font-weight: bold; cursor: pointer; }
</style>