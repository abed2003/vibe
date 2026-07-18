<script setup>
import { computed } from 'vue';
import { formatCount } from '../../services/videos';

const props = defineProps({
  user: {
    type: Object,
    default: null
  }
});

const stats = computed(() => [
  { label: 'Followers', value: props.user?.followers_count ?? 0 },
  { label: 'Likes', value: props.user?.likes_received_count ?? 0 },
  { label: 'Videos', value: props.user?.videos_count ?? 0 }
]);
</script>

<template>
  <section class="profile-summary glass">
    <img v-if="user?.avatar_url" class="profile-summary__avatar" :src="user.avatar_url" :alt="user.name" />
    <div v-else class="profile-summary__avatar">{{ user?.name?.charAt(0) || 'V' }}</div>
    <div>
      <h1>{{ user?.name || 'VIBE Creator' }}</h1>
      <p>{{ user?.handle || '' }}<template v-if="user?.email"> · {{ user.email }}</template></p>
    </div>
    <dl class="profile-summary__stats">
      <div v-for="stat in stats" :key="stat.label">
        <dt>{{ stat.label }}</dt>
        <dd>{{ formatCount(stat.value) }}</dd>
      </div>
    </dl>
  </section>
</template>

<style scoped>
.profile-summary {
  border-radius: var(--radius-xl);
  display: grid;
  gap: var(--space-4);
  padding: var(--space-6);
}

.profile-summary__avatar {
  align-items: center;
  background: linear-gradient(135deg, var(--primary-strong), var(--secondary-strong));
  border-radius: var(--radius-full);
  color: var(--on-vivid);
  display: flex;
  font-size: var(--text-xl);
  font-weight: var(--weight-black);
  height: 92px;
  justify-content: center;
  object-fit: cover;
  width: 92px;
}

.profile-summary h1 {
  margin: 0;
}

.profile-summary p {
  color: var(--on-surface-muted);
  margin: var(--space-1) 0 0;
}

.profile-summary__stats {
  display: grid;
  gap: var(--space-2);
  grid-template-columns: repeat(3, 1fr);
  margin: 0;
}

.profile-summary__stats div {
  background: rgba(255, 255, 255, 0.06);
  border-radius: var(--radius-md);
  padding: var(--space-3);
}

html.light .profile-summary__stats div {
  background: rgba(20, 20, 30, 0.04);
}

.profile-summary dt {
  color: var(--on-surface-muted);
  font-size: var(--text-xs);
  font-weight: var(--weight-black);
  margin-bottom: var(--space-1);
}

.profile-summary dd {
  font-size: var(--text-lg);
  font-weight: var(--weight-black);
  margin: 0;
}
</style>
