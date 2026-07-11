<!DOCTYPE html><html class="dark" lang="en"><head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<title>VIBE - Video Details</title>
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
                        "display-lg": ["48px", { "lineHeight": "56px", "letterSpacing": "-0.04em", "fontWeight": "800" }],
                        "body-md": ["16px", { "lineHeight": "24px", "letterSpacing": "0em", "fontWeight": "400" }],
                        "headline-lg": ["32px", { "lineHeight": "40px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "label-sm": ["12px", { "lineHeight": "16px", "letterSpacing": "0.04em", "fontWeight": "500" }],
                        "headline-lg-mobile": ["28px", { "lineHeight": "34px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "headline-md": ["24px", { "lineHeight": "30px", "letterSpacing": "-0.01em", "fontWeight": "600" }],
                        "body-lg": ["18px", { "lineHeight": "28px", "letterSpacing": "0em", "fontWeight": "400" }],
                        "label-md": ["14px", { "lineHeight": "20px", "letterSpacing": "0.02em", "fontWeight": "600" }]
                    }
                }
            }
        }
    </script>
<style>
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .glass-modal {
            background: rgba(28, 32, 38, 0.85);
            backdrop-filter: blur(40px);
            -webkit-backdrop-filter: blur(40px);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 -10px 40px rgba(91, 94, 255, 0.15);
        }
        
        /* Ambient Shadow for specific glowing elements */
        .ambient-shadow {
            box-shadow: 0 10px 30px rgba(91, 94, 255, 0.15);
        }
        
        /* Hide scrollbar for clean UI */
        ::-webkit-scrollbar {
            width: 0px;
            background: transparent;
        }
    </style>
