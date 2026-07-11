<template>
    <main class="phone-shell">
        <AppHeader />
        <section class="relative h-[100dvh]">
            <img class="absolute inset-0 h-full w-full object-cover" :src="video.image" :alt="video.title">
            <div class="absolute inset-0 bg-gradient-to-t from-[#10141a]/95 via-[#10141a]/25 to-[#10141a]/25"></div>
            <div class="absolute top-20 flex w-full justify-center gap-8 text-shadow">
                <button class="text-lg font-semibold text-[#c6c4d8]/70">Following</button>
                <button class="relative text-lg font-bold text-white after:absolute after:-bottom-2 after:left-1/2 after:h-1 after:w-5 after:-translate-x-1/2 after:rounded-full after:bg-[#c0c1ff]">For You</button>
            </div>
            <aside class="absolute bottom-32 right-4 z-10 flex flex-col items-center gap-5 text-shadow">
                <img class="h-12 w-12 rounded-full border-2 border-[#c0c1ff] object-cover" :src="video.avatar" :alt="video.creator">
                <Action icon="favorite" :label="video.likes" fill />
                <Action icon="comment" :label="video.comments" />
                <Action icon="bookmark" label="8.3k" />
                <Action icon="share" label="Share" />
            </aside>
            <section class="absolute bottom-28 left-4 right-20 z-10 text-shadow">
                <div class="flex items-center gap-3">
                    <h1 class="text-xl font-bold">@{{ video.creator }}</h1>
                    <button class="rounded-full bg-white/10 px-3 py-1 text-sm font-bold backdrop-blur">Follow</button>
                </div>
                <p class="mt-3 leading-6 text-white/90">{{ video.title }} #{{ video.category.toLowerCase() }} #vibe</p>
                <div class="mt-4 inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/10 px-3 py-2 text-sm backdrop-blur">
                    <Icon name="music_note" class="text-[#c0c1ff]" :size="18" />
                    Neon Lights - Original Sound
                </div>
            </section>
            <BottomNav :path="path" />
        </section>
    </main>
</template>

<script setup>
import { videos } from '../data';
import AppHeader from '../components/AppHeader.vue';
import BottomNav from '../components/BottomNav.vue';
import Icon from '../components/Icon.vue';
import Action from './partials/Action.vue';

defineProps({ path: { type: String, required: true } });
const video = videos[0];
</script>
