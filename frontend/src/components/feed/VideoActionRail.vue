<script setup>
import { ref, computed } from 'vue';
import { useRouter } from 'vue-router';
import { useUiStore } from '../../store/ui';

const props = defineProps({
  video: {
    type: Object,
    required: true
  }
});

const router = useRouter();
const uiStore = useUiStore();

const liked = ref(false);
const saved = ref(false);

const likeCount = computed(() => bump(props.video.likes, liked.value));

function bump(value, active) {
  if (!active) return value;
  const match = /^([\d.]+)([A-Za-z]*)$/.exec(String(value).trim());
  if (!match) return value;
  const [, num, suffix] = match;
  return `${(Number(num) + (suffix ? 0.1 : 1)).toFixed(suffix ? 1 : 0)}${suffix}`;
}

function toggleLike(event) {
  event.preventDefault();
  event.stopPropagation();
  liked.value = !liked.value;
}

function toggleSave(event) {
  event.preventDefault();
  event.stopPropagation();
  saved.value = !saved.value;
  uiStore.notify({
    type: 'success',
    message: saved.value ? 'Saved to your collection.' : 'Removed from your collection.'
  });
}

function openComments(event) {
  event.preventDefault();
  event.stopPropagation();
  router.push({ name: 'video-details', params: { id: props.video.id }, hash: '#comments' });
}

async function share(event) {
  event.preventDefault();
  event.stopPropagation();

  const shareUrl = `${window.location.origin}/videos/${props.video.id}`;

  if (navigator.share) {
    try {
      await navigator.share({ title: props.video.title, url: shareUrl });
    } catch {
      /* user cancelled */
    }
    return;
  }

  try {
    await navigator.clipboard.writeText(shareUrl);
    uiStore.notify({ type: 'success', message: 'Link copied to clipboard.' });
  } catch {
    uiStore.notify({ type: 'error', message: 'Could not copy link.' });
  }
}
</script>

<template>
  <aside class="action-rail" aria-label="Video actions">
    <button type="button" class="action-rail__like" :class="{ 'is-active': liked }" @click="toggleLike">
      <span class="material-symbols-outlined">{{ liked ? 'favorite' : 'favorite_border' }}</span>
      <strong>{{ likeCount }}</strong>
    </button>
    <button type="button" @click="openComments">
      <span class="material-symbols-outlined">mode_comment</span>
      <strong>{{ video.comments }}</strong>
    </button>
    <button type="button" @click="share">
      <span class="material-symbols-outlined">ios_share</span>
      <strong>{{ video.shares }}</strong>
    </button>
    <button type="button" class="action-rail__save" :class="{ 'is-active': saved }" @click="toggleSave">
      <span class="material-symbols-outlined">{{ saved ? 'bookmark' : 'bookmark_border' }}</span>
    </button>
  </aside>
</template>

<style scoped>
.action-rail {
  display: grid;
  gap: var(--space-5);
  position: absolute;
  right: 14px;
  top: 38%;
  z-index: 3;
}

.action-rail button {
  align-items: center;
  background: transparent;
  border: 0;
  border-radius: var(--radius-full);
  color: var(--on-vivid);
  cursor: pointer;
  display: grid;
  gap: 4px;
  justify-items: center;
  text-shadow: 0 2px 6px rgba(0, 0, 0, 0.5);
}

.action-rail .material-symbols-outlined {
  background: rgba(0, 0, 0, 0.28);
  border-radius: var(--radius-full);
  font-size: 30px;
  padding: 9px;
  transition: transform var(--duration-base) var(--ease-standard), background var(--duration-base) var(--ease-standard), color var(--duration-base) var(--ease-standard);
}

.action-rail button:active .material-symbols-outlined {
  transform: scale(0.85);
}

.action-rail strong {
  font-size: var(--text-xs);
  font-weight: var(--weight-black);
}

.action-rail__like.is-active .material-symbols-outlined {
  background: rgba(255, 76, 106, 0.22);
  color: var(--like);
}

.action-rail__save.is-active .material-symbols-outlined {
  background: rgba(192, 193, 255, 0.24);
  color: var(--accent-vivid);
}
</style>
