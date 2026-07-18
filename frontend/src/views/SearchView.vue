<script setup>
import { ref, watch, onMounted, onBeforeUnmount } from 'vue';
import AppLayout from '../layouts/AppLayout.vue';
import SearchBar from '../components/search/SearchBar.vue';
import VideoCard from '../components/feed/VideoCard.vue';
import StateBlock from '../components/common/StateBlock.vue';
import { fetchFeed } from '../services/videos';
import { useFeedStore } from '../store/feed';

const feedStore = useFeedStore();

const query = ref('');
const results = ref([]);
const loading = ref(true);
const searched = ref(false);

async function search(term) {
  loading.value = true;

  try {
    const page = await fetchFeed({ search: term });
    results.value = page.videos;
    feedStore.hydrateAll(page.videos);
    searched.value = Boolean(term);
  } finally {
    loading.value = false;
  }
}

let debounceTimer = null;

watch(query, (value) => {
  if (debounceTimer) window.clearTimeout(debounceTimer);
  debounceTimer = window.setTimeout(() => search(value.trim()), 350);
});

onMounted(() => search(''));
onBeforeUnmount(() => {
  if (debounceTimer) window.clearTimeout(debounceTimer);
});
</script>

<template>
  <AppLayout>
    <section class="page-stack">
      <div class="page-header">
        <h1>Search</h1>
        <p class="muted">Find videos, creators, captions, and tags.</p>
      </div>
      <SearchBar v-model="query" />
      <StateBlock v-if="loading" loading compact message="Searching…" />
      <StateBlock
        v-else-if="searched && !results.length"
        compact
        icon="search_off"
        :message="`No results for “${query.trim()}”. Try another title, caption, or tag.`"
      />
      <template v-else>
        <p v-if="searched" class="muted search-view__count">
          {{ results.length }} result{{ results.length === 1 ? '' : 's' }}
        </p>
        <div class="video-grid">
          <VideoCard v-for="video in results" :key="video.id" :video="video" compact />
        </div>
      </template>
    </section>
  </AppLayout>
</template>

<style scoped>
.search-view__count {
  margin: 0;
}
</style>
