<script setup>
defineProps({
  user: {
    type: Object,
    default: null
  }
});
</script>

<template>
  <section class="profile-summary glass">
    <div class="profile-summary__avatar">{{ user?.name?.charAt(0) || 'V' }}</div>
    <div>
      <h1>{{ user?.name || 'VIBE Creator' }}</h1>
      <p>{{ user?.email || '@vibecreator' }}</p>
    </div>
    <dl class="profile-summary__stats">
      <div>
        <dt>Followers</dt>
        <dd>128K</dd>
      </div>
      <div>
        <dt>Likes</dt>
        <dd>2.4M</dd>
      </div>
      <div>
        <dt>Videos</dt>
        <dd>86</dd>
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
