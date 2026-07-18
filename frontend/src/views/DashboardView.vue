<script setup>
import { ref, onMounted } from 'vue';
import AppLayout from '../layouts/AppLayout.vue';
import StateBlock from '../components/common/StateBlock.vue';
import { useAuthStore } from '../store/auth';
import { fetchDashboard } from '../services/users';
import { formatCount } from '../services/videos';

const authStore = useAuthStore();

const stats = ref(null);
const loading = ref(true);
const failed = ref(false);

async function load() {
  loading.value = true;
  failed.value = false;

  try {
    stats.value = await fetchDashboard();
  } catch {
    failed.value = true;
  } finally {
    loading.value = false;
  }
}

onMounted(load);
</script>

<template>
  <AppLayout>
    <section class="page-stack dashboard-view">
      <div class="page-header">
        <h1>Dashboard</h1>
        <p class="muted">Welcome, {{ authStore.user?.name || 'creator' }}. Track content, drafts, and performance.</p>
      </div>

      <StateBlock v-if="loading" loading compact message="Loading your stats…" />
      <StateBlock v-else-if="failed" compact icon="cloud_off" message="Could not load the dashboard.">
        <button class="app-button ghost" type="button" @click="load">Try again</button>
      </StateBlock>

      <div v-else-if="stats" class="dashboard-view__grid">
        <article class="glass">
          <span class="material-symbols-outlined dashboard-view__icon">movie</span>
          <strong>{{ formatCount(stats.videos_published) }}</strong>
          <p>Published videos</p>
        </article>
        <article class="glass">
          <span class="material-symbols-outlined dashboard-view__icon">hourglass_top</span>
          <strong>{{ formatCount(stats.videos_processing) }}</strong>
          <p>Processing</p>
        </article>
        <article class="glass">
          <span class="material-symbols-outlined dashboard-view__icon">error</span>
          <strong>{{ formatCount(stats.videos_failed) }}</strong>
          <p>Failed uploads</p>
        </article>
        <article class="glass">
          <span class="material-symbols-outlined dashboard-view__icon">visibility</span>
          <strong>{{ formatCount(stats.total_views) }}</strong>
          <p>Total views</p>
        </article>
        <article class="glass">
          <span class="material-symbols-outlined dashboard-view__icon">favorite</span>
          <strong>{{ formatCount(stats.total_likes) }}</strong>
          <p>Likes received</p>
        </article>
        <article class="glass">
          <span class="material-symbols-outlined dashboard-view__icon">group</span>
          <strong>{{ formatCount(stats.followers_count) }}</strong>
          <p>Followers</p>
        </article>
      </div>
    </section>
  </AppLayout>
</template>

<style scoped>
.dashboard-view p {
  margin: 0;
}

.dashboard-view__grid {
  display: grid;
  gap: var(--space-4);
  grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
}

.dashboard-view article {
  border-radius: var(--radius-xl);
  display: grid;
  gap: var(--space-2);
  padding: var(--space-6);
}

.dashboard-view article strong {
  font-size: var(--text-2xl);
  font-weight: var(--weight-black);
}

.dashboard-view__icon {
  color: var(--primary-strong);
  font-size: var(--text-xl);
}
</style>
