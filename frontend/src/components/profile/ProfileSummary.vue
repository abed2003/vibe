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
  gap: 18px;
  padding: 24px;
}

.profile-summary__avatar {
  align-items: center;
  background: linear-gradient(135deg, var(--primary-strong), var(--secondary-strong));
  border-radius: 999px;
  display: flex;
  font-size: 36px;
  font-weight: 800;
  height: 92px;
  justify-content: center;
  width: 92px;
}

.profile-summary h1 {
  margin: 0;
}

.profile-summary p {
  color: var(--on-surface-muted);
  margin: 6px 0 0;
}

.profile-summary__stats {
  display: grid;
  gap: 10px;
  grid-template-columns: repeat(3, 1fr);
  margin: 0;
}

.profile-summary__stats div {
  background: rgba(255, 255, 255, 0.06);
  border-radius: var(--radius-md);
  padding: 12px;
}

.profile-summary dt {
  color: var(--on-surface-muted);
  font-size: 12px;
  font-weight: 800;
  margin-bottom: 4px;
}

.profile-summary dd {
  font-size: 22px;
  font-weight: 800;
  margin: 0;
}
</style>
