<!DOCTYPE html><html class="dark" lang="en"><head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<title>VIBE - Explore</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "tertiary": "#ffb690",
                        "surface-container": "#1c2026",
                        "on-secondary-container": "#c9aeff",
                        "on-primary-fixed": "#06006c",
                        "primary-fixed-dim": "#c0c1ff",
                        "on-secondary-fixed-variant": "#5a00c6",
                        "surface-tint": "#c0c1ff",
                        "on-tertiary-container": "#fffbfa",
                        "on-error": "#690005",
                        "on-secondary-fixed": "#25005a",
                        "error": "#ffb4ab",
                        "secondary-fixed": "#eaddff",
                        "outline-variant": "#454555",
                        "surface-container-highest": "#31353c",
                        "surface-container-high": "#262a31",
                        "surface-variant": "#31353c",
                        "surface-container-low": "#181c22",
                        "tertiary-container": "#bf5400",
                        "outline": "#908fa1",
                        "on-background": "#dfe2eb",
                        "tertiary-fixed-dim": "#ffb690",
                        "on-tertiary": "#542100",
                        "on-surface-variant": "#c6c4d8",
                        "on-primary-container": "#fefaff",
                        "inverse-on-surface": "#2d3137",
                        "inverse-surface": "#dfe2eb",
                        "on-secondary": "#3f008e",
                        "surface-bright": "#353940",
                        "primary-fixed": "#e1e0ff",
                        "primary": "#c0c1ff",
                        "on-primary": "#0f00aa",
                        "on-tertiary-fixed-variant": "#783200",
                        "tertiary-fixed": "#ffdbca",
                        "error-container": "#93000a",
                        "background": "#10141a",
                        "surface-container-lowest": "#0a0e14",
                        "secondary-fixed-dim": "#d2bbff",
                        "secondary": "#d2bbff",
                        "surface-dim": "#10141a",
                        "on-surface": "#dfe2eb",
                        "secondary-container": "#6001d1",
                        "primary-container": "#5b5eff",
                        "on-primary-fixed-variant": "#2723d1",
                        "inverse-primary": "#4345e8",
                        "surface": "#10141a",
                        "on-tertiary-fixed": "#331100",
                        "on-error-container": "#ffdad6"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "md": "16px",
                        "xl": "32px",
                        "gutter": "16px",
                        "sm": "8px",
                        "lg": "24px",
                        "base": "4px",
                        "xs": "4px",
                        "margin-desktop": "120px",
                        "2xl": "48px",
                        "margin-mobile": "16px"
                    },
                    "fontFamily": {
                        "display-lg": ["Inter"],
                        "body-md": ["Inter"],
                        "headline-lg": ["Inter"],
                        "label-sm": ["Inter"],
                        "headline-lg-mobile": ["Inter"],
                        "headline-md": ["Inter"],
                        "body-lg": ["Inter"],
                        "label-md": ["Inter"]
                    },
                    "fontSize": {
                        "display-lg": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.04em", "fontWeight": "800"}],
                        "body-md": ["16px", {"lineHeight": "24px", "letterSpacing": "0em", "fontWeight": "400"}],
                        "headline-lg": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "label-sm": ["12px", {"lineHeight": "16px", "letterSpacing": "0.04em", "fontWeight": "500"}],
                        "headline-lg-mobile": ["28px", {"lineHeight": "34px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "headline-md": ["24px", {"lineHeight": "30px", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                        "body-lg": ["18px", {"lineHeight": "28px", "letterSpacing": "0em", "fontWeight": "400"}],
                        "label-md": ["14px", {"lineHeight": "20px", "letterSpacing": "0.02em", "fontWeight": "600"}]
                    }
                }
            }
        }
    </script>
<style>
        body {
            background-color: #10141a; /* bg-background */
            color: #dfe2eb; /* text-on-background */
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }
        
        /* Hide scrollbar for horizontal scrolling elements */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .masonry-grid {
            column-count: 2;
            column-gap: 16px;
        }
        @media (min-width: 768px) {
            .masonry-grid {
                column-count: 3;
            }
        }
        @media (min-width: 1024px) {
            .masonry-grid {
                column-count: 4;
            }
        }
        .masonry-item {
            break-inside: avoid;
            margin-bottom: 16px;
        }
    </style>
