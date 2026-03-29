<template>
  <div class="catalog-page">
    <div class="container catalog-container">
      
      <aside class="filters-sidebar">
        <h3 class="filter-title">Фильтры</h3>
        
        <div class="filter-group">
          <div class="accordion-header no-arrow">
            <h4>Цена, ₽</h4>
          </div>
          <div class="price-inputs">
            <input type="number" v-model="filters.minPrice" placeholder="От">
            <input type="number" v-model="filters.maxPrice" placeholder="До">
          </div>
        </div>

        <div class="filter-group">
          <div class="accordion-header" @click="toggle('brands')">
            <h4>Бренд</h4>
            <span class="arrow" :class="{ rotate: open.brands }">⌵</span>
          </div>
          <div class="accordion-content" v-show="open.brands">
            <label v-for="b in ['Apple', 'Samsung', 'Xiaomi']" :key="b" class="check-row">
              <input type="checkbox" :value="b" v-model="filters.brands"> {{ b }}
            </label>
          </div>
        </div>

        <div class="filter-group">
          <div class="accordion-header" @click="toggle('storage')">
            <h4>Объем встроенной памяти</h4>
            <span class="arrow" :class="{ rotate: open.storage }">⌵</span>
          </div>
          <div class="accordion-content" v-show="open.storage">
            <label v-for="s in [64, 128, 256, 512]" :key="s" class="check-row">
              <input type="checkbox" :value="s" v-model="filters.storage"> {{ s }} ГБ
            </label>
          </div>
        </div>

        <div class="filter-group">
          <div class="accordion-header" @click="toggle('ram')">
            <h4>Объем оперативной памяти</h4>
            <span class="arrow" :class="{ rotate: open.ram }">⌵</span>
          </div>
          <div class="accordion-content" v-show="open.ram">
            <label v-for="r in [ 4, 6, 8, 12, 16]" :key="r" class="check-row">
              <input type="checkbox" :value="r" v-model="filters.ram"> {{ r }} ГБ
            </label>
          </div>
        </div>

        <div class="filter-actions">
          <button @click="loadProducts" class="apply-btn">Применить</button>
          <button @click="resetFilters" class="reset-btn">Сбросить всё</button>
        </div>
      </aside>

      <section class="catalog-content">
        <h2 class="section-title">
          {{ route.query.search ? 'Результаты поиска: ' + route.query.search : 'Каталог смартфонов' }}
        </h2>
        
        <div v-if="loading" class="status">Загрузка...</div>
        <div v-else-if="products.length === 0" class="status">Товары не найдены</div>
        <div v-else class="products-grid">
          <ProductCard 
            v-for="p in products" 
            :key="p.id" 
            :product="p" 
            @add-to-cart="$emit('add-to-cart', $event)" 
          />
        </div>
      </section>

    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import { useRoute } from 'vue-router';
import ProductCard from './ProductCard.vue';

const route = useRoute();
const products = ref([]);
const loading = ref(false);

defineEmits(['add-to-cart']);

const open = ref({ brands: true, storage: false, ram: true });
const toggle = (key) => { open.value[key] = !open.value[key]; };

const filters = ref({
  minPrice: '', 
  maxPrice: '',
  brands: [], 
  storage: [], 
  ram: [],
  search: '' // Добавили поле поиска в фильтры
});

const loadProducts = async () => {
  loading.value = true;
  const p = new URLSearchParams();
  
  // Добавляем поиск в параметры запроса к PHP
  if (route.query.search) p.append('search', route.query.search);
  
  if (filters.value.minPrice) p.append('min_price', filters.value.minPrice);
  if (filters.value.maxPrice) p.append('max_price', filters.value.maxPrice);
  if (filters.value.brands.length) p.append('brands', filters.value.brands.join(','));
  if (filters.value.storage.length) p.append('storage', filters.value.storage.join(','));
  if (filters.value.ram.length) p.append('ram', filters.value.ram.join(','));

  try {
    const res = await fetch(`http://vue-project/api/get_products.php?${p}`);
    products.value = await res.json();
  } catch (err) {
    console.error("Ошибка загрузки:", err);
    products.value = []; // Очищаем список при ошибке
  } finally { 
    loading.value = false; 
  }
};

const resetFilters = () => {
  filters.value = { minPrice: '', maxPrice: '', brands: [], storage: [], ram: [], search: '' };
  loadProducts();
};

const syncFiltersWithQuery = () => {
  if (route.query.brand) {
    filters.value.brands = [route.query.brand];
  }
};

onMounted(() => {
  syncFiltersWithQuery();
  loadProducts();
});

// Критично: Следим за поиском! Если в URL меняется поиск, загружаем заново
watch(() => route.query.search, () => {
  loadProducts();
});

watch(() => route.query.brand, () => {
  syncFiltersWithQuery();
  loadProducts();
});
</script>

<style scoped>
.catalog-page { background: #f6f3ee; padding: 40px 0; min-height: 100vh; font-family: Arial, sans-serif; }
.catalog-container { display: flex; gap: 30px; max-width: 1200px; margin: 0 auto; align-items: flex-start; }
.filters-sidebar { width: 280px; flex-shrink: 0; background: white; padding: 20px; border-radius: 12px; position: sticky; top: 100px; }
.filter-title { margin-bottom: 20px; font-size: 20px; }
.filter-group { border-bottom: 1px solid #f0f0f0; padding-bottom: 15px; margin-bottom: 15px; }
.accordion-header { display: flex; justify-content: space-between; cursor: pointer; }
.accordion-header h4 { font-size: 14px; margin: 0; font-weight: bold; }
.arrow { transition: 0.3s; color: #999; }
.arrow.rotate { transform: rotate(180deg); }
.accordion-content { margin-top: 10px; display: flex; flex-direction: column; gap: 8px; }
.price-inputs { display: flex; gap: 5px; margin-top: 10px; }
.price-inputs input { width: 50%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 13px; }
.check-row { display: flex; align-items: center; gap: 8px; font-size: 14px; cursor: pointer; }
.apply-btn { width: 100%; background: #e6652f; color: white; border: none; padding: 12px; border-radius: 8px; font-weight: bold; cursor: pointer; margin-top: 10px; }
.reset-btn { width: 100%; background: none; border: none; color: #999; margin-top: 10px; cursor: pointer; text-decoration: underline; font-size: 12px; }
.catalog-content { flex-grow: 1; }
.section-title { margin-bottom: 25px; font-size: 24px; }
.products-grid { 
  display: grid; 
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); 
  gap: 20px; 
}
.status { padding: 20px; text-align: center; color: #666; font-size: 18px; }
</style>