<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import VideoActionRail from './VideoActionRail.vue';
import { useFeedStore } from '../../store/feed';
import { useAuthStore } from '../../store/auth';

const props = defineProps({
  video: {
    type: Object,
    required: true
  },
  compact: {
    type: Boolean,
    default: false
  },
  full: {
    type: Boolean,
    default: false
  },
  autoObserve: {
    type: Boolean,
    default: true
  }
});

const route = useRoute();
const router = useRouter();
const feedStore = useFeedStore();
const authStore = useAuthStore();

const mediaEl = ref(null);
const videoEl = ref(null);
const isPlaying = ref(false);
const progress = ref(0);
const captionExpanded = ref(false);
const bursts = ref([]);
let observer = null;
let tapTimer = null;
let burstId = 0;

function play() {
  const el = videoEl.value;
  if (!el) return;

  el.play().catch(() => {
    // Autoplay with sound is blocked until the user interacts — fall back to muted.
    if (feedStore.muted) return;
    feedStore.setMuted(true);
    el.play().catch(() => {});
  });
}

function pause() {
  const el = videoEl.value;
  if (!el) return;
  el.pause();
  el.currentTime = 0;
}

function togglePlay() {
  const el = videoEl.value;
  if (!el) return;
  if (el.paused) {
    el.play().catch(() => {});
  } else {
    el.pause();
  }
}

function onTap(event) {
  if (tapTimer) {
    window.clearTimeout(tapTimer);
    tapTimer = null;
    onDoubleTap(event);
    return;
  }

  tapTimer = window.setTimeout(() => {
    tapTimer = null;
    togglePlay();
  }, 280);
}

function onDoubleTap(event) {
  // Double-tap liking is a social action — guests go to login instead.
  if (!authStore.isAuthenticated) {
    router.push({ name: 'login', query: { redirect: route.fullPath } });
    return;
  }

  feedStore.like(props.video);

  const target = mediaEl.value?.$el ?? mediaEl.value;
  if (!target) return;
  const rect = target.getBoundingClientRect();
  const x = (event.clientX || rect.left + rect.width / 2) - rect.left;
  const y = (event.clientY || rect.top + rect.height / 2) - rect.top;
  const id = ++burstId;

  bursts.value.push({ id, x, y, rotate: Math.round(Math.random() * 40 - 20) });
  window.setTimeout(() => {
    bursts.value = bursts.value.filter((burst) => burst.id !== id);
  }, 900);

  navigator.vibrate?.(15);
}

function onTimeupdate() {
  const el = videoEl.value;
  progress.value = el && el.duration ? (el.currentTime / el.duration) * 100 : 0;
}

function toggleMute(event) {
  event.preventDefault();
  event.stopPropagation();
  feedStore.setMuted(!feedStore.muted);
}

function toggleCaption(event) {
  event.stopPropagation();
  captionExpanded.value = !captionExpanded.value;
}

onMounted(() => {
  // Seed engagement state from the card's props unless the store already
  // holds fresher (e.g. optimistic) state for this video.
  if (!feedStore.engagement[props.video.id]) {
    feedStore.hydrate(props.video);
  }

  const target = mediaEl.value?.$el ?? mediaEl.value;

  if (!props.autoObserve || !target || !('IntersectionObserver' in window)) {
    if (!props.autoObserve) play();
    return;
  }

  observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting && entry.intersectionRatio > 0.6) {
          play();
        } else {
          pause();
        }
      });
    },
    { threshold: [0, 0.6, 1] }
  );
  observer.observe(target);
});

onBeforeUnmount(() => {
  observer?.disconnect();
  if (tapTimer) window.clearTimeout(tapTimer);
});
</script>

