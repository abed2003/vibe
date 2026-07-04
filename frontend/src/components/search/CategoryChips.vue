<script setup>
defineProps({
  categories: {
    type: Array,
    required: true
  },
  active: {
    type: String,
    required: true
  }
});

defineEmits(['update:active']);
</script>

<template>
  <div class="chips" role="list" aria-label="Categories">
    <button
      v-for="category in categories"
      :key="category"
      class="chips__item"
      :class="{ 'chips__item--active': active === category }"
      type="button"
      @click="$emit('update:active', category)"
    >
      {{ category }}
    </button>
  </div>
</template>

<style scoped>
.chips {
  display: flex;
  gap: 8px;
  overflow-x: auto;
  padding-bottom: 4px;
  scrollbar-width: none;
}

.chips::-webkit-scrollbar {
  display: none;
}

.chips__item {
  background: rgba(255, 255, 255, 0.08);
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 999px;
  color: var(--on-surface-muted);
  cursor: pointer;
  flex: 0 0 auto;
  font-weight: 800;
  min-height: 38px;
  padding: 0 14px;
}

.chips__item--active {
  background: var(--primary-strong);
  color: #fefaff;
}
</style>
