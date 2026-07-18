<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue';
import AppLayout from '../layouts/AppLayout.vue';
import VideoCard from '../components/feed/VideoCard.vue';
import CommentsSheet from '../components/feed/CommentsSheet.vue';
import StateBlock from '../components/common/StateBlock.vue';
import { fetchFeed } from '../services/videos';
import { useFeedStore } from '../store/feed';

const feedStore = useFeedStore();

const feedEl = ref(null);
const activeTab = ref('For You');
const tabs = ['Following', 'For You'];

const videos = ref([]);
const nextCursor = ref(null);
const loading = ref(true);
const loadingMore = ref(false);
const loadError = ref(false);

const commentsVideo = computed(
  () => videos.value.find((video) => video.id === feedStore.activeCommentsVideoId) || null
);

async function loadInitial() {
  loading.value = true;
  loadError.value = false;

  try {
    const page = await fetchFeed();
    videos.value = page.videos;
    nextCursor.value = page.nextCursor;
    feedStore.hydrateAll(page.videos);
  } catch {
    loadError.value = true;
  } finally {
    loading.value = false;
  }
}

async function loadMore() {
  if (!nextCursor.value || loadingMore.value || loading.value) return;

  loadingMore.value = true;

  try {
    const page = await fetchFeed({ cursor: nextCursor.value });
    videos.value = [...videos.value, ...page.videos];
    nextCursor.value = page.nextCursor;
    feedStore.hydrateAll(page.videos);
  } catch {
    /* the error toast already fired — the next scroll attempt retries */
  } finally {
    loadingMore.value = false;
  }
}

function onScroll() {
  const el = feedEl.value;
  if (!el) return;

  // Load the next page when the second-to-last snap item comes into view.
  if (el.scrollTop + el.clientHeight * 2 >= el.scrollHeight) {
    loadMore();
  }
}

function step(direction) {
  const el = feedEl.value;
  if (!el) return;
  const height = el.clientHeight;
  const index = Math.round(el.scrollTop / height);
  const next = Math.min(videos.value.length - 1, Math.max(0, index + direction));
  el.scrollTo({ top: next * height, behavior: 'smooth' });
}

let wheelLock = 0;

function onWheel(event) {
  const now = Date.now();
  if (now - wheelLock < 500 || Math.abs(event.deltaY) < 24) return;
  wheelLock = now;
  step(event.deltaY > 0 ? 1 : -1);
}

function onKeydown(event) {
  if (feedStore.activeCommentsVideoId) return;
  const tag = event.target?.tagName;
  if (tag === 'INPUT' || tag === 'TEXTAREA') return;

  if (event.key === 'ArrowDown' || event.key === 'PageDown') {
    event.preventDefault();
    step(1);
  } else if (event.key === 'ArrowUp' || event.key === 'PageUp') {
    event.preventDefault();
    step(-1);
  }
}

onMounted(() => {
  loadInitial();
  window.addEventListener('keydown', onKeydown);
});

onBeforeUnmount(() => window.removeEventListener('keydown', onKeydown));
</script>

<template>
  <AppLayout immersive>
    <div class="home-feed__tabs" role="tablist" aria-label="Feed">
      <button
        v-for="tab in tabs"
        :key="tab"
        type="button"
        role="tab"
        :aria-selected="activeTab === tab"
        :class="{ 'is-active': activeTab === tab }"
        @click="activeTab = tab"
      >
        {{ tab }}
      </button>
    </div>

    <div ref="feedEl" class="home-feed" @wheel.passive="onWheel" @scroll.passive="onScroll">
      <template v-if="videos.length">
        <div v-for="video in videos" :key="video.id" class="home-feed__item">
          <VideoCard :video="video" full />
        </div>
        <StateBlock v-if="loadingMore" loading compact message="Loading more…" />
      </template>

      <StateBlock v-else-if="loading" loading message="Loading your feed…" />

      <StateBlock v-else-if="loadError" icon="cloud_off" message="Could not load the feed.">
        <button class="app-button primary" type="button" @click="loadInitial">Try again</button>
      </StateBlock>

      <StateBlock v-else icon="movie" message="No videos yet. Be the first to post one.">
        <RouterLink class="app-button primary" to="/create">Create video</RouterLink>
      </StateBlock>
    </div>

    <CommentsSheet :video="commentsVideo" />
  </AppLayout>
</template>

<style scoped>
.home-feed {
  height: 100dvh;
  overflow-y: auto;
  overscroll-behavior: contain;
  scroll-snap-type: y mandatory;
  scrollbar-width: none;
}

.home-feed::-webkit-scrollbar {
  display: none;
}

.home-feed__item {
  height: 100dvh;
  margin: 0 auto;
  scroll-snap-align: start;
  scroll-snap-stop: always;
  width: min(100%, calc(100dvh * 9 / 16));
}

.home-feed__tabs {
  display: flex;
  gap: var(--space-5);
  justify-content: center;
  left: 50%;
  position: fixed;
  top: calc(14px + env(safe-area-inset-top));
  transform: translateX(-50%);
  z-index: 80;
}

.home-feed__tabs button {
  background: transparent;
  border: 0;
  color: rgba(255, 255, 255, 0.6);
  cursor: pointer;
  font-size: var(--text-base);
  font-weight: var(--weight-bold);
  padding: 6px 2px;
  position: relative;
  text-shadow: 0 1px 6px rgba(0, 0, 0, 0.6);
  transition: color var(--duration-base) var(--ease-standard);
}

.home-feed__tabs button::after {
  background: var(--on-vivid);
  border-radius: var(--radius-full);
  bottom: 0;
  content: '';
  height: 3px;
  left: 50%;
  opacity: 0;
  position: absolute;
  transform: translateX(-50%) scaleX(0.4);
  transition: opacity var(--duration-base) var(--ease-standard), transform var(--duration-base) var(--ease-standard);
  width: 24px;
}

.home-feed__tabs button.is-active {
  color: var(--on-vivid);
}

.home-feed__tabs button.is-active::after {
  opacity: 1;
  transform: translateX(-50%) scaleX(1);
}
</style>