<template>
  <article class="video-card" :class="{ 'video-card--compact': compact, 'video-card--full': full }">
    <RouterLink
      v-if="compact"
      ref="mediaEl"
      :to="{ name: 'video-details', params: { id: video.id } }"
      class="video-card__media"
    >
      <video
        v-if="video.video"
        ref="videoEl"
        class="video-card__video"
        :poster="video.cover"
        :src="video.video"
        muted
        loop
        playsinline
        preload="metadata"
      ></video>
      <img v-else :src="video.cover" :alt="video.title" class="video-card__cover" />
      <div class="video-card__gradient"></div>
    </RouterLink>

    <div v-else ref="mediaEl" class="video-card__media" @click="onTap" @dblclick.prevent>
      <video
        v-if="video.video"
        ref="videoEl"
        class="video-card__video"
        :poster="video.cover"
        :src="video.video"
        :muted="feedStore.muted"
        loop
        playsinline
        preload="metadata"
        @play="isPlaying = true"
        @pause="isPlaying = false"
        @timeupdate="onTimeupdate"
      ></video>
      <img v-else :src="video.cover" :alt="video.title" class="video-card__cover" />

      <span
        v-for="burst in bursts"
        :key="burst.id"
        class="video-card__burst material-symbols-outlined"
        :style="{ left: `${burst.x}px`, top: `${burst.y}px`, '--burst-rotate': `${burst.rotate}deg` }"
        >favorite</span
      >

      <Transition name="center-play">
        <span v-if="!isPlaying && video.video" class="video-card__center material-symbols-outlined">play_arrow</span>
      </Transition>

      <button
        type="button"
        class="video-card__mute"
        :aria-label="feedStore.muted ? 'Unmute' : 'Mute'"
        @click="toggleMute"
      >
        <span class="material-symbols-outlined">{{ feedStore.muted ? 'volume_off' : 'volume_up' }}</span>
      </button>

      <VideoActionRail :video="video" />
      <div class="video-card__gradient"></div>

      <div class="video-card__meta" @click.stop>
        <RouterLink class="video-card__creator" :to="{ name: 'video-details', params: { id: video.id } }">
          <img :src="video.avatar" :alt="video.creator" />
          <div>
            <strong>{{ video.creator }}</strong>
            <span>{{ video.handle }}</span>
          </div>
        </RouterLink>
        <p
          class="video-card__caption"
          :class="{ 'is-clamped': !captionExpanded }"
          role="button"
          tabindex="0"
          @click="toggleCaption"
          @keydown.enter="toggleCaption"
        >
          {{ video.caption }}<template v-if="!captionExpanded">&nbsp;<strong>more</strong></template>
        </p>
        <div class="video-card__tags">
          <span v-for="tag in video.tags" :key="tag">#{{ tag }}</span>
        </div>
        <div v-if="video.music" class="video-card__music">
          <span class="material-symbols-outlined">music_note</span>
          <span class="video-card__music-track">
            <span>{{ video.music }}&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;&nbsp;{{ video.music }}</span>
          </span>
        </div>
      </div>

      <div v-if="video.video" class="video-card__progress">
        <span :style="{ width: `${progress}%` }"></span>
      </div>
    </div>
  </article>
</template>

<style scoped>
.video-card {
  border-radius: var(--radius-xl);
  box-shadow: 0 24px 60px rgba(0, 0, 0, 0.35);
  overflow: hidden;
  position: relative;
}

.video-card--full {
  border-radius: 0;
  box-shadow: none;
  height: 100%;
  width: 100%;
}

.video-card__media {
  aspect-ratio: 9 / 16;
  background: var(--surface-low);
  display: block;
  min-height: 560px;
  position: relative;
  user-select: none;
}

.video-card--full .video-card__media {
  aspect-ratio: auto;
  height: 100%;
  min-height: 0;
}

.video-card--compact .video-card__media {
  min-height: 260px;
}

.video-card__video,
.video-card__cover {
  height: 100%;
  object-fit: cover;
  position: absolute;
  width: 100%;
}

.video-card__burst {
  animation: heart-burst 0.9s var(--ease-out) forwards;
  color: var(--like);
  font-size: 96px;
  font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
  pointer-events: none;
  position: absolute;
  text-shadow: 0 6px 30px rgba(0, 0, 0, 0.45);
  transform: translate(-50%, -50%);
  z-index: 4;
}

@keyframes heart-burst {
  0% {
    opacity: 0;
    transform: translate(-50%, -50%) scale(0) rotate(var(--burst-rotate));
  }
  15% {
    opacity: 1;
    transform: translate(-50%, -50%) scale(1.25) rotate(var(--burst-rotate));
  }
  30% {
    transform: translate(-50%, -50%) scale(0.95) rotate(var(--burst-rotate));
  }
  45% {
    transform: translate(-50%, -50%) scale(1) rotate(var(--burst-rotate));
  }
  100% {
    opacity: 0;
    transform: translate(-50%, -140%) scale(1) rotate(var(--burst-rotate));
  }
}

