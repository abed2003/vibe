<template>
    <div class="rounded-2xl bg-white/5 p-4">
        <p class="text-xl font-extrabold">{{ value }}</p>
        <p class="mt-1 text-xs font-bold uppercase tracking-[0.14em] text-[#c6c4d8]/65">{{ label }}</p>
    </div>
</template>

<script setup>
defineProps({
    label: { type: String, required: true },
    value: { type: String, required: true },
});
</script>
