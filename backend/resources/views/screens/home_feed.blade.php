<!DOCTYPE html><html class="dark" lang="en"><head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<title>VIBE - Feed</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com" rel="preconnect">
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
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
                    "display-lg": [
                            "Inter"
                    ],
                    "body-md": [
                            "Inter"
                    ],
                    "headline-lg": [
                            "Inter"
                    ],
                    "label-sm": [
                            "Inter"
                    ],
                    "headline-lg-mobile": [
                            "Inter"
                    ],
                    "headline-md": [
                            "Inter"
                    ],
                    "body-lg": [
                            "Inter"
                    ],
                    "label-md": [
                            "Inter"
                    ]
            },
            "fontSize": {
                    "display-lg": [
                            "48px",
                            {
                                    "lineHeight": "56px",
                                    "letterSpacing": "-0.04em",
                                    "fontWeight": "800"
                            }
                    ],
                    "body-md": [
                            "16px",
                            {
                                    "lineHeight": "24px",
                                    "letterSpacing": "0em",
                                    "fontWeight": "400"
                            }
                    ],
                    "headline-lg": [
                            "32px",
                            {
                                    "lineHeight": "40px",
                                    "letterSpacing": "-0.02em",
                                    "fontWeight": "700"
                            }
                    ],
                    "label-sm": [
                            "12px",
                            {
                                    "lineHeight": "16px",
                                    "letterSpacing": "0.04em",
                                    "fontWeight": "500"
                            }
                    ],
                    "headline-lg-mobile": [
                            "28px",
                            {
                                    "lineHeight": "34px",
                                    "letterSpacing": "-0.02em",
                                    "fontWeight": "700"
                            }
                    ],
                    "headline-md": [
                            "24px",
                            {
                                    "lineHeight": "30px",
                                    "letterSpacing": "-0.01em",
                                    "fontWeight": "600"
                            }
                    ],
                    "body-lg": [
                            "18px",
                            {
                                    "lineHeight": "28px",
                                    "letterSpacing": "0em",
                                    "fontWeight": "400"
                            }
                    ],
                    "label-md": [
                            "14px",
                            {
                                    "lineHeight": "20px",
                                    "letterSpacing": "0.02em",
                                    "fontWeight": "600"
                            }
                    ]
            }
    },
        },
      }
    </script>
