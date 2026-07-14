<script setup>
import { useRouter } from 'vue-router';
import BrandLogo from '../common/BrandLogo.vue';
import ThemeToggle from '../common/ThemeToggle.vue';
import IconButton from '../common/IconButton.vue';
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
    <div class="top-bar__account">
      <ThemeToggle class="top-bar__theme-toggle" />
      <template v-if="authStore.isAuthenticated">
        <RouterLink class="top-bar__avatar" to="/profile" aria-label="Profile">
          {{ authStore.user?.name?.charAt(0) || 'V' }}
        </RouterLink>
        <IconButton icon="logout" label="Log out" variant="danger" @click="handleLogout" />
      </template>
      <RouterLink v-else class="app-button ghost" to="/login">Login</RouterLink>
    </div>
  </header>
</template>

<style scoped>
.top-bar {
  align-items: center;
  display: flex;
  gap: var(--space-4);
  justify-content: space-between;
  left: 50%;
  max-width: 1160px;
  min-height: 56px;
  padding: var(--space-2) var(--space-3);
  position: fixed;
  top: 12px;
  transform: translateX(-50%);
  width: min(calc(100% - 24px), 1160px);
  z-index: 90;
}

.top-bar__links {
  align-items: center;
  display: none;
  gap: var(--space-5);
  color: var(--on-surface-muted);
  font-size: var(--text-sm);
  font-weight: var(--weight-bold);
}

.top-bar__links a.router-link-active {
  color: var(--on-surface);
}

.top-bar__account {
  align-items: center;
  display: flex;
  gap: var(--space-2);
}

.top-bar__avatar {
  align-items: center;
  background: linear-gradient(135deg, var(--primary-strong), var(--secondary-strong));
  border-radius: var(--radius-full);
  color: var(--on-vivid);
  display: inline-flex;
  font-weight: var(--weight-black);
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
