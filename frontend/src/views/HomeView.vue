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
      <div class="home-view__tabs glass">
        <CategoryChips v-model:active="activeCategory" :categories="categories" />
      </div>
      <div class="home-view__feed">
        <VideoCard v-for="video in sampleVideos" :key="video.id" :video="video" />
      </div>
    </section>
  </AppLayout>
</template>

<style scoped>
.home-view {
  margin: 0 auto;
  max-width: 430px;
  position: relative;
}

.home-view__tabs {
  border-radius: var(--radius-full);
  left: 50%;
  padding: 6px 10px;
  position: sticky;
  top: 0;
  transform: translateX(0);
  width: 100%;
  z-index: 5;
}

.home-view__feed {
  display: grid;
  gap: var(--space-4);
  margin-top: var(--space-3);
  scroll-snap-type: y proximity;
}

.home-view__feed :deep(.video-card) {
  scroll-margin-top: 76px;
  scroll-snap-align: start;
}
</style>
