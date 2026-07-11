<template>
    <main class="min-h-screen pb-28 pt-16">
        <AppHeader />
        <section class="mx-auto grid max-w-6xl gap-5 px-4 py-6 md:grid-cols-[360px_1fr]">
            <aside class="glass rounded-3xl p-4">
                <div class="mb-4 flex items-center justify-between">
                    <h1 class="text-2xl font-bold">Messages</h1>
                    <button class="primary-button rounded-full p-3" aria-label="New message"><Icon name="edit_square" :size="20" /></button>
                </div>
                <div class="space-y-2">
                    <button v-for="chat in conversations" :key="chat.id" class="flex w-full items-center gap-3 rounded-2xl p-3 text-left hover:bg-white/7" :class="active.id === chat.id ? 'bg-white/10' : ''" @click="active = chat">
                        <img class="h-12 w-12 rounded-full object-cover" :src="chat.avatar" :alt="chat.name">
                        <span class="min-w-0 flex-1">
                            <span class="block truncate font-bold">{{ chat.name }}</span>
                            <span class="block truncate text-sm text-[#c6c4d8]">{{ chat.preview }}</span>
                        </span>
                        <span class="text-xs font-bold text-[#c6c4d8]/70">{{ chat.time }}</span>
                    </button>
                </div>
            </aside>
            <section class="glass flex min-h-[560px] flex-col rounded-3xl p-4">
                <div class="flex items-center gap-3 border-b border-white/10 pb-4">
                    <img class="h-12 w-12 rounded-full object-cover" :src="active.avatar" :alt="active.name">
                    <div>
                        <h2 class="font-bold">{{ active.name }}</h2>
                        <p class="text-sm text-[#c6c4d8]">{{ active.handle }}</p>
                    </div>
                </div>
                <div class="flex-1 space-y-4 py-5">
                    <p class="max-w-[75%] rounded-3xl rounded-tl-md bg-white/8 p-4 text-[#dfe2eb]">{{ active.preview }}</p>
                    <p class="ml-auto max-w-[75%] rounded-3xl rounded-tr-md bg-[#5b5eff] p-4 font-semibold text-white">Yes. I will send the draft and tag you before posting.</p>
                    <p class="max-w-[75%] rounded-3xl rounded-tl-md bg-white/8 p-4 text-[#dfe2eb]">Perfect, thanks.</p>
                </div>
                <form class="flex gap-2" @submit.prevent>
                    <input class="field" placeholder="Write a message...">
                    <button class="primary-button rounded-2xl px-4 font-bold">Send</button>
                </form>
            </section>
        </section>
        <BottomNav :path="path" />
    </main>
</template>

<script setup>
import { ref } from 'vue';
import { conversations } from '../data';
import AppHeader from '../components/AppHeader.vue';
import BottomNav from '../components/BottomNav.vue';
import Icon from '../components/Icon.vue';

defineProps({ path: { type: String, required: true } });
const active = ref(conversations[0]);
</script>
