<template>
  <transition name="slide-fade">
    <div class="cart-overlay" @click.self="$emit('close')">
      <div class="cart-widget">
        
        <div class="cart-header">
          <h2>Корзина <span>({{ totalCount }})</span></h2>
          <button class="close-btn" @click="$emit('close')" title="Закрыть">×</button>
        </div>

        <div class="cart-content">
          <div v-if="items.length === 0" class="empty-msg">
            <p>Ваша корзина пока пуста</p>
          </div>
          
          <div v-else class="cart-items">
            <div v-for="item in items" :key="item.id" class="cart-item">
              <div class="item-image">
                <img 
                  :src="item.image ? `/assets/img/products/${item.image.replace('.png', '.jpg')}` : 'https://via.placeholder.com/60'" 
                  :alt="item.name"
                >
              </div>
              
              <div class="item-details">
                <span class="item-name">{{ item.name }}</span>
                
                <div class="item-controls">
                  <div class="quantity-selector">
                    <button 
                      @click="$emit('change-quantity', { id: item.id, delta: -1 })" 
                      :disabled="item.quantity <= 1"
                      class="qty-btn minus"
                    >−</button>
                    
                    <span class="qty-num">{{ item.quantity }}</span>
                    
                    <button 
                      @click="$emit('change-quantity', { id: item.id, delta: 1 })" 
                      class="qty-btn plus"
                    >+</button>
                  </div>
                  <span class="item-price">{{ formatPrice(item.price * item.quantity) }}</span>
                </div>
              </div>

              <button class="remove-btn" @click="$emit('remove', item.id)" title="Удалить">🗑️</button>
            </div>
          </div>
        </div>

        <div class="cart-footer" v-if="items.length > 0">
          <div class="total-row">
            <span class="total-label">Итого:</span>
            <span class="total-sum">{{ formatPrice(totalSum) }}</span>
          </div>
          <button class="checkout-btn">Оформить заказ</button>
        </div>
      </div>
    </div>
  </transition>
</template>

<script setup>

  import { computed } from 'vue';

  const props = defineProps(['items']);

  // Проверь, чтобы это было написано именно так:
  defineEmits(['close', 'remove', 'change-quantity']);

  const formatPrice = (value) => {
    return new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB', maximumFractionDigits: 0 }).format(value);
  };

  // Хедер (количество штук)
  const totalCount = computed(() => props.items.reduce((sum, item) => sum + item.quantity, 0));

  // Итоговая сумма
  const totalSum = computed(() => props.items.reduce((sum, item) => sum + (item.price * item.quantity), 0));
</script>

<style scoped>
/* --- БАЗОВЫЕ СТИЛИ ШТОРКИ (Остались полностью такими же, как были) --- */
.cart-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 3000; backdrop-filter: blur(5px); }
.cart-widget { position: absolute; right: 0; top: 0; width: 100%; max-width: 420px; height: 100%; background: #fbf9f6; display: flex; flex-direction: column; box-shadow: -10px 0 30px rgba(0,0,0,0.15); border-radius: 24px 0 0 24px; overflow: hidden; }
.cart-header { display: flex; justify-content: space-between; align-items: center; padding: 25px 30px; background: white; border-bottom: 1px solid #eee; }
.cart-header h2 { margin: 0; font-size: 22px; color: #333; font-weight: 800; }
.cart-header span { color: #999; font-size: 18px; margin-left: 5px; }
.close-btn { background: none; border: none; font-size: 32px; color: #bbb; cursor: pointer; transition: 0.2s; }
.close-btn:hover { color: #e6652f; }
.cart-content { flex: 1; overflow-y: auto; padding: 20px; }
.empty-msg { text-align: center; color: #999; margin-top: 80px; }
.cart-items { display: flex; flex-direction: column; gap: 15px; }

/* --- КАРТОЧКА ТОВАРА (Дизайн сохранен с твоего скриншота) --- */
.cart-item {
  display: flex;
  align-items: center;
  gap: 15px;
  background: white;
  padding: 15px;
  border-radius: 16px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.03);
  position: relative; /* Для позиционирования корзины */
}

.item-image { width: 60px; height: 60px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; }
.item-image img { max-width: 100%; max-height: 100%; object-fit: contain; }

.item-details { flex-grow: 1; display: flex; flex-direction: column; gap: 4px; padding-right: 30px; /* Чтобы не наезжало на корзину */ }
.item-name { font-size: 14px; color: #333; font-weight: 500; line-height: 1.3; display: block; }
.item-price { font-size: 16px; font-weight: bold; color: #e6652f; margin-left: auto; } /* Цена справа */

/* Иконка корзины 🗑️ (позиция с твоего скриншота) */
.remove-btn {
  background: none; border: none; cursor: pointer; opacity: 0.3; transition: 0.2s; font-size: 16px;
  position: absolute; top: 15px; right: 15px;
}
.remove-btn:hover { opacity: 1; }

/* --- НОВЫЙ МИНИМАЛИСТИЧНЫЙ БЛОК КОЛИЧЕСТВА --- */
.item-controls {
  display: flex;
  align-items: center;
  justify-content: space-between; /* Распределяем кнопки и цену */
  margin-top: 8px; /* Отступ от названия */
}

.quantity-selector {
  display: flex;
  align-items: center;
  background: transparent; /* Оставляем фон карточки белым */
  border: 1px solid #eee; /* Тонкая обводка */
  border-radius: 8px;
  padding: 1px;
}

.qty-btn {
  width: 26px;
  height: 26px;
  border: none;
  background: transparent; /* Без фона */
  color: #bbb; /* Бледный цвет */
  cursor: pointer;
  font-weight: bold;
  font-size: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: 0.2s;
}

.qty-btn:hover:not(:disabled) {
  color: #e6652f; /* Оранжевый при наведении */
}

.qty-btn:disabled {
  opacity: 0.3;
  cursor: not-allowed;
}

.qty-num {
  margin: 0 10px;
  font-size: 14px;
  font-weight: bold;
  color: #333;
  min-width: 15px;
  text-align: center;
}

/* --- ФУТЕР И АНИМАЦИЯ (Без изменений) --- */
.cart-footer { background: white; border-top: 1px solid #eee; padding: 25px 30px; border-radius: 24px 24px 0 0; }
.total-row { display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 20px; }
.total-label { font-size: 16px; color: #666; }
.total-sum { font-size: 24px; font-weight: 800; color: #333; }
.checkout-btn { width: 100%; background: #e6652f; color: white; border: none; padding: 16px; border-radius: 12px; font-size: 16px; font-weight: bold; cursor: pointer; transition: 0.3s; }
.checkout-btn:hover { background: #3d497b; }
.slide-fade-enter-active, .slide-fade-leave-active { transition: all 0.4s ease; }
.slide-fade-enter-from, .slide-fade-leave-to { opacity: 0; transform: translateX(100%); }
</style>