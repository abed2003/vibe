<script setup>
import { computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useUiStore } from '../../store/ui';
import { useFeedStore } from '../../store/feed';
import { useAuthStore } from '../../store/auth';
import { formatCount } from '../../services/videos';

const props = defineProps({
  video: {
    type: Object,
    required: true
  }
});

const route = useRoute();
const router = useRouter();
const uiStore = useUiStore();
const feedStore = useFeedStore();
const authStore = useAuthStore();

const engagement = computed(() => feedStore.stateFor(props.video));
const isOwnVideo = computed(() => authStore.user?.id && authStore.user.id === props.video.creatorId);

const likePending = computed(() => Boolean(feedStore.pending[`like:${props.video.id}`]));
const savePending = computed(() => Boolean(feedStore.pending[`save:${props.video.id}`]));
const followPending = computed(() => Boolean(feedStore.pending[`follow:${props.video.creatorId}`]));

/** Social actions require an account; guests are routed to login. */
function requireAuth() {
  if (authStore.isAuthenticated) return true;
  router.push({ name: 'login', query: { redirect: route.fullPath } });
  return false;
}

function toggleLike(event) {
  event.preventDefault();
  event.stopPropagation();
  if (requireAuth()) feedStore.toggleLike(props.video);
}

async function toggleFollow(event) {
  event.preventDefault();
  event.stopPropagation();
  if (!requireAuth()) return;

  const following = await feedStore.toggleFollow(props.video);
  uiStore.notify({
    type: 'success',
    message: following ? `Following ${props.video.handle}` : `Unfollowed ${props.video.handle}`
  });
}

async function toggleSave(event) {
  event.preventDefault();
  event.stopPropagation();
  if (!requireAuth()) return;

  const saved = await feedStore.toggleSave(props.video);
  uiStore.notify({
    type: 'success',
    message: saved ? 'Saved to your collection.' : 'Removed from your collection.'
  });
}

function openComments(event) {
  event.preventDefault();
  event.stopPropagation();
  feedStore.openComments(props.video.id);
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
    <div class="action-rail__creator">
      <img v-if="video.avatar" :src="video.avatar" :alt="video.creator" />
      <span v-else class="action-rail__initial">{{ video.creator.charAt(0) }}</span>
      <button
        v-if="!isOwnVideo"
        type="button"
        class="action-rail__follow"
        :class="{ 'is-active': engagement.following }"
        :disabled="followPending"
        :aria-label="engagement.following ? `Following ${video.handle}` : `Follow ${video.handle}`"
        @click="toggleFollow"
      >
        <span class="material-symbols-outlined">{{ engagement.following ? 'check' : 'add' }}</span>
      </button>
    </div>
    <button
      type="button"
      class="action-rail__like"
      :class="{ 'is-active': engagement.liked }"
      :disabled="likePending"
      @click="toggleLike"
    >
      <span class="material-symbols-outlined">favorite</span>
      <strong>{{ formatCount(engagement.likesCount) }}</strong>
    </button>
    <button type="button" @click="openComments">
      <span class="material-symbols-outlined">mode_comment</span>
      <strong>{{ formatCount(engagement.commentsCount) }}</strong>
    </button>
    <button type="button" @click="share">
      <span class="material-symbols-outlined">ios_share</span>
      <strong>{{ formatCount(video.views) }}</strong>
    </button>
    <button
      type="button"
      class="action-rail__save"
      :class="{ 'is-active': engagement.saved }"
      :disabled="savePending"
      @click="toggleSave"
    >
      <span class="material-symbols-outlined">{{ engagement.saved ? 'bookmark' : 'bookmark_border' }}</span>
    </button>
  </aside>
</template>

<style scoped>
.action-rail {
  display: grid;
  gap: var(--space-5);
  position: absolute;
  right: 14px;
  top: 34%;
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

.action-rail button:disabled {
  cursor: default;
  opacity: 0.6;
}

.action-rail__creator {
  margin-bottom: var(--space-2);
  position: relative;
}

.action-rail__creator img,
.action-rail__initial {
  border: 2px solid rgba(255, 255, 255, 0.85);
  border-radius: var(--radius-full);
  height: 48px;
  width: 48px;
}

.action-rail__initial {
  align-items: center;
  background: linear-gradient(135deg, var(--primary-strong), var(--secondary-strong));
  display: flex;
  font-weight: var(--weight-black);
  justify-content: center;
}

.action-rail__follow {
  background: var(--like);
  border-radius: var(--radius-full);
  bottom: -9px;
  display: grid;
  height: 22px;
  left: 50%;
  padding: 0;
  place-items: center;
  position: absolute;
  transform: translateX(-50%);
  transition: background var(--duration-base) var(--ease-standard), transform var(--duration-base) var(--ease-standard);
  width: 22px;
}

.action-rail__follow .material-symbols-outlined {
  font-size: 16px;
  font-variation-settings: 'wght' 600;
}

.action-rail__follow.is-active {
  background: rgba(255, 255, 255, 0.9);
}

.action-rail__follow.is-active .material-symbols-outlined {
  color: var(--like);
  text-shadow: none;
}

.action-rail__follow:active {
  transform: translateX(-50%) scale(0.85);
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
  animation: like-pop 0.35s var(--ease-out);
  background: rgba(255, 76, 106, 0.22);
  color: var(--like);
  font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
}

@keyframes like-pop {
  0% {
    transform: scale(1);
  }
  40% {
    transform: scale(1.35);
  }
  100% {
    transform: scale(1);
  }
}

.action-rail__save.is-active .material-symbols-outlined {
  background: rgba(192, 193, 255, 0.24);
  color: var(--accent-vivid);
}
</style>
