<script setup>
const model = defineModel({
  type: String,
  default: ''
});
</script>

<template>
  <label class="search-bar glass">
    <span class="material-symbols-outlined">search</span>
    <input v-model="model" type="search" placeholder="Search creators, videos, sounds" />
  </label>
</template>

<style scoped>
.search-bar {
  align-items: center;
  border-radius: var(--radius-full);
  display: flex;
  gap: var(--space-2);
  min-height: 52px;
  padding: 0 var(--space-4);
}

.search-bar input {
  background: transparent;
  border: 0;
  color: var(--on-surface);
  flex: 1;
  min-width: 0;
  outline: 0;
}
</style>
