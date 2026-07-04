<script setup>
defineProps({
  video: {
    type: Object,
    required: true
  }
});
</script>

<template>
  <aside class="action-rail" aria-label="Video actions">
    <button type="button">
      <span class="material-symbols-outlined">favorite</span>
      <strong>{{ video.likes }}</strong>
    </button>
    <button type="button">
      <span class="material-symbols-outlined">mode_comment</span>
      <strong>{{ video.comments }}</strong>
    </button>
    <button type="button">
      <span class="material-symbols-outlined">ios_share</span>
      <strong>{{ video.shares }}</strong>
    </button>
  </aside>
</template>

<style scoped>
.action-rail {
  display: grid;
  gap: 16px;
  position: absolute;
  right: 14px;
  top: 42%;
  z-index: 2;
}

.action-rail button {
  align-items: center;
  background: transparent;
  border: 0;
  color: white;
  cursor: pointer;
  display: grid;
  gap: 4px;
  justify-items: center;
  text-shadow: 0 2px 6px rgba(0, 0, 0, 0.5);
}

.action-rail .material-symbols-outlined {
  background: rgba(0, 0, 0, 0.22);
  border-radius: 999px;
  font-size: 30px;
  padding: 9px;
}

.action-rail strong {
  font-size: 12px;
}
</style>
