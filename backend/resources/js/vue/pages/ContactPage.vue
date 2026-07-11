<template>
    <main class="min-h-screen pb-28 pt-16">
        <AppHeader />
        <section class="mx-auto max-w-5xl px-4 py-6">
            <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-normal">Contacts</h1>
                    <p class="mt-2 text-[#c6c4d8]">Manage creators, collaborators, and people you message most.</p>
                </div>
                <button class="primary-button inline-flex items-center justify-center gap-2 rounded-full px-5 py-3 font-bold">
                    <Icon name="person_add" /> Add Contact
                </button>
            </div>
            <div class="glass mb-5 flex items-center gap-3 rounded-full px-4 py-3">
                <Icon name="search" class="text-[#c6c4d8]" />
                <input v-model="query" class="w-full bg-transparent outline-none placeholder:text-[#c6c4d8]/55" placeholder="Find contacts...">
            </div>
            <div class="grid gap-4 md:grid-cols-2">
                <article v-for="contact in filtered" :key="contact.handle" class="glass rounded-3xl p-5">
                    <div class="flex items-center gap-4">
                        <img class="h-16 w-16 rounded-full object-cover" :src="contact.avatar" :alt="contact.name">
                        <div class="min-w-0 flex-1">
                            <h2 class="truncate text-xl font-bold">{{ contact.name }}</h2>
                            <p class="text-[#c6c4d8]">{{ contact.handle }} · {{ contact.role }}</p>
                        </div>
                        <span class="rounded-full px-3 py-1 text-xs font-bold" :class="contact.status === 'Online' ? 'bg-emerald-400/15 text-emerald-200' : 'bg-white/8 text-[#c6c4d8]'">{{ contact.status }}</span>
                    </div>
                    <div class="mt-5 flex gap-2">
                        <a class="flex-1 rounded-2xl bg-white/8 px-4 py-3 text-center font-bold hover:bg-white/12" href="/messages">Message</a>
                        <button class="flex-1 rounded-2xl bg-white/8 px-4 py-3 font-bold hover:bg-white/12">Invite</button>
                    </div>
                </article>
            </div>
        </section>
        <BottomNav :path="path" />
    </main>
</template>

<script setup>
import { computed, ref } from 'vue';
import { contacts } from '../data';
import AppHeader from '../components/AppHeader.vue';
import BottomNav from '../components/BottomNav.vue';
import Icon from '../components/Icon.vue';

defineProps({ path: { type: String, required: true } });
const query = ref('');
const filtered = computed(() => {
    const term = query.value.toLowerCase();
    return contacts.filter((contact) => `${contact.name} ${contact.handle} ${contact.role}`.toLowerCase().includes(term));
});
</script>
