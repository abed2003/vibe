<template>
    <header class="fixed inset-x-0 top-0 z-40 mx-auto flex h-14 max-w-[430px] items-center justify-between border-b border-white/10 bg-[#10141a]/30 px-4 backdrop-blur-2xl">
        <a class="rounded-full p-2 text-[#c6c4d8] hover:text-[#c0c1ff]" href="/search" aria-label="Search">
            <Icon name="search" />
        </a>
        <a href="/feed" class="brand-gradient text-2xl font-extrabold tracking-normal">VIBE</a>
        <div class="flex items-center gap-2">
            <a class="rounded-full p-2 text-[#c6c4d8] hover:text-[#c0c1ff]" href="/messages" aria-label="Messages">
                <Icon name="chat_bubble" />
            </a>
            <a class="rounded-full p-2 text-[#c6c4d8] hover:text-[#c0c1ff]" href="/contact" aria-label="Contacts">
                <Icon name="contacts" />
            </a>
        </div>
    </header>
</template>

<script setup>
import Icon from './Icon.vue';
</script>
