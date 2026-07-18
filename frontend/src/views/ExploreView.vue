<script setup>
import { ref, onMounted } from 'vue';
import AppLayout from '../layouts/AppLayout.vue';
import SearchBar from '../components/search/SearchBar.vue';
import CategoryChips from '../components/search/CategoryChips.vue';
import VideoCard from '../components/feed/VideoCard.vue';
import StateBlock from '../components/common/StateBlock.vue';
import { fetchFeed } from '../services/videos';
import { useFeedStore } from '../store/feed';

const categories = ['For You', 'Animation', 'Nature', 'Underwater', 'Film', 'Blender'];

const feedStore = useFeedStore();

const query = ref('');
const activeCategory = ref('For You');
const videos = ref([]);
const loading = ref(true);

async function load(search = '') {
  loading.value = true;

  try {
    const page = await fetchFeed({ search });
    videos.value = page.videos;
    feedStore.hydrateAll(page.videos);
  } finally {
    loading.value = false;
  }
}

function selectCategory(category) {
  activeCategory.value = category;
  load(category === 'For You' ? '' : category);
}

function submitSearch() {
  activeCategory.value = 'For You';
  load(query.value.trim());
}

onMounted(() => load());
</script>

<template>
  <AppLayout>
    <section class="page-stack">
      <div class="page-header">
        <h1>Explore</h1>
        <p class="muted">Fresh videos, creators, and trends from the community.</p>
      </div>
      <SearchBar v-model="query" @keyup.enter="submitSearch" />
      <CategoryChips :active="activeCategory" :categories="categories" @update:active="selectCategory" />
      <StateBlock v-if="loading" loading compact message="Loading videos…" />
      <StateBlock v-else-if="!videos.length" compact icon="movie" message="Nothing here yet — try another category." />
      <div v-else class="video-grid">
        <VideoCard v-for="video in videos" :key="video.id" :video="video" compact />
      </div>
    </section>
  </AppLayout>
</template>
