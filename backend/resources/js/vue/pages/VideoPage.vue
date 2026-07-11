<template>
    <main class="min-h-screen pb-28 pt-16">
        <AppHeader />
        <section class="mx-auto grid max-w-5xl gap-6 px-4 py-6 md:grid-cols-[minmax(260px,420px)_1fr]">
            <div class="glass overflow-hidden rounded-3xl">
                <img class="aspect-[9/16] w-full object-cover" :src="video.image" :alt="video.title">
            </div>
            <div class="flex flex-col gap-4">
                <div class="glass rounded-3xl p-5">
                    <div class="flex items-center gap-3">
                        <img class="h-14 w-14 rounded-full object-cover" :src="video.avatar" :alt="video.creator">
                        <div>
                            <h1 class="text-2xl font-bold">@{{ video.creator }}</h1>
                            <p class="text-[#c6c4d8]">{{ video.category }} creator</p>
                        </div>
                    </div>
                    <p class="mt-5 text-lg leading-8">{{ video.title }}</p>
                    <div class="mt-5 grid grid-cols-3 gap-3 text-center">
                        <Stat label="Likes" :value="video.likes" />
                        <Stat label="Comments" :value="video.comments" />
                        <Stat label="Views" :value="video.views" />
                    </div>
                </div>
                <div class="glass rounded-3xl p-5">
                    <h2 class="text-xl font-bold">Comments</h2>
                    <div class="mt-4 space-y-4">
                        <p v-for="comment in comments" :key="comment.name" class="rounded-2xl bg-white/5 p-4 text-[#c6c4d8]"><strong class="text-white">{{ comment.name }}</strong> {{ comment.text }}</p>
                    </div>
                    <div class="mt-4 flex gap-2">
                        <input class="field" placeholder="Add a comment">
                        <button class="primary-button rounded-2xl px-4 font-bold">Send</button>
                    </div>
                </div>
            </div>
        </section>
        <BottomNav :path="path" />
    </main>
</template>

<script setup>
import { computed } from 'vue';
import { videos } from '../data';
import AppHeader from '../components/AppHeader.vue';
import BottomNav from '../components/BottomNav.vue';
import Stat from './partials/Stat.vue';

const props = defineProps({ path: { type: String, required: true } });
const slug = computed(() => props.path.split('/').filter(Boolean)[1]);
const video = computed(() => videos.find((item) => item.id === slug.value) || videos[0]);
const comments = [
    { name: 'Maya', text: 'The lighting is perfect on this one.' },
    { name: 'Ava', text: 'Saving this for the next edit.' },
    { name: 'Leo', text: 'Drop the full sound soon.' },
];
</script>
