<template>
    <main class="min-h-screen pb-28 pt-16">
        <AppHeader />
        <section class="mx-auto max-w-4xl px-4 py-6">
            <div class="glass flex items-center gap-3 rounded-full px-4 py-3">
                <Icon name="search" class="text-[#c6c4d8]" />
                <input v-model="query" class="w-full bg-transparent outline-none placeholder:text-[#c6c4d8]/55" placeholder="Search creators, videos, vibes...">
                <Icon name="mic" class="text-[#c6c4d8]" />
            </div>
            <div class="mt-8 grid gap-4 md:grid-cols-2">
                <a v-for="video in filtered" :key="video.id" :href="`/videos/${video.id}`" class="glass flex gap-4 rounded-2xl p-3">
                    <img class="h-28 w-20 rounded-xl object-cover" :src="video.image" :alt="video.title">
                    <div class="min-w-0">
                        <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#c0c1ff]">{{ video.category }}</p>
                        <h2 class="mt-1 line-clamp-2 font-bold">{{ video.title }}</h2>
                        <p class="mt-2 text-sm text-[#c6c4d8]">@{{ video.creator }} · {{ video.views }} views</p>
                    </div>
                </a>
            </div>
        </section>
        <BottomNav :path="path" />
    </main>
</template>

<script setup>
import { computed, ref } from 'vue';
import { videos } from '../data';
import AppHeader from '../components/AppHeader.vue';
import BottomNav from '../components/BottomNav.vue';
import Icon from '../components/Icon.vue';

defineProps({ path: { type: String, required: true } });
const query = ref('');
const filtered = computed(() => {
    const term = query.value.toLowerCase();
    if (!term) return videos;
    return videos.filter((video) => `${video.title} ${video.creator} ${video.category}`.toLowerCase().includes(term));
});
</script>