.video-card__center {
  background: rgba(10, 14, 20, 0.45);
  border-radius: var(--radius-full);
  color: rgba(254, 250, 255, 0.9);
  font-size: 42px;
  left: 50%;
  padding: 18px;
  pointer-events: none;
  position: absolute;
  top: 50%;
  transform: translate(-50%, -50%);
  z-index: 3;
}

.center-play-enter-active {
  transition: opacity var(--duration-fast) var(--ease-out), transform var(--duration-fast) var(--ease-out);
}

.center-play-leave-active {
  transition: opacity var(--duration-base) var(--ease-in), transform var(--duration-base) var(--ease-in);
}

.center-play-enter-from {
  opacity: 0;
  transform: translate(-50%, -50%) scale(0.7);
}

.center-play-leave-to {
  opacity: 0;
  transform: translate(-50%, -50%) scale(1.15);
}

.video-card__mute {
  background: rgba(10, 14, 20, 0.45);
  border: 0;
  border-radius: var(--radius-full);
  color: var(--on-vivid);
  cursor: pointer;
  display: grid;
  padding: 9px;
  place-items: center;
  position: absolute;
  right: 14px;
  top: 14px;
  z-index: 4;
}

.video-card__mute .material-symbols-outlined {
  font-size: 22px;
}

.video-card__gradient {
  background: linear-gradient(to top, var(--scrim-strong), var(--scrim-soft) 55%, transparent);
  inset: 0;
  pointer-events: none;
  position: absolute;
}

.video-card__meta {
  bottom: 0;
  display: grid;
  gap: var(--space-3);
  left: 0;
  padding: var(--space-6) 84px var(--space-6) var(--space-4);
  position: absolute;
  right: 0;
  z-index: 2;
}

.video-card--full .video-card__meta {
  padding-bottom: 96px;
}

.video-card__creator {
  align-items: center;
  display: flex;
  gap: var(--space-3);
}

.video-card__creator img {
  border: 2px solid rgba(255, 255, 255, 0.72);
  border-radius: var(--radius-full);
  height: 40px;
  position: static;
  width: 40px;
}

.video-card__creator div {
  display: grid;
}

.video-card__creator span,
.video-card__caption {
  color: rgba(255, 255, 255, 0.78);
}

.video-card__caption {
  cursor: pointer;
  margin: 0;
}

.video-card__caption strong {
  color: var(--on-vivid);
}

.video-card__caption.is-clamped {
  -webkit-box-orient: vertical;
  display: -webkit-box;
  -webkit-line-clamp: 1;
  overflow: hidden;
}

.video-card__tags {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-2);
}

.video-card__tags span {
  background: var(--tag-bg);
  border-radius: var(--radius-full);
  font-size: var(--text-xs);
  font-weight: var(--weight-black);
  padding: 5px 9px;
  color: var(--on-vivid);
}

.video-card__music {
  align-items: center;
  color: rgba(255, 255, 255, 0.85);
  display: flex;
  font-size: var(--text-xs);
  gap: 6px;
}

.video-card__music .material-symbols-outlined {
  font-size: 16px;
}

.video-card__music-track {
  max-width: 200px;
  overflow: hidden;
  white-space: nowrap;
}

.video-card__music-track span {
  animation: music-ticker 9s linear infinite;
  display: inline-block;
}

@keyframes music-ticker {
  to {
    transform: translateX(-50%);
  }
}

.video-card__progress {
  background: rgba(255, 255, 255, 0.16);
  bottom: 0;
  height: 3px;
  left: 0;
  position: absolute;
  right: 0;
  z-index: 3;
}

.video-card--full .video-card__progress {
  bottom: 76px;
}

.video-card__progress span {
  background: var(--on-vivid);
  display: block;
  height: 100%;
  transition: width 100ms linear;
}

.video-card--compact .video-card__meta {
  padding-right: 18px;
}
</style>