<style>
        .spin-slow {
            animation: spin 4s linear infinite;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .text-shadow {
            text-shadow: 0 2px 4px rgba(0,0,0,0.5);
        }
    </style>
</head>
<body class="bg-background text-on-surface font-body-md text-body-md antialiased overflow-hidden selection:bg-primary-container selection:text-on-primary-container">
<!-- Main Container representing device screen -->
<main class="relative w-full h-[100dvh] max-w-md mx-auto bg-surface flex flex-col shadow-2xl overflow-hidden">
<!-- Video Background Canvas -->
<div class="absolute inset-0 z-0">
<div class="w-full h-full bg-cover bg-center" data-alt="A cinematic, high-energy vertical video frame capturing a neon-lit cyberpunk city street at night. A highly stylized individual is captured mid-motion dancing energetically. High contrast lighting with vibrant primary purple and deep blue neon lights reflecting beautifully off a wet, rain-slicked pavement. The overall mood is immersive, dynamic, and exhibits a premium, hyper-refined aesthetic suitable for a high-end social media platform." style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDNyxOaRkWFn_CQ93iIJRovyMLL5rGdyRB7YYnNF8UAdOE6zYMs57f16s0-Y7e4WKCmQb2Q1bbgow9WX499ZWSzLsut_vcfR-H98JYURyClWvEX2rzM5MWSgo1_c41wp40IHBsPdrJXOVA9LUJinTfkBKHZIjzlMpUdqI76Wx4ldUHOAwLDB9yAZ1b5P5lkJRAdqUuwNgOmwwDO9hIyBOm3ISgOckeDp8azkfWNMorNOctuHV3NuIgrZoJxyoFV5vncxsKcSGehsIk')"></div>
<!-- Bottom Gradient Overlay for text readability -->
<div class="absolute bottom-0 left-0 right-0 h-1/2 bg-gradient-to-t from-background/90 via-background/40 to-transparent pointer-events-none"></div>
</div>
<!-- TopAppBar (from JSON) -->
<header class="fixed top-0 w-full max-w-md mx-auto z-50 backdrop-blur-xl bg-surface/10 border-b border-white/10 shadow-[0px_30px_60px_-15px_rgba(91,94,255,0.15)] flex justify-between items-center px-margin-mobile h-12">
<button class="text-on-surface-variant hover:scale-105 transition-transform scale-95 active:scale-90 transition-all duration-200 flex items-center justify-center p-2 rounded-full backdrop-blur-md bg-white/5 border border-white/10">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">search</span>
</button>
<h1 class="font-display-lg text-display-lg tracking-tighter bg-clip-text text-transparent bg-gradient-to-r from-primary to-secondary text-2xl leading-none pt-1">
                VIBE
            </h1>
<button class="text-on-surface-variant hover:scale-105 transition-transform scale-95 active:scale-90 transition-all duration-200 flex items-center justify-center p-2 rounded-full backdrop-blur-md bg-white/5 border border-white/10">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">notifications</span>
</button>
<button class="text-on-surface-variant hover:scale-105 transition-transform scale-95 active:scale-90 transition-all duration-200 flex items-center justify-center p-2 rounded-full backdrop-blur-md bg-white/5 border border-white/10 ml-2">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">light_mode</span>
</button></header>
<!-- Feed Tabs (For You / Following) -->
<div class="absolute top-16 w-full z-40 flex justify-center space-x-6 px-4 text-shadow">
<button class="font-headline-md text-headline-md text-on-surface-variant opacity-70 hover:opacity-100 transition-opacity drop-shadow-md text-lg">Following</button>
<button class="font-headline-md text-headline-md text-on-surface relative after:content-[''] after:absolute after:-bottom-1.5 after:left-1/2 after:-translate-x-1/2 after:w-4 after:h-1 after:bg-primary after:rounded-full drop-shadow-md text-lg">For You</button>
</div>
<!-- Right Side Floating Actions -->
<aside class="absolute right-4 bottom-32 z-30 flex flex-col items-center space-y-6">
<!-- Profile Avatar with Plus -->
<div class="relative group cursor-pointer hover:scale-105 transition-transform duration-200">
<div class="w-12 h-12 rounded-full p-[2px] bg-gradient-to-tr from-primary to-secondary">
<img class="w-full h-full rounded-full object-cover border-2 border-background" data-alt="A macro, high-resolution portrait photograph of a stylish young creator with neon rim lighting highlighting their features. The aesthetic is high fashion and deeply premium, heavily utilizing dark moody undertones punctuated by bright energetic highlights." src="https://lh3.googleusercontent.com/aida-public/AB6AXuC3nN86kMoy_JHiEWT6ncXKk8RgdeClmXh6J2CdJoHy5dAWNme2Z2KAyZLeZ4gEBRxkfUhaNfT02m92MWD6xqhs0NJyHynCs6ffeIrfg_b_yVt36s925QqAf2P7Z9RxzVZsa-eFY1NxeZMMOqG4JEFYYS7aKXQlQ0XPDFQcL5wek-pQisKHvtqQBO_gAGF8ODqkhUrpoWKRM7o4P-U5wKVZ1xkhBuU-j0K2VqH1_inrTuvDtAQmNZ_RWVBUO_LmdBS9KIBIy4KzvKQ">
</div>
<button class="absolute -bottom-2 left-1/2 -translate-x-1/2 w-5 h-5 bg-primary text-on-primary rounded-full flex items-center justify-center text-[10px] font-bold border-2 border-background shadow-lg">
<span class="material-symbols-outlined" style="font-size: 14px;">add</span>
</button>
</div>
<!-- Like Action -->
<button class="flex flex-col items-center group scale-95 active:scale-90 transition-all duration-200">
<div class="w-10 h-10 rounded-full backdrop-blur-2xl bg-white/10 border border-white/20 flex items-center justify-center mb-1 group-hover:bg-white/20 transition-colors shadow-[0_0_15px_rgba(91,94,255,0.2)]">
<span class="material-symbols-outlined text-on-surface" style="font-variation-settings: 'FILL' 1;">favorite</span>
</div>
<span class="font-label-sm text-label-sm text-on-surface text-shadow">124k</span>
</button>
<!-- Comment Action -->
<button class="flex flex-col items-center group scale-95 active:scale-90 transition-all duration-200">
<div class="w-10 h-10 rounded-full backdrop-blur-2xl bg-white/10 border border-white/20 flex items-center justify-center mb-1 group-hover:bg-white/20 transition-colors shadow-[0_0_15px_rgba(91,94,255,0.2)]">
<span class="material-symbols-outlined text-on-surface" style="font-variation-settings: 'FILL' 0;">comment</span>
</div>
<span class="font-label-sm text-label-sm text-on-surface text-shadow">1,245</span>
</button>
<!-- Save Action -->
<button class="flex flex-col items-center group scale-95 active:scale-90 transition-all duration-200">
<div class="w-10 h-10 rounded-full backdrop-blur-2xl bg-white/10 border border-white/20 flex items-center justify-center mb-1 group-hover:bg-white/20 transition-colors shadow-[0_0_15px_rgba(91,94,255,0.2)]">
<span class="material-symbols-outlined text-on-surface" style="font-variation-settings: 'FILL' 0;">bookmark</span>
</div>
<span class="font-label-sm text-label-sm text-on-surface text-shadow">8.3k</span>
</button>
<!-- Share Action -->
<button class="flex flex-col items-center group scale-95 active:scale-90 transition-all duration-200">
<div class="w-10 h-10 rounded-full backdrop-blur-2xl bg-white/10 border border-white/20 flex items-center justify-center mb-1 group-hover:bg-white/20 transition-colors shadow-[0_0_15px_rgba(91,94,255,0.2)]">
<span class="material-symbols-outlined text-on-surface" style="font-variation-settings: 'FILL' 0;">share</span>
</div>
<span class="font-label-sm text-label-sm text-on-surface text-shadow">Share</span>
</button>
</aside>
<!-- Bottom Left Information Area -->
<div class="absolute left-4 bottom-28 z-30 pr-20 flex flex-col space-y-3 w-full max-w-[80%] text-shadow">
<!-- Creator Info Row -->
<div class="flex items-center space-x-3">
<span class="font-headline-md text-headline-md text-on-surface text-lg">@neon_dancer</span>
<button class="px-3 py-1 bg-white/10 backdrop-blur-md border border-white/20 rounded-full font-label-md text-label-md text-on-surface hover:bg-white/20 transition-colors shadow-lg">
                    Follow
                </button>
</div>
<!-- Caption -->
<p class="font-body-md text-body-md text-on-surface/90 line-clamp-2 leading-tight">
                Lost in the neon flow tonight 🌃✨ Chasing vibes in the upper sector. #cyberpunk #dance #vibe
            </p>
<!-- Music Info -->
<div class="flex items-center space-x-2 bg-surface-container/30 backdrop-blur-md border border-white/10 rounded-full py-1.5 px-3 w-fit shadow-md">
<span class="material-symbols-outlined text-primary spin-slow" style="font-size: 16px;">music_note</span>
<div class="overflow-hidden w-32 relative h-[20px]">
<div class="absolute whitespace-nowrap animate-[marquee_5s_linear_infinite] font-label-sm text-label-sm text-on-surface-variant flex items-center h-full">
                        Neon Lights - Original Sound &nbsp;&nbsp;&nbsp; Neon Lights - Original Sound
                    </div>
</div>
</div>
<style>
                @keyframes marquee {
                    0% { transform: translateX(0%); }
                    100% { transform: translateX(-50%); }
                }
            </style>
</div>
<!-- Video Progress Bar -->
<div class="absolute bottom-[88px] left-0 w-full h-[2px] bg-white/20 z-40">
<div class="h-full bg-gradient-to-r from-primary to-secondary w-1/3 shadow-[0_0_10px_rgba(192,193,255,0.8)] relative">
<div class="absolute right-0 top-1/2 -translate-y-1/2 w-1.5 h-1.5 bg-white rounded-full shadow-[0_0_5px_rgba(255,255,255,1)]"></div>
</div>
</div>
<!-- BottomNavBar (from JSON) -->
<nav class="fixed bottom-0 w-full z-50 pb-6 pt-2 px-4 max-w-md mx-auto pointer-events-none flex justify-center">
<div class="pointer-events-auto backdrop-blur-2xl bg-surface-container-lowest/40 border border-white/10 rounded-full shadow-[0px_30px_60px_-15px_rgba(91,94,255,0.2)] flex justify-around items-center h-16 w-full max-w-[360px] px-2 relative overflow-hidden">
<!-- Subtle glass highlight inside nav -->
<div class="absolute top-0 left-0 right-0 h-[1px] bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>
<button class="flex flex-col items-center justify-center text-primary-fixed-dim scale-110 relative after:content-[''] after:absolute after:-bottom-2 after:w-1 after:h-1 after:bg-primary after:rounded-full hover:text-primary transition-colors active:scale-90 duration-150 p-2">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">home</span>
</button>
<button class="flex flex-col items-center justify-center text-on-surface-variant/60 hover:text-primary transition-colors active:scale-90 duration-150 p-2">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">explore</span>
</button>
<button class="flex flex-col items-center justify-center text-on-surface-variant/60 hover:text-primary transition-colors active:scale-90 duration-150 p-2">
<div class="w-10 h-10 rounded-full bg-gradient-to-tr from-primary to-secondary flex items-center justify-center text-on-primary-fixed shadow-lg shadow-primary/30">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">add</span>
</div>
</button>
<button class="flex flex-col items-center justify-center text-on-surface-variant/60 hover:text-primary transition-colors active:scale-90 duration-150 p-2">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">chat_bubble</span>
</button>
<button class="flex flex-col items-center justify-center text-on-surface-variant/60 hover:text-primary transition-colors active:scale-90 duration-150 p-2">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">person</span>
</button>
</div>
</nav>
</main>


</body></html>