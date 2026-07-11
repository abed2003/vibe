<template>
    <main class="min-h-screen pb-28 pt-16">
        <AppHeader />
        <section class="mx-auto max-w-6xl px-4 py-6">
            <div class="mb-6">
                <h1 class="text-3xl font-bold tracking-normal">Explore</h1>
                <p class="mt-2 text-[#c6c4d8]">Trending creators, videos, and communities.</p>
            </div>
            <div class="mb-6 flex gap-2 overflow-x-auto pb-1">
                <button v-for="chip in chips" :key="chip" class="rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm font-bold text-[#c6c4d8] first:bg-[#5b5eff]/35 first:text-white hover:text-[#c0c1ff]">{{ chip }}</button>
            </div>
            <div class="columns-2 gap-4 md:columns-3 lg:columns-4">
                <a v-for="video in videos" :key="video.id" :href="`/videos/${video.id}`" class="glass mb-4 block break-inside-avoid overflow-hidden rounded-2xl">
                    <img class="aspect-[9/16] w-full object-cover transition duration-300 hover:scale-[1.03]" :src="video.image" :alt="video.title">
                    <div class="p-3">
                        <div class="flex items-center gap-2">
                            <img class="h-7 w-7 rounded-full object-cover" :src="video.avatar" :alt="video.creator">
                            <span class="truncate text-sm font-bold">{{ video.creator }}</span>
                        </div>
                        <p class="mt-2 line-clamp-2 text-sm text-[#c6c4d8]">{{ video.title }}</p>
                        <div class="mt-2 flex items-center gap-1 text-xs font-bold text-[#c6c4d8]/70">
                            <Icon name="visibility" :size="16" /> {{ video.views }}
                        </div>
                    </div>
                </a>
            </div>
        </section>
        <BottomNav :path="path" />
    </main>
</template>

<script setup>
import { videos } from '../data';
import AppHeader from '../components/AppHeader.vue';
import BottomNav from '../components/BottomNav.vue';
import Icon from '../components/Icon.vue';

defineProps({ path: { type: String, required: true } });
const chips = ['Trending', 'Music', 'Gaming', 'Fashion', 'Comedy', 'Art', 'Travel'];
</script>
