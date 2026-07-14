<script setup>
import { ref } from 'vue';
import AppLayout from '../layouts/AppLayout.vue';
import SearchBar from '../components/search/SearchBar.vue';
import CategoryChips from '../components/search/CategoryChips.vue';
import VideoCard from '../components/feed/VideoCard.vue';
import { categories, sampleVideos } from '../services/feed';

const query = ref('');
const activeCategory = ref('For You');
</script>

<template>
  <AppLayout>
    <section class="explore-view">
      <div>
        <h1>Explore</h1>
        <p class="muted">Fresh videos, creators, and trends built from the raw explore screen.</p>
      </div>
      <SearchBar v-model="query" />
      <CategoryChips v-model:active="activeCategory" :categories="categories" />
      <div class="video-grid">
        <VideoCard v-for="video in sampleVideos" :key="video.id" :video="video" compact />
      </div>
    </section>
  </AppLayout>
</template>

<style scoped>
.explore-view {
  display: grid;
  gap: var(--space-5);
}

.explore-view h1 {
  font-size: var(--text-2xl);
  font-weight: var(--weight-black);
  margin: 0 0 var(--space-2);
}

.explore-view p {
  margin: 0;
}

.video-grid {
  display: grid;
  gap: var(--space-4);
  grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
}
</style>
