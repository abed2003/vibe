<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import VideoActionRail from './VideoActionRail.vue';

const props = defineProps({
  video: {
    type: Object,
    required: true
  },
  compact: {
    type: Boolean,
    default: false
  },
  autoObserve: {
    type: Boolean,
    default: true
  }
});

const mediaEl = ref(null);
const videoEl = ref(null);
const isPlaying = ref(false);
const isMuted = ref(true);
const showMuteHint = ref(false);
let observer = null;

function play() {
  if (!videoEl.value) return;
  videoEl.value.play().catch(() => {});
  isPlaying.value = true;
}

function pause() {
  if (!videoEl.value) return;
  videoEl.value.pause();
  isPlaying.value = false;
}

function toggleSound(event) {
  event.preventDefault();
  event.stopPropagation();
  isMuted.value = !isMuted.value;
  showMuteHint.value = true;
  window.setTimeout(() => {
    showMuteHint.value = false;
  }, 700);
}

onMounted(() => {
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
});
</script>

<template>
  <article class="video-card" :class="{ 'video-card--compact': compact }">
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

    <div v-else ref="mediaEl" class="video-card__media" @click="toggleSound">
      <video
        v-if="video.video"
        ref="videoEl"
        class="video-card__video"
        :poster="video.cover"
        :src="video.video"
        :muted="isMuted"
        loop
        playsinline
        preload="metadata"
      ></video>
      <img v-else :src="video.cover" :alt="video.title" class="video-card__cover" />

      <Transition name="mute-hint">
        <span v-if="showMuteHint" class="video-card__mute-hint material-symbols-outlined">
          {{ isMuted ? 'volume_off' : 'volume_up' }}
        </span>
      </Transition>

      <VideoActionRail :video="video" />
      <div class="video-card__gradient"></div>
      <RouterLink
        class="video-card__meta"
        :to="{ name: 'video-details', params: { id: video.id } }"
        @click.stop
      >
        <div class="video-card__creator">
          <img :src="video.avatar" :alt="video.creator" />
          <div>
            <strong>{{ video.creator }}</strong>
            <span>{{ video.handle }}</span>
          </div>
        </div>
        <h2>{{ video.title }}</h2>
        <p>{{ video.caption }}</p>
        <div class="video-card__tags">
          <span v-for="tag in video.tags" :key="tag">#{{ tag }}</span>
        </div>
      </RouterLink>
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

.video-card__media {
  aspect-ratio: 9 / 16;
  background: var(--surface-low);
  display: block;
  min-height: 560px;
  position: relative;
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

.video-card__mute-hint {
  background: rgba(10, 14, 20, 0.55);
  border-radius: 999px;
  color: #fff;
  font-size: 34px;
  left: 50%;
  padding: 14px;
  position: absolute;
  top: 50%;
  transform: translate(-50%, -50%);
  z-index: 3;
}

.mute-hint-enter-active {
  transition: opacity 120ms ease, transform 120ms ease;
}

.mute-hint-leave-active {
  transition: opacity 320ms ease;
}

.mute-hint-enter-from {
  opacity: 0;
  transform: translate(-50%, -50%) scale(0.7);
}

.mute-hint-leave-to {
  opacity: 0;
}

.video-card__gradient {
  background: linear-gradient(to top, rgba(10, 14, 20, 0.9), rgba(10, 14, 20, 0.2) 55%, transparent);
  inset: 0;
  position: absolute;
}

.video-card__meta {
  bottom: 0;
  display: grid;
  gap: 10px;
  left: 0;
  padding: 22px 72px 24px 18px;
  position: absolute;
  right: 0;
  z-index: 2;
}

.video-card__creator {
  align-items: center;
  display: flex;
  gap: 10px;
}

.video-card__creator img {
  border: 2px solid rgba(255, 255, 255, 0.72);
  border-radius: 999px;
  height: 40px;
  position: static;
  width: 40px;
}

.video-card__creator div {
  display: grid;
}

.video-card__creator span,
.video-card__meta p {
  color: rgba(255, 255, 255, 0.78);
}

.video-card__meta h2 {
  font-size: 22px;
  line-height: 1.18;
  margin: 0;
}

.video-card__meta p {
  margin: 0;
}

.video-card__tags {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
}

.video-card__tags span {
  background: rgba(210, 187, 255, 0.18);
  border-radius: 999px;
  font-size: 12px;
  font-weight: 800;
  padding: 5px 9px;
}

.video-card--compact .video-card__meta {
  padding-right: 18px;
}
</style>