</head>
<body class="bg-background text-on-surface font-body-md min-h-screen overflow-hidden antialiased selection:bg-primary-container selection:text-on-primary-container relative">
<!-- Background Video Layer (Darkened) -->
<div class="fixed inset-0 z-0">
<div class="absolute inset-0 bg-cover bg-center w-full h-full object-cover" data-alt="A mesmerizing vertical video still showing a high-energy neon city street at night, with blurred light trails from fast-moving vehicles. The aesthetic is hyper-refined dark mode, utilizing deep indigo shadows and glowing primary accents to create an immersive, premium atmosphere. The scene feels cinematic and slightly out of focus, perfect as a deep background layer." style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuD-BhqbF9FT5XBpdhgs0O7gxl2l7CC8oXrWoG5PN2QFZ4j7Ic49WLxgLzbRI4LvFCFri7Vh-PvA-sSnQ9ourTzQQ--_sqjj8Kabug4ra-OoTuwsTSluNfcwsK9og1Z-snjet4fR8_NDfvMzXc7nRvUNKmAQRIpbAqGdlcGf7g3OlO5Ax6pcZYty97NS1ePEld_CiCt2okpoZXQzVu53flCp7CyGUtC8Wo7lf4wChI-FYXo_b45ugFadg1YlC56FEyur3xjZ-kU80-s')"></div>
<div class="absolute inset-0 bg-black/60 backdrop-blur-[2px]"></div>
</div>
<!-- Top Navigation Anchor (Task-focused sub-page, no bottom nav) -->
<header class="fixed top-0 w-full z-50 flex justify-between items-center px-margin-mobile pt-12 pb-4 backdrop-blur-xl bg-surface/10 border-b border-white/10 shadow-[0px_30px_60px_-15px_rgba(91,94,255,0.15)] md:hidden">
<button class="w-10 h-10 rounded-full glass-card flex items-center justify-center text-on-surface hover:text-primary transition-colors">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">arrow_back</span>
</button>
<span class="font-headline-lg-mobile text-headline-lg-mobile tracking-tighter bg-clip-text text-transparent bg-gradient-to-r from-primary to-secondary">VIBE</span>
<button class="w-10 h-10 rounded-full glass-card flex items-center justify-center text-on-surface hover:text-primary transition-colors mr-2">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">light_mode</span>
</button><button class="w-10 h-10 rounded-full glass-card flex items-center justify-center text-on-surface hover:text-primary transition-colors">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">more_vert</span>
</button>
</header>
<!-- Desktop Header -->
<header class="fixed top-0 w-full z-50 hidden md:flex justify-between items-center px-margin-desktop h-20 backdrop-blur-xl bg-surface/10 border-b border-white/10 shadow-[0px_30px_60px_-15px_rgba(91,94,255,0.15)]">
<div class="flex items-center gap-md">
<button class="w-10 h-10 rounded-full glass-card flex items-center justify-center text-on-surface hover:text-primary transition-colors">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">arrow_back</span>
</button>
<span class="font-display-lg text-display-lg tracking-tighter bg-clip-text text-transparent bg-gradient-to-r from-primary to-secondary">VIBE</span>
</div>
<button class="w-10 h-10 rounded-full glass-card flex items-center justify-center text-on-surface hover:text-primary transition-colors">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">light_mode</span>
</button></header>
<!-- Main Content Canvas -->
<main class="relative z-10 h-screen w-full flex flex-col justify-end md:items-center pt-24 md:pt-0">
<!-- Desktop Central Wrapper -->
<div class="w-full md:max-w-[600px] h-full flex flex-col justify-end">
<!-- Bottom Sheet / Overlay -->
<div class="glass-modal w-full rounded-t-3xl pt-sm pb-xl px-margin-mobile flex flex-col h-[75vh] md:h-[85vh] transition-transform duration-300 ease-out">
<!-- Drag Handle (Mobile) -->
<div class="w-12 h-1.5 bg-surface-variant rounded-full mx-auto mb-lg md:hidden"></div>
<div class="flex-1 overflow-y-auto pb-2xl">
<!-- Creator & Description Section -->
<div class="flex items-start gap-md mb-lg">
<img class="w-12 h-12 rounded-full object-cover border border-white/20" data-alt="A profile picture of a stylish urban creator wearing neon-accented streetwear, illuminated by dramatic purple and blue studio lighting. The image embodies a premium, high-contrast dark mode aesthetic fitting for a social media platform." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDeHFbI0kVZDwcfoBrzOuP5wcZQco-nBJKTfdfmBu8mNfIAD2sDkQsdkw5UPJ2BmPR1j0F7WOlNP4-1MxqtoGvscQjMshR0IoZYhhE11qiriI84pUYWszxhevm0PRbZZsE3eUm0RnLEFW4kiDdBbYN0X64a1Xwq1QU5ScQZEkrKqRgt4wLztZsyd7snScx1OT_9n2u14lRFA1qp0NF9ahvtbNh2dzKBSmSp6cQs0vU2COauNNRG1vbKrPXVPs-obFD5lH8tw4A_FcE">
<div class="flex-1">
<div class="flex items-center justify-between">
<h2 class="font-headline-md text-headline-md text-on-surface">Neon Nights in Neo-Tokyo</h2>
<button class="bg-primary-container text-on-primary-container font-label-md text-label-md px-4 py-1.5 rounded-full hover:scale-105 active:scale-95 transition-all shadow-[0_4px_12px_rgba(91,94,255,0.3)]">Follow</button>
</div>
<p class="font-body-md text-body-md text-on-surface-variant mt-sm">Exploring the hidden alleyways and vibrant street culture. The energy here is absolutely unmatched. 🌃✨ #travel #cyberpunk #vibe</p>
<!-- Tags -->
<div class="flex flex-wrap gap-sm mt-md">
<span class="px-3 py-1 rounded-full bg-secondary/40 text-on-secondary-container font-label-sm text-label-sm backdrop-blur-md">Travel</span>
<span class="px-3 py-1 rounded-full bg-secondary/40 text-on-secondary-container font-label-sm text-label-sm backdrop-blur-md">Cinematic</span>
</div>
</div>
</div>
<!-- Statistics Bar -->
<div class="glass-card rounded-2xl p-md flex justify-around items-center mb-xl">
<div class="flex flex-col items-center">
<span class="material-symbols-outlined text-primary mb-xs" style="font-variation-settings: 'FILL' 1;">favorite</span>
<span class="font-label-md text-label-md text-on-surface">124K</span>
</div>
<div class="w-px h-8 bg-white/10"></div>
<div class="flex flex-col items-center">
<span class="material-symbols-outlined text-on-surface-variant mb-xs">chat_bubble</span>
<span class="font-label-md text-label-md text-on-surface">3.2K</span>
</div>
<div class="w-px h-8 bg-white/10"></div>
<div class="flex flex-col items-center">
<span class="material-symbols-outlined text-on-surface-variant mb-xs">share</span>
<span class="font-label-md text-label-md text-on-surface">15K</span>
</div>
<div class="w-px h-8 bg-white/10"></div>
<div class="flex flex-col items-center">
<span class="material-symbols-outlined text-on-surface-variant mb-xs">bookmark</span>
<span class="font-label-md text-label-md text-on-surface">8.4K</span>
</div>
</div>
<!-- Comments Section -->
<div class="mb-xl">
<h3 class="font-headline-md text-headline-md text-on-surface mb-md">Comments</h3>
<!-- Comment Thread 1 -->
<div class="mb-md">
<div class="flex items-start gap-sm">
<img class="w-8 h-8 rounded-full object-cover" data-alt="A small circular avatar showing a young woman with pink hair in a dimly lit, moody environment. The aesthetic is modern and fits a dark-mode social media interface." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDA6933kK00IwR63h3Lof46aagnAu2RuGxnB_PdJWceuHy3MJFL_w79PztB6la8LcHE6GQJD9OrkGjfgOXQbid7K5qrv8bBIBEdRV2TnN2by_wwiHGkjkKjGNqw4RUmYnvHdbe-Z6xyeYPK9NLLkEwS6z1eb26tlFBVKNjU08ZrswZQhpbc9KMxNesI1EpDcAiau3wiaMsR6H8G4zUj79WgBhdkfNE6pTIJC-fmfLpfnlZIwCUOnBZAf5T5qCmd5hzLt3oztgvlh98">
<div class="flex-1">
<div class="glass-card rounded-2xl rounded-tl-sm p-sm inline-block">
<p class="font-label-md text-label-md text-on-surface mb-0.5">@CyberJane</p>
<p class="font-body-md text-body-md text-on-surface-variant">The color grading on this is insane. What LUTs did you use?</p>
</div>
<div class="flex gap-md mt-1 ml-2">
<span class="font-label-sm text-label-sm text-on-surface-variant/60">2h ago</span>
<button class="font-label-sm text-label-sm text-on-surface-variant hover:text-primary transition-colors">Reply</button>
</div>
<!-- Reply -->
<div class="flex items-start gap-sm mt-sm ml-lg">
<img class="w-6 h-6 rounded-full object-cover border border-primary/30" data-alt="A small circular avatar showing a stylish urban creator wearing neon-accented streetwear, identical to the main creator's avatar, in a premium dark mode setting." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDXByc9HdwHxDFdBeuIhDi0QWR7MbD5ze6BN8QcwWsJoo6JMkvoLELSs05bXK9Y7ZvGI46NdmIgdnAoPekgFjoOz9P2W42gyeUuih0KmgGEbwa1Kh_kfR5e4w75ytUdTOtsY46tfU-NnjrRg_yDanKvIryml4KBkRnYCrKOuhwKJ2edkl45EOOSXRUQv8GmAZaaA1BBfPl9SY3qnkXXN_3KQ00rOmkzHsh_KXjmOJSjIgQUqZ4L-DfbGRn0juI6qw4xEOq8-GYAtXA">
<div class="flex-1">
<div class="glass-card rounded-2xl rounded-tl-sm p-sm inline-block border-primary/20">
<p class="font-label-md text-label-md text-primary mb-0.5">@NeonCreator <span class="bg-primary/20 text-primary px-1.5 py-0.5 rounded text-[10px] ml-1">Creator</span></p>
<p class="font-body-md text-body-md text-on-surface-variant">Custom built! Might release a pack soon. 👀</p>
</div>
</div>
</div>
</div>
<button class="flex flex-col items-center gap-1 text-on-surface-variant">
<span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 0;">favorite</span>
<span class="text-xs">432</span>
</button>
</div>
</div>
<!-- Comment Input (Sticky to bottom of list) -->
<div class="relative mt-md">
<img class="absolute left-sm top-1/2 -translate-y-1/2 w-8 h-8 rounded-full object-cover" data-alt="The current user's profile picture, a silhouette against a glowing blue geometric background, fitting the high-end dark mode aesthetic." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBdF5pcUITSqZ1FEoGUuJoJL8mV3uYV2xtIfH6EH_35GsNBD_YjsPl9un2c-RMaWfeE-yH87jBqOFJfS_jKVa7R4yNz154tmPHDHwsZIwSBOrxi5CiDhhKPpPiQim_ainqOkMqsi-u8Dv8KY0QeV_i21-4Xnwm_bGFvYrZNS6LyD3mYKveZbi0oJW3kzYZrsgLNa75CPC_hFt8ZXa5lhNN_RK2sLnLZ_HuoHy-Hk5bEPsFDzvS-3gQXmrBQf29I0ewdH4RhP04GHWs">
<input class="w-full bg-surface-container-high/50 border-b border-white/10 text-on-surface placeholder:text-on-surface-variant/50 focus:border-primary focus:ring-0 focus:outline-none transition-colors pl-14 pr-12 py-3 rounded-t-lg font-body-md" placeholder="Add a comment..." type="text">
<button class="absolute right-sm top-1/2 -translate-y-1/2 text-primary p-2 hover:scale-110 transition-transform">
<span class="material-symbols-outlined">send</span>
</button>
</div>
</div>
<!-- Related Videos (Horizontal Scroll) -->
<div>
<h3 class="font-headline-md text-headline-md text-on-surface mb-md">More like this</h3>
<div class="flex overflow-x-auto gap-md pb-md snap-x">
<!-- Thumbnail 1 -->
<div class="min-w-[120px] w-[120px] aspect-[9/16] rounded-xl overflow-hidden relative snap-start group cursor-pointer">
<img class="w-full h-full object-cover transition-transform group-hover:scale-105" data-alt="A vertical video thumbnail showing a rainy street scene with vibrant neon reflections on the wet pavement. Premium dark mode aesthetic with deep shadows and glowing magenta highlights." src="https://lh3.googleusercontent.com/aida-public/AB6AXuCy60xoOTS29oXQfXn_TQVajSYvuBjjuHvT9W4keVHUUnQgpEXH89hAIE973XfMRVTW3_PAXKbQnHCj3TVPtC9l3cbWn-3T9NEg84PW7PEt0TBnOIf7VugtB8w8NGXJJuCF27ny6VVqJLfx0Yx14yUP0IlNTYxugeqL8OYaePM6Rw2yXR8Hb6dF2HLUTfgofBUEgpga2upPO-Q9CrVPNkqyXtNVslt9sba5MNXuaGFUqsG3Ghp5A3PnPs4FiwiCT-wQfJMuxN-0Ti8">
<div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
<div class="absolute bottom-2 left-2 flex items-center gap-1 text-white">
<span class="material-symbols-outlined text-[14px]">play_arrow</span>
<span class="font-label-sm text-label-sm">89K</span>
</div>
</div>
<!-- Thumbnail 2 -->
<div class="min-w-[120px] w-[120px] aspect-[9/16] rounded-xl overflow-hidden relative snap-start group cursor-pointer">
<img class="w-full h-full object-cover transition-transform group-hover:scale-105" data-alt="A vertical video thumbnail capturing an underground subway station bathed in eerie teal and purple lighting. Cinematic composition fitting a premium social platform." src="https://lh3.googleusercontent.com/aida-public/AB6AXuAyVHdGHTHZXcEyXlDC8te6DODdQx4OnTaKgsXQpccuGI6OvGlXstY74GBgFWgFPWdTjs7d74HKBZ7VVpFMP0_ieENgaeMsxcJmWsUVNzO8j1Chq9X19WzfX0hz4jLZffn-ThimRliCPdNrwxAQk2xUztRX2wobS271ljjZe3pLStXz5G5fVL0QWnslQegrdlq5mQf6hVfBJ5W-3mwLx04HTcyclt8NwouLL3w4umEXpDjxz9OsGYKcnGERlHrJCp8_MXoS78KSujw">
<div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
<div class="absolute bottom-2 left-2 flex items-center gap-1 text-white">
<span class="material-symbols-outlined text-[14px]">play_arrow</span>
<span class="font-label-sm text-label-sm">45K</span>
</div>
</div>
<!-- Thumbnail 3 -->
<div class="min-w-[120px] w-[120px] aspect-[9/16] rounded-xl overflow-hidden relative snap-start group cursor-pointer">
<img class="w-full h-full object-cover transition-transform group-hover:scale-105" data-alt="A vertical video thumbnail showing a fast-paced action shot of a car drifting, blurred background with intense orange and blue lighting accents." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBk_OAzJQ-w0L2fw82rgq17WBg7FP4_5MXSXmrDSj4NXIoEOCoeC_FbFIOD5Ah3omvUSssB3VefHXz2p6f4n_5Efvt89cQju7YRKkrrXSLdizBX-W5S8jIQ6krqP84u2zme601zEQ_3ZwX4x1HhIv6ue0r6Mxt1WJCOD632OtH5y0KHRjqqdN4WxpjB2PJ1Bt-iC91CtW0MhGfQDSjdMl8dRQL2MiCEVAzYUGNQzX7lSNmC9kYTFFPvFC9o0WLRw7fcAidkYoyfLrE">
<div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
<div class="absolute bottom-2 left-2 flex items-center gap-1 text-white">
<span class="material-symbols-outlined text-[14px]">play_arrow</span>
<span class="font-label-sm text-label-sm">212K</span>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</main>


</body></html>