<script setup>
import { computed, ref } from 'vue';
import AppLayout from '../layouts/AppLayout.vue';
import SearchBar from '../components/search/SearchBar.vue';
import VideoCard from '../components/feed/VideoCard.vue';
import { sampleVideos } from '../services/feed';

const query = ref('');
const results = computed(() => {
  const term = query.value.trim().toLowerCase();

  if (!term) return sampleVideos;

  return sampleVideos.filter((video) => {
    return [video.title, video.creator, video.caption, ...video.tags].some((value) => value.toLowerCase().includes(term));
  });
});
</script>

<template>
  <AppLayout>
    <section class="search-view">
      <div>
        <h1>Search</h1>
        <p class="muted">Find videos, creators, captions, and tags.</p>
      </div>
      <SearchBar v-model="query" />
      <div class="search-view__results">
        <VideoCard v-for="video in results" :key="video.id" :video="video" compact />
      </div>
    </section>
  </AppLayout>
</template>

<style scoped>
.search-view {
  display: grid;
  gap: 20px;
}

.search-view h1 {
  font-size: 34px;
  margin: 0 0 8px;
}

.search-view p {
  margin: 0;
}

.search-view__results {
  display: grid;
  gap: 14px;
  grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
}
</style>
