<template>
    <main class="flex min-h-screen items-center justify-center px-4 py-10">
        <section class="grid w-full max-w-6xl items-center gap-8 md:grid-cols-2">
            <div class="relative mx-auto aspect-[4/5] w-full max-w-md overflow-hidden rounded-3xl p-2 glass">
                <img class="h-full w-full rounded-2xl object-cover" src="https://images.unsplash.com/photo-1516280440614-37939bbacd81?auto=format&fit=crop&w=900&q=80" alt="Creators filming vertical video">
                <div class="absolute inset-x-2 bottom-2 rounded-b-2xl bg-gradient-to-t from-[#10141a] to-transparent p-5 pt-28">
                    <div class="flex items-center justify-between">
                        <span class="rounded-full bg-white/10 px-3 py-1 text-sm font-semibold text-[#dfe2eb] backdrop-blur">Live creators</span>
                        <span class="rounded-full bg-[#5b5eff] px-3 py-1 text-sm font-semibold text-white">24k watching</span>
                    </div>
                </div>
            </div>
            <div class="mx-auto w-full max-w-md text-center md:text-left">
                <p class="brand-gradient text-6xl font-extrabold tracking-normal">VIBE</p>
                <h1 class="mt-4 text-4xl font-bold tracking-normal text-[#dfe2eb]">Express yourself in motion.</h1>
                <p class="mt-4 text-lg leading-8 text-[#c6c4d8]">A premium vertical video experience for creators, messages, contacts, discovery, and everyday social connection.</p>
                <div class="mt-8 flex flex-col gap-3">
                    <a class="primary-button rounded-full px-6 py-4 text-center font-bold" href="/register">Get Started</a>
                    <a class="glass rounded-full px-6 py-4 text-center font-bold text-[#c0c1ff]" href="/login">Login</a>
                    <a class="py-2 text-center text-sm font-semibold text-[#c6c4d8]/70 hover:text-[#c0c1ff]" href="/feed">Continue as Guest</a>
                </div>
            </div>
        </section>
    </main>
</template>
