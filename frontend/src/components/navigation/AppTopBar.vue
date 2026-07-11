<script setup>
import { useRouter } from 'vue-router';
import BrandLogo from '../common/BrandLogo.vue';
import { useAuthStore } from '../../store/auth';

const authStore = useAuthStore();
const router = useRouter();

function handleLogout() {
  authStore.logout();
  router.push({ name: 'welcome' });
}
</script>

<template>
  <header class="top-bar glass">
    <BrandLogo />
    <nav class="top-bar__links" aria-label="Main navigation">
      <RouterLink to="/explore">Explore</RouterLink>
      <RouterLink to="/search">Search</RouterLink>
      <RouterLink v-if="authStore.isAuthenticated" to="/dashboard">Dashboard</RouterLink>
    </nav>
    <div v-if="authStore.isAuthenticated" class="top-bar__account">
      <RouterLink class="top-bar__avatar" to="/profile" aria-label="Profile">
        {{ authStore.user?.name?.charAt(0) || 'V' }}
      </RouterLink>
      <button type="button" class="top-bar__logout" aria-label="Log out" title="Log out" @click="handleLogout">
        <span class="material-symbols-outlined">logout</span>
      </button>
    </div>
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

.top-bar__account {
  align-items: center;
  display: flex;
  gap: 8px;
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

.top-bar__logout {
  align-items: center;
  background: rgba(255, 255, 255, 0.06);
  border: 1px solid rgba(255, 255, 255, 0.12);
  border-radius: 999px;
  color: var(--on-surface-muted);
  cursor: pointer;
  display: inline-flex;
  height: 40px;
  justify-content: center;
  transition: color 160ms ease, border-color 160ms ease;
  width: 40px;
}

.top-bar__logout:hover {
  border-color: var(--error);
  color: var(--error);
}

@media (min-width: 720px) {
  .top-bar__links {
    display: flex;
  }
}
</style>
