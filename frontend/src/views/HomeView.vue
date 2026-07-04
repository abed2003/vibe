<script setup>
import { ref } from 'vue';
import AppLayout from '../layouts/AppLayout.vue';
import CategoryChips from '../components/search/CategoryChips.vue';
import VideoCard from '../components/feed/VideoCard.vue';
import { categories, sampleVideos } from '../services/feed';

const activeCategory = ref('For You');
</script>

<template>
  <AppLayout>
    <section class="home-view">
      <div class="home-view__tabs">
        <CategoryChips v-model:active="activeCategory" :categories="categories" />
      </div>
      <VideoCard :video="sampleVideos[0]" />
    </section>
  </AppLayout>
</template>

<style scoped>
.home-view {
  display: grid;
  gap: 14px;
  margin: 0 auto;
  max-width: 430px;
}
</style>
