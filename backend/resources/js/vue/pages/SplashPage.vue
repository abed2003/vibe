<template>
    <main class="flex min-h-screen flex-col items-center justify-center px-6">
        <div class="glass flex h-24 w-24 items-center justify-center rounded-3xl">
            <Icon name="all_inclusive" fill :size="54" class="text-[#c0c1ff]" />
        </div>
        <h1 class="brand-gradient mt-6 text-6xl font-extrabold tracking-normal">VIBE</h1>
        <p class="mt-2 text-sm font-semibold uppercase tracking-[0.22em] text-[#c6c4d8]/60">Connect your world</p>
        <div class="mt-12 h-1 w-52 overflow-hidden rounded-full bg-white/10">
            <div class="h-full w-1/2 animate-pulse rounded-full bg-[#5b5eff]"></div>
        </div>
    </main>
</template>

<script setup>
import Icon from '../components/Icon.vue';
</script>
