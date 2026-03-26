<template>
  <main>
    <Banner />
    <Brands />
    <NewProducts @add-to-cart="$emit('add-to-cart', $event)" />
  </main>
</template>

<script setup>
import Banner from './Banner.vue';
import Brands from './Brands.vue';
import NewProducts from './NewProducts.vue';

defineEmits(['add-to-cart']);
</script>