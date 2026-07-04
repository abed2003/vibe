<script setup>
import VideoActionRail from './VideoActionRail.vue';

defineProps({
  video: {
    type: Object,
    required: true
  },
  compact: {
    type: Boolean,
    default: false
  }
});
</script>

<template>
  <article class="video-card" :class="{ 'video-card--compact': compact }">
    <RouterLink :to="{ name: 'video-details', params: { id: video.id } }" class="video-card__media">
      <img :src="video.cover" :alt="video.title" />
      <VideoActionRail v-if="!compact" :video="video" />
      <div class="video-card__gradient"></div>
      <div class="video-card__meta">
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
      </div>
    </RouterLink>
  </article>
</template>

<style scoped>
.video-card {
  border-radius: var(--radius-xl);
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

.video-card__media img {
  height: 100%;
  object-fit: cover;
  position: absolute;
  width: 100%;
}

.video-card__gradient {
  background: linear-gradient(to top, rgba(10, 14, 20, 0.88), rgba(10, 14, 20, 0.16), transparent);
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