</head>
<body class="bg-background text-on-background min-h-screen flex flex-col pt-[72px] pb-[96px] md:pb-0">
<!-- TopAppBar -->
<header class="bg-transparent text-primary fixed top-0 w-full z-50 backdrop-blur-xl bg-surface/10 border-b border-white/10 shadow-[0px_30px_60px_-15px_rgba(91,94,255,0.15)] flex justify-between items-center px-margin-mobile h-12">
<button class="scale-95 active:scale-90 transition-all duration-200 text-on-surface-variant hover:scale-105">
<span class="material-symbols-outlined">search</span>
</button>
<div class="font-display-lg text-display-lg tracking-tighter bg-clip-text text-transparent bg-gradient-to-r from-primary to-secondary font-headline-lg-mobile text-headline-lg-mobile text-center flex-grow">
            VIBE
        </div>
<button class="scale-95 active:scale-90 transition-all duration-200 text-on-surface-variant hover:scale-105">
<span class="material-symbols-outlined">notifications</span>
</button>
<button class="scale-95 active:scale-90 transition-all duration-200 text-on-surface-variant hover:scale-105 ml-xs">
<span class="material-symbols-outlined">light_mode</span>
</button></header>
<main class="flex-grow w-full max-w-[1200px] mx-auto px-margin-mobile md:px-margin-desktop py-md flex flex-col gap-xl">
<!-- Search & Discovery -->
<section class="flex flex-col gap-md">
<div class="relative w-full">
<div class="absolute inset-y-0 left-0 pl-sm flex items-center pointer-events-none">
<span class="material-symbols-outlined text-on-surface-variant/60">search</span>
</div>
<input class="w-full glass-card rounded-full py-sm pl-[40px] pr-sm text-on-surface bg-transparent focus:outline-none focus:border-primary-container focus:ring-1 focus:ring-primary-container transition-all font-body-md text-body-md placeholder:text-on-surface-variant/50" placeholder="Search creators, videos, vibes..." type="text">
<div class="absolute inset-y-0 right-0 pr-sm flex items-center pointer-events-none">
<span class="material-symbols-outlined text-on-surface-variant/60">mic</span>
</div>
</div>
<!-- Category Chips -->
<div class="flex overflow-x-auto no-scrollbar gap-sm py-xs">
<button class="px-md py-xs rounded-full bg-primary-container/40 text-on-primary-container font-label-md text-label-md whitespace-nowrap border border-white/10 backdrop-blur-md">Trending</button>
<button class="px-md py-xs rounded-full bg-surface-container/60 hover:bg-surface-container-high transition-colors text-on-surface-variant font-label-md text-label-md whitespace-nowrap border border-white/5 backdrop-blur-md">Music</button>
<button class="px-md py-xs rounded-full bg-surface-container/60 hover:bg-surface-container-high transition-colors text-on-surface-variant font-label-md text-label-md whitespace-nowrap border border-white/5 backdrop-blur-md">Gaming</button>
<button class="px-md py-xs rounded-full bg-surface-container/60 hover:bg-surface-container-high transition-colors text-on-surface-variant font-label-md text-label-md whitespace-nowrap border border-white/5 backdrop-blur-md">Fashion</button>
<button class="px-md py-xs rounded-full bg-surface-container/60 hover:bg-surface-container-high transition-colors text-on-surface-variant font-label-md text-label-md whitespace-nowrap border border-white/5 backdrop-blur-md">Comedy</button>
<button class="px-md py-xs rounded-full bg-surface-container/60 hover:bg-surface-container-high transition-colors text-on-surface-variant font-label-md text-label-md whitespace-nowrap border border-white/5 backdrop-blur-md">Art</button>
</div>
</section>
<!-- Trending Videos Grid -->
<section class="flex flex-col gap-sm">
<h2 class="font-headline-md text-headline-md text-on-surface">Trending Now</h2>
<div class="masonry-grid w-full">
<!-- Video Item 1 -->
<div class="masonry-item glass-card rounded-xl overflow-hidden relative group cursor-pointer">
<img class="w-full h-auto object-cover aspect-[9/16] transform group-hover:scale-105 transition-transform duration-500" data-alt="A high-contrast vertical video thumbnail showing a neon-lit cyberpunk street alleyway. Vibrant pinks and cyan blues illuminate the wet pavement. A silhouette of a dancer is mid-motion. The aesthetic is dark, moody, and highly kinetic, matching the VIBE premium brand identity." src="https://lh3.googleusercontent.com/aida-public/AB6AXuCgg91b2z_At2pRAv0GXBHslw5szgYggoY_nvBBWVv5ADKCHv_QdJLWR7Iuj4QICLpFaM1-cX6MqfNUsRQqrD3rgg3pzS3YV0LwhxQvBP5XqCSRDaqILni5BNyQ12XBzgTGIs3G1SgHPcvIysIR3KM3Xkf9LVI_lrRk8aP9ODcvDDUkAY8iHSq90WC-S4XHguoiOjz_olKdkla-X-K2lweX26KXxsgkKQeUwaClReIkVE4-ZBSX2NPJZZgjptwXDu3S4a0xlXifJgM">
<div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-100 flex flex-col justify-end p-sm">
<div class="flex items-center gap-xs mb-xs">
<img class="w-6 h-6 rounded-full object-cover border border-white/20" data-alt="A close-up portrait of an edgy young content creator with neon pink hair against a dark studio background." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBxgeKoJ3bH_8mEOkWBvhhinmhXAL8USab5f-DYPnoTkz-KSWW49h8KzFjUcKZr0X-GIibc9cfrvwh3O1aQR7giBLzKLWwRQv-hpAqYZ_qHVFOxB_sN40OBzW-b97SufEP3JtFaBqZo0l5736zr6xHTaBg9Bn1s9koWyCSF_1hEsS3M7LnmWX7XwFOecOgEVmzRhWFo-e69iWy4_l-bAaYj6HmD5tbM2eYqpnfAnpkB_4qIX9cugC4ivfGZ3JLKI-IzEWbkDxbg62s">
<span class="font-label-sm text-label-sm text-on-surface line-clamp-1">NeonPulse</span>
</div>
<div class="flex items-center gap-xs text-on-surface-variant">
<span class="material-symbols-outlined text-[14px]">visibility</span>
<span class="font-label-sm text-label-sm">1.2M</span>
</div>
</div>
</div>
<!-- Video Item 2 -->
<div class="masonry-item glass-card rounded-xl overflow-hidden relative group cursor-pointer">
<img class="w-full h-auto object-cover aspect-[3/4] transform group-hover:scale-105 transition-transform duration-500" data-alt="A brightly lit vertical video thumbnail featuring a modern minimalist fashion outfit. The subject is wearing structured avant-garde clothing in neutral tones against a stark white studio backdrop. Sharp shadows and high-end editorial lighting emphasize the premium aesthetic." src="https://lh3.googleusercontent.com/aida-public/AB6AXuB-c9YEbeImFxC8lmeoxFuogesgTsI4wrDQx1uxbQbJoG1mBf3zAXpmq4BMVyubOURZnaiiGbYTTbB7qD8kZuoEZBlAfJWMAId161hQo4lGIzmJbmTZQ26M5YVnFCsp9B0rP8k5EV-4M4kMyuia9K3mMb8kiLgWPmsH6pat7UgRSb6VgWeCr1ukOxjuXFGTLgfMwxe95bMXGF4FsS8u90zRMrIO-lJ2Kiw4iw0ezGjM4tRGUQBTc6U6JhPzNSO2S3IrYyO4N3QhMj8">
<div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-100 flex flex-col justify-end p-sm">
<div class="flex items-center gap-xs mb-xs">
<img class="w-6 h-6 rounded-full object-cover border border-white/20" data-alt="A sophisticated portrait of a fashion influencer in soft studio lighting." src="https://lh3.googleusercontent.com/aida-public/AB6AXuB6kQQlx-WHeQmTNFcooNXam2OktAc34V7DOjgoGHw8VJPr0sjLUIkLleo63yDxUBSTb9TeHQC3A8BccN9NLr0rc38tiRfm-301oEohs2qH9yu_cWnurKKqTvSHHctV2CXVZ1TXEHHY2QkqUbxyW7yO6XirwfBGkc7KGydL_ItJKv7o9OGDRE1PoB4Rvk1V6BkznpZ_xugSLXa5ejFEgNz2AcCCGUbectuoNMBqF9IHYt-Zp6YelJsR0tGEfgnSNtMcmBg9vZBHhQ8">
<span class="font-label-sm text-label-sm text-on-surface line-clamp-1">StyleAvant</span>
</div>
<div class="flex items-center gap-xs text-on-surface-variant">
<span class="material-symbols-outlined text-[14px]">visibility</span>
<span class="font-label-sm text-label-sm">850K</span>
</div>
</div>
</div>
<!-- Video Item 3 -->
<div class="masonry-item glass-card rounded-xl overflow-hidden relative group cursor-pointer">
<img class="w-full h-auto object-cover aspect-[4/5] transform group-hover:scale-105 transition-transform duration-500" data-alt="An energetic vertical thumbnail of a live DJ set. Deep indigo and violet laser lights cut through stage fog. A DJ is intensely focused on the deck. The mood is high-energy, immersive, and club-like, perfectly suited for the VIBE platform's dark mode visual language." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDaok4zOsfH0EY0VNuj6h6O4QjqN6mk1FtsL22pN5q280tDfix3kwOKQ9bmwW-wopdoiznupLc-cSZXBQEPlyTKfK6Ss_xoLwN28cDKakmMSHYJG2VE38Bi4_XQmb9DiEOIifR7uQdpdtvwVb0IvIcT4u1VJcQC3ioctIz7AoMlehS5pXEl_M5yDHKtnY-yJuQG46dmVR6P-i6q6FK1uGNxl30NNILssfNMu45mqv8oNZOsCjMB1mx1oQW9S74dwLSyDA5rf4tVv9Y">
<div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-100 flex flex-col justify-end p-sm">
<div class="flex items-center gap-xs mb-xs">
<img class="w-6 h-6 rounded-full object-cover border border-white/20" data-alt="A shadowy portrait of a DJ with a slight violet glow on their face." src="https://lh3.googleusercontent.com/aida-public/AB6AXuAYTyVHadPXr_Z7p6GPLP0DflYOuovk5ND-GkoNxzPupM32GYgjd-TCOIeGj7_MsKGGV4aCj7WCsPtkQzF1dKVjaG1MjyxRfiiKzdk1SOZUBIB53GponHQVPtWIxQ4uYT9XlcHZg0S1EX1NwG7tGBum_BeND69d5oCk6oBymOVwWDnMT5XkP-5WWzNmqe13Q5GJCkWZrKN2Ao1bpsXMDXTUPGSXL7TIm8-R_4obzM1ExmJcMSYCRsXTMPUoTUm252r10W9pHoc4KgI">
<span class="font-label-sm text-label-sm text-on-surface line-clamp-1">DJ_Vortex</span>
</div>
<div class="flex items-center gap-xs text-on-surface-variant">
<span class="material-symbols-outlined text-[14px]">visibility</span>
<span class="font-label-sm text-label-sm">2.1M</span>
</div>
</div>
</div>
<!-- Video Item 4 -->
<div class="masonry-item glass-card rounded-xl overflow-hidden relative group cursor-pointer">
<img class="w-full h-auto object-cover aspect-[9/16] transform group-hover:scale-105 transition-transform duration-500" data-alt="A beautifully composed vertical thumbnail showing a hyper-realistic close-up of artisan coffee being poured. Dark, rich browns and deep blacks dominate the palette, with a soft, ethereal steam rising. The lighting is cinematic, highlighting the texture of the liquid in a premium, tactile manner." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBumPf5uIfPq6EIs5IGDSTYrHa2K8APbho-_-HbIjRjlSOH-Gb82VmToID6HhVO9GBsRRBJs5xba_jKudcLQ1Y3QahF8P3YTruZgOztEGES6tBGE1fspe3_PiFgrUY905TW8oJDbrxcOdgzzwp7aLUSDAMws6NmtaBUGx39FKzONdiRGl8hGR1u5yM_HQiQDE_J1DGjBsnsBIp7iBvib9wFw18ghDJIrOTHUdRhbsPhorGT2upKdn3EwAT8M4dfTp1cZTQS0EQ-qsI">
<div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-100 flex flex-col justify-end p-sm">
<div class="flex items-center gap-xs mb-xs">
<img class="w-6 h-6 rounded-full object-cover border border-white/20" data-alt="A minimalist logo for a coffee aesthetic channel." src="https://lh3.googleusercontent.com/aida-public/AB6AXuCPSgYGkkHJfNOOMmDAv3zmuAE642CQg7oiNZmEfV0T_lpwquKWB_VI_HrwXTsZ-BtorYWXHUtIMebJhsyCrdt7GVryzV1BRTKVnpREMr-YhEwvvbq6RqR1AsA-r0s8jVmqI0DanU6Vy2nk_Kwsu3tDiBbhPtBEiiuu8JXvyDnWA_IAuhMyzmWOWcuT6uZTs8-r2SrHeu3c1OHX1lND7Z5CrLVbXkIOdepMcrrm_rIo7iHR2nEfgIOseIZWERtcldiXhhOlFd1LARQ">
<span class="font-label-sm text-label-sm text-on-surface line-clamp-1">BeanCrafter</span>
</div>
<div class="flex items-center gap-xs text-on-surface-variant">
<span class="material-symbols-outlined text-[14px]">visibility</span>
<span class="font-label-sm text-label-sm">420K</span>
</div>
</div>
</div>
</div>
</section>
</main>
<!-- BottomNavBar (Mobile Only) -->
<nav class="md:hidden bg-surface-container-lowest/20 text-primary font-label-md text-label-md font-display-lg text-display-lg fixed bottom-0 w-full z-50 pb-8 px-4 backdrop-blur-2xl bg-white/10 border border-white/10 rounded-full mb-4 mx-4 shadow-[0px_30px_60px_-15px_rgba(91,94,255,0.2)] flex justify-around items-center h-16 w-[calc(100%-32px)] max-w-md mx-auto">
<button class="flex items-center justify-center text-on-surface-variant/60 hover:text-primary transition-colors active:scale-90 transition-transform duration-150">
<span class="material-symbols-outlined" data-icon="home">home</span>
</button>
<button class="flex items-center justify-center text-primary-fixed-dim scale-110 relative after:content-[''] after:absolute after:-bottom-1 after:w-1 after:h-1 after:bg-primary after:rounded-full hover:text-primary transition-colors active:scale-90 transition-transform duration-150">
<span class="material-symbols-outlined" data-icon="explore">explore</span>
</button>
<button class="flex items-center justify-center text-on-surface-variant/60 hover:text-primary transition-colors active:scale-90 transition-transform duration-150">
<span class="material-symbols-outlined" data-icon="add_circle">add_circle</span>
</button>
<button class="flex items-center justify-center text-on-surface-variant/60 hover:text-primary transition-colors active:scale-90 transition-transform duration-150">
<span class="material-symbols-outlined" data-icon="chat_bubble">chat_bubble</span>
</button>
<button class="flex items-center justify-center text-on-surface-variant/60 hover:text-primary transition-colors active:scale-90 transition-transform duration-150">
<span class="material-symbols-outlined" data-icon="person">person</span>
</button>
</nav>


</body></html>