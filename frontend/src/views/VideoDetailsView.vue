<script setup>
import { computed } from 'vue';
import { useRoute } from 'vue-router';
import AppLayout from '../layouts/AppLayout.vue';
import VideoCard from '../components/feed/VideoCard.vue';
import { sampleVideos } from '../services/feed';

const route = useRoute();
const video = computed(() => sampleVideos.find((item) => item.id === route.params.id) || sampleVideos[0]);
</script>

<template>
  <AppLayout>
    <section class="video-details">
      <VideoCard :video="video" />
      <aside class="video-details__panel glass">
        <h1>{{ video.title }}</h1>
        <p>{{ video.caption }}</p>
        <div class="video-details__stats">
          <span>{{ video.likes }} likes</span>
          <span>{{ video.comments }} comments</span>
          <span>{{ video.shares }} shares</span>
        </div>
        <h2>Comments</h2>
        <article>
          <strong>Ari</strong>
          <p>This whole edit feels expensive in the best way.</p>
        </article>
        <article>
          <strong>Sam</strong>
          <p>The lighting shift at the drop is perfect.</p>
        </article>
      </aside>
    </section>
  </AppLayout>
</template>

<style scoped>
.video-details {
  display: grid;
  gap: 18px;
  margin: 0 auto;
  max-width: 980px;
}

.video-details__panel {
  border-radius: var(--radius-xl);
  display: grid;
  gap: 12px;
  padding: 22px;
}

.video-details__panel h1,
.video-details__panel h2,
.video-details__panel p {
  margin: 0;
}

.video-details__stats {
  color: var(--on-surface-muted);
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  font-weight: 800;
}

.video-details article {
  background: rgba(255, 255, 255, 0.06);
  border-radius: var(--radius-md);
  padding: 12px;
}

@media (min-width: 860px) {
  .video-details {
    grid-template-columns: minmax(300px, 430px) 1fr;
    align-items: start;
  }
}
</style>
