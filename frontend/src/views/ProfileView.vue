<script setup>
import { ref, onMounted } from 'vue';
import AppLayout from '../layouts/AppLayout.vue';
import ProfileSummary from '../components/profile/ProfileSummary.vue';
import ThemeToggle from '../components/common/ThemeToggle.vue';
import IconButton from '../components/common/IconButton.vue';
import VideoCard from '../components/feed/VideoCard.vue';
import StateBlock from '../components/common/StateBlock.vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../store/auth';
import { useFeedStore } from '../store/feed';
import { useUiStore } from '../store/ui';
import { fetchUserVideos } from '../services/users';
import { deleteVideo } from '../services/videos';

const router = useRouter();
const authStore = useAuthStore();
const feedStore = useFeedStore();
const uiStore = useUiStore();

async function handleLogout() {
  await authStore.logout();
  router.push({ name: 'welcome' });
}

const videos = ref([]);
const loading = ref(true);
const deletingId = ref(null);

async function load() {
  loading.value = true;

  try {
    await authStore.refreshUser();
    const page = await fetchUserVideos(authStore.user.id);
    videos.value = page.videos;
    feedStore.hydrateAll(page.videos);
  } finally {
    loading.value = false;
  }
}

async function remove(video) {
  if (deletingId.value) return;
  if (!window.confirm(`Delete “${video.title}”? This cannot be undone.`)) return;

  deletingId.value = video.id;

  try {
    await deleteVideo(video.id);
    videos.value = videos.value.filter((item) => item.id !== video.id);
    uiStore.notify({ type: 'success', message: 'Video deleted.' });
    authStore.refreshUser();
  } finally {
    deletingId.value = null;
  }
}

onMounted(load);
</script>

<template>
  <AppLayout>
    <section class="page-stack">
      <div class="profile-view__toolbar">
        <ThemeToggle />
        <IconButton icon="logout" label="Log out" variant="danger" @click="handleLogout" />
      </div>
      <ProfileSummary :user="authStore.user" />

      <div class="section-title">
        <h2>My videos</h2>
        <span class="count-pill">{{ videos.length }}</span>
      </div>

      <StateBlock v-if="loading" loading compact message="Loading your videos…" />
      <StateBlock v-else-if="!videos.length" compact icon="video_library" message="You have not uploaded any videos yet.">
        <RouterLink class="app-button primary" to="/create">Upload your first video</RouterLink>
      </StateBlock>

      <div v-else class="video-grid">
        <div v-for="video in videos" :key="video.id" class="profile-view__item">
          <VideoCard :video="video" compact />
          <span v-if="video.status !== 'ready'" class="status-chip status-chip--overlay" :data-status="video.status">
            {{ video.status }}
          </span>
          <button
            type="button"
            class="profile-view__delete"
            :disabled="deletingId === video.id"
            :aria-label="`Delete ${video.title}`"
            @click="remove(video)"
          >
            <span class="material-symbols-outlined">delete</span>
          </button>
        </div>
      </div>
    </section>
  </AppLayout>
</template>

<style scoped>
.profile-view__toolbar {
  display: flex;
  gap: var(--space-2);
  justify-content: flex-end;
}

.profile-view__item {
  position: relative;
}

.profile-view__delete {
  align-items: center;
  background: rgba(10, 14, 20, 0.72);
  border: 0;
  border-radius: var(--radius-full);
  color: var(--error);
  cursor: pointer;
  display: inline-flex;
  height: 34px;
  justify-content: center;
  position: absolute;
  right: 8px;
  top: 8px;
  width: 34px;
  z-index: 2;
}

.profile-view__delete .material-symbols-outlined {
  font-size: 18px;
}

.profile-view__delete:disabled {
  cursor: default;
  opacity: 0.5;
}
</style>
