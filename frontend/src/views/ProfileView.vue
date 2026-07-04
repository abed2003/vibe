<script setup>
import AppLayout from '../layouts/AppLayout.vue';
import ProfileSummary from '../components/profile/ProfileSummary.vue';
import VideoCard from '../components/feed/VideoCard.vue';
import { useAuthStore } from '../store/auth';
import { sampleVideos } from '../services/feed';

const authStore = useAuthStore();
</script>

<template>
  <AppLayout>
    <section class="profile-view">
      <ProfileSummary :user="authStore.user" />
      <div class="profile-view__grid">
        <VideoCard v-for="video in sampleVideos" :key="video.id" :video="video" compact />
      </div>
    </section>
  </AppLayout>
</template>

<style scoped>
.profile-view {
  display: grid;
  gap: 18px;
}

.profile-view__grid {
  display: grid;
  gap: 14px;
  grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
}
</style>
