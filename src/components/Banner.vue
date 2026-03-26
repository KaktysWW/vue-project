<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

import img1 from '../assets/b1.png';
import img2 from '../assets/b2.png';

const currentSlide = ref(0);
let timer = null;

const slides = [
  { image: img1 },
  { image: img2 }
];

const nextSlide = () => { 
  currentSlide.value = (currentSlide.value + 1) % slides.length; 
};
const prevSlide = () => { 
  currentSlide.value = currentSlide.value === 0 ? slides.length - 1 : currentSlide.value - 1; 
};

onMounted(() => { timer = setInterval(nextSlide, 5000); });
onUnmounted(() => { if (timer) clearInterval(timer); });
</script>

<template>
  <section class="banner-section">
    <div class="container">
      <div class="slider-wrapper">
        <div 
          class="slider-inner" 
          :style="{ transform: `translateX(-${currentSlide * 100}%)` }"
        >
          <div 
            v-for="(slide, index) in slides" 
            :key="index" 
            class="slide"
          >
            <div class="image-only-wrapper">
              <img :src="slide.image" class="banner-img" alt="banner">
            </div>
          </div>
        </div>

        <button class="arrow prev" @click="prevSlide">‹</button>
        <button class="arrow next" @click="nextSlide">›</button>

        <div class="dots">
          <span 
            v-for="(_, index) in slides" 
            :key="index" 
            :class="{ active: currentSlide === index }"
            @click="currentSlide = index"
          ></span>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.banner-section {
  padding: 20px 0;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
}

.slider-wrapper {
  position: relative;
  border-radius: 20px;
  overflow: hidden;
  height: 400px;
  background: #3d497b;
}

.slider-inner {
  display: flex;
  height: 100%;
  transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.slide {
  min-width: 100%;
  height: 100%;
}

.banner-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.arrow {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background: rgba(255, 255, 255, 0.9);
  color: #3d497b;
  border: none;
  width: 44px;
  height: 44px;
  border-radius: 50%;
  cursor: pointer;
  font-size: 28px;
  z-index: 10;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  transition: all 0.3s;
}

.arrow:hover {
  background: #e6652f;
  color: white;
}

.prev { left: 20px; }
.next { right: 20px; }

.dots {
  position: absolute;
  bottom: 20px;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  gap: 10px;
}

.dots span {
  width: 12px;
  height: 6px;
  background: rgba(255, 255, 255, 0.5);
  border-radius: 10px;
  cursor: pointer;
  transition: all 0.3s;
}

.dots span.active {
  background: #e6652f;
  width: 30px;
}
</style>