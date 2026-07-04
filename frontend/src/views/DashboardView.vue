<script setup>
import AppLayout from '../layouts/AppLayout.vue';
import { useAuthStore } from '../store/auth';

const authStore = useAuthStore();
</script>

<template>
  <AppLayout>
    <section class="dashboard-view">
      <div>
        <h1>Dashboard</h1>
        <p class="muted">Welcome, {{ authStore.user?.name || 'creator' }}. Track content, drafts, and performance.</p>
      </div>
      <div class="dashboard-view__grid">
        <article class="glass">
          <span class="material-symbols-outlined">movie</span>
          <strong>24</strong>
          <p>Published videos</p>
        </article>
        <article class="glass">
          <span class="material-symbols-outlined">draft</span>
          <strong>7</strong>
          <p>Drafts</p>
        </article>
        <article class="glass">
          <span class="material-symbols-outlined">trending_up</span>
          <strong>18%</strong>
          <p>Weekly growth</p>
        </article>
      </div>
    </section>
  </AppLayout>
</template>

<style scoped>
.dashboard-view {
  display: grid;
  gap: 22px;
}

.dashboard-view h1 {
  font-size: 34px;
  margin: 0 0 8px;
}

.dashboard-view p {
  margin: 0;
}

.dashboard-view__grid {
  display: grid;
  gap: 14px;
  grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
}

.dashboard-view article {
  border-radius: var(--radius-xl);
  display: grid;
  gap: 8px;
  padding: 22px;
}

.dashboard-view article strong {
  font-size: 34px;
}
</style>
