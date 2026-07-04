<script setup>
import BrandLogo from '../common/BrandLogo.vue';
import { useAuthStore } from '../../store/auth';

const authStore = useAuthStore();
</script>

<template>
  <header class="top-bar glass">
    <BrandLogo />
    <nav class="top-bar__links" aria-label="Main navigation">
      <RouterLink to="/explore">Explore</RouterLink>
      <RouterLink to="/search">Search</RouterLink>
      <RouterLink v-if="authStore.isAuthenticated" to="/dashboard">Dashboard</RouterLink>
    </nav>
    <RouterLink v-if="authStore.isAuthenticated" class="top-bar__avatar" to="/profile" aria-label="Profile">
      {{ authStore.user?.name?.charAt(0) || 'V' }}
    </RouterLink>
    <RouterLink v-else class="app-button ghost" to="/login">Login</RouterLink>
  </header>
</template>

<style scoped>
.top-bar {
  align-items: center;
  display: flex;
  gap: 16px;
  justify-content: space-between;
  left: 50%;
  max-width: 1160px;
  min-height: 56px;
  padding: 8px 12px;
  position: fixed;
  top: 12px;
  transform: translateX(-50%);
  width: min(calc(100% - 24px), 1160px);
  z-index: 90;
}

.top-bar__links {
  align-items: center;
  display: none;
  gap: 18px;
  color: var(--on-surface-muted);
  font-size: 14px;
  font-weight: 700;
}

.top-bar__links a.router-link-active {
  color: var(--on-surface);
}

.top-bar__avatar {
  align-items: center;
  background: linear-gradient(135deg, var(--primary-strong), var(--secondary-strong));
  border-radius: 999px;
  display: inline-flex;
  font-weight: 800;
  height: 40px;
  justify-content: center;
  width: 40px;
}

@media (min-width: 720px) {
  .top-bar__links {
    display: flex;
  }
}
</style>
