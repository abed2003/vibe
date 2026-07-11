<!DOCTYPE html><html class="dark" lang="en"><head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<title>VIBE - Search</title>
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
        /* Custom utilities for glassmorphism and specific UI tweaks */
        .glass-panel {
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .text-gradient-primary {
            background: linear-gradient(to right, theme('colors.primary'), theme('colors.secondary'));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .btn-primary-interactive {
            background: linear-gradient(to right, theme('colors.primary-container'), theme('colors.inverse-primary'));
            box-shadow: inset 0 1px 0 0 rgba(255,255,255,0.2);
            transition: all 0.2s ease;
        }
        .btn-primary-interactive:hover {
            transform: scale(1.02);
            box-shadow: inset 0 1px 0 0 rgba(255,255,255,0.3), 0 8px 20px -6px theme('colors.primary-container');
        }
        /* Hide scrollbar for tabs */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="bg-background text-on-background antialiased min-h-screen flex flex-col selection:bg-primary-container selection:text-on-primary-container">
<!-- Sticky Header: Search Bar & Filter Tabs -->
<header class="fixed top-0 w-full z-40 glass-panel bg-surface/80 pt-12 pb-sm shadow-[0px_30px_60px_-15px_rgba(0,0,0,0.5)]">
<div class="max-w-screen-md mx-auto px-margin-mobile flex flex-col gap-sm">
<!-- Search Input Area -->
<div class="flex items-center gap-sm">
<button class="p-xs text-on-surface-variant hover:text-primary transition-colors flex-shrink-0">
<span class="material-symbols-outlined text-headline-md">arrow_back</span>
</button>
<div class="relative flex-grow">
<span class="material-symbols-outlined absolute left-sm top-1/2 -translate-y-1/2 text-on-surface-variant text-body-lg">search</span>
<input class="w-full bg-surface-container-highest/50 text-on-surface font-body-md text-body-md rounded-full py-2 pl-xl pr-sm border border-outline-variant/30 focus:outline-none focus:border-primary/50 focus:bg-surface-container-highest transition-all placeholder:text-on-surface-variant/50" placeholder="Search VIBE..." type="text" value="Neon Beats">
<button class="absolute right-sm top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-on-surface transition-colors">
<span class="material-symbols-outlined text-body-lg">cancel</span>
</button>
</div>
<button class="p-xs text-on-surface-variant hover:text-primary transition-colors flex-shrink-0">
<span class="material-symbols-outlined text-headline-md">light_mode</span>
</button><button class="p-xs text-on-surface-variant hover:text-primary transition-colors flex-shrink-0">
<span class="material-symbols-outlined text-headline-md">tune</span>
</button>
</div>
<!-- Scrollable Filter Tabs -->
<nav class="flex gap-sm overflow-x-auto no-scrollbar py-xs mt-xs">
<button class="px-md py-1.5 rounded-full font-label-md text-label-md bg-primary text-on-primary whitespace-nowrap shadow-[0_0_15px_rgba(91,94,255,0.3)] transition-all">Top</button>
<button class="px-md py-1.5 rounded-full font-label-md text-label-md bg-surface-container border border-outline-variant/20 text-on-surface-variant hover:bg-surface-container-high transition-all whitespace-nowrap">Videos</button>
<button class="px-md py-1.5 rounded-full font-label-md text-label-md bg-surface-container border border-outline-variant/20 text-on-surface-variant hover:bg-surface-container-high transition-all whitespace-nowrap">Users</button>
<button class="px-md py-1.5 rounded-full font-label-md text-label-md bg-surface-container border border-outline-variant/20 text-on-surface-variant hover:bg-surface-container-high transition-all whitespace-nowrap">Hashtags</button>
<button class="px-md py-1.5 rounded-full font-label-md text-label-md bg-surface-container border border-outline-variant/20 text-on-surface-variant hover:bg-surface-container-high transition-all whitespace-nowrap">Music</button>
</nav>
</div>
</header>
<!-- Main Content Area -->
<main class="flex-grow pt-[140px] pb-32 max-w-screen-md mx-auto w-full px-margin-mobile flex flex-col gap-lg">
<!-- Section: Top Users (Bento style horizontal scroll) -->
<section class="flex flex-col gap-sm">
<h2 class="font-headline-md text-headline-md text-on-surface">Users</h2>
<div class="flex gap-md overflow-x-auto no-scrollbar pb-sm -mx-margin-mobile px-margin-mobile snap-x">
<!-- User Card 1 -->
<div class="glass-panel bg-surface-container/40 rounded-xl p-md flex flex-col items-center gap-sm min-w-[140px] snap-center hover:scale-[1.02] transition-transform">
<div class="relative w-16 h-16 rounded-full overflow-hidden border-2 border-primary/50">
<img class="w-full h-full object-cover" data-alt="A striking, high-contrast portrait of a modern electronic music DJ in a dimly lit studio setting. The lighting is cinematic, featuring deep moody shadows punctuated by vibrant neon blue and purple edge lights reflecting off their headphones. The aesthetic is premium, energetic, and perfectly suited for a high-end dark-mode social media platform. The composition is tight, focusing on their focused expression." src="https://lh3.googleusercontent.com/aida-public/AB6AXuAWyYgErHENWTcLE4nosf-rhpbFeTz4mZ12F0luI17VXcVmw8IwVbsAqDQFpG3C85LptSvPXPhIV0EL3KWjgOpxbGZ3CFraRGHGaMBGEYB1mwe_HlmDNwajhgetTPSFP-sY_EjbrwIifSwQ7e5o2D47qJaS0G_e6wmCS5oNX-GfljiOwU9u6st626AW4lU85yCBuSmlEPFCYvMUwBdnndso-mD7KuXVgXrmNkWViAlTFyfTDdUubTiXTfOXPMqCjAeoWuezXLSYahc">
<div class="absolute inset-0 border border-white/10 rounded-full"></div>
</div>
<div class="text-center">
<h3 class="font-label-md text-label-md text-on-surface truncate w-24">@neon_beats</h3>
<p class="font-label-sm text-label-sm text-on-surface-variant">1.2M Followers</p>
</div>
<button class="btn-primary-interactive w-full py-1.5 rounded-full font-label-md text-label-md text-white mt-xs">Follow</button>
</div>
<!-- User Card 2 -->
<div class="glass-panel bg-surface-container/40 rounded-xl p-md flex flex-col items-center gap-sm min-w-[140px] snap-center hover:scale-[1.02] transition-transform">
<div class="relative w-16 h-16 rounded-full overflow-hidden border border-outline-variant/50">
<img class="w-full h-full object-cover" data-alt="A vibrant, stylized portrait of a female streetwear fashion influencer standing against a stark, modern architectural background. The scene is lit with soft, diffused white light that highlights the technical fabrics of her jacket, while a subtle cool teal rim light separates her from the dark background. The mood is confident and trend-setting, aligning with a premium digital culture aesthetic." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDAeXH3IaXgrqzKQM9G0uvnZnf026JR7VfBU_VkIn4RS7sOCahOrT7mplGfiLGD16N3sVFUKNbxMAvVwu413E9XyY8tT15nRiLNHYvHLyp3Hi0N2R1FwN3vDp12iH5TJ4E0thv0l-VLU7OV8IYrRIZvCGtTbKc_sKtk_WCeFuyFzS8FVhc0D_7ujMTZM8blr5ggPDxB9phCec617Ytcoixuw3Ldnfa62Gi2UOf2sOvZB38gb4lf6pQgnDjEDWpdaDEYu3kStfjqPjg">
</div>
<div class="text-center">
<h3 class="font-label-md text-label-md text-on-surface truncate w-24">@vibe_creator</h3>
<p class="font-label-sm text-label-sm text-on-surface-variant">850K Followers</p>
</div>
<button class="w-full py-1.5 rounded-full font-label-md text-label-md bg-surface-container-highest text-on-surface hover:bg-surface-bright transition-colors mt-xs">Follow</button>
</div>
<!-- View More Card -->
<div class="glass-panel bg-surface-container/20 rounded-xl p-md flex flex-col items-center justify-center gap-xs min-w-[120px] snap-center hover:bg-surface-container/40 transition-colors cursor-pointer">
<span class="material-symbols-outlined text-headline-lg text-primary">arrow_forward</span>
<span class="font-label-sm text-label-sm text-on-surface-variant">View All</span>
</div>
</div>
</section>
<!-- Section: Trending Hashtags (Compact List) -->
<section class="flex flex-col gap-sm">
<h2 class="font-headline-md text-headline-md text-on-surface">Trending Hashtags</h2>
<div class="glass-panel bg-surface-container/30 rounded-xl divide-y divide-outline-variant/10">
<div class="flex items-center justify-between p-md hover:bg-surface-container/50 transition-colors cursor-pointer group">
<div class="flex items-center gap-md">
<div class="w-10 h-10 rounded-full bg-surface-container-highest flex items-center justify-center text-primary group-hover:bg-primary/20 transition-colors">
<span class="material-symbols-outlined text-headline-md" style="font-variation-settings: 'FILL' 1;">tag</span>
</div>
<div>
<h3 class="font-label-md text-label-md text-on-surface">neonbeats</h3>
<p class="font-label-sm text-label-sm text-on-surface-variant">4.5M posts</p>
</div>
</div>
<span class="material-symbols-outlined text-on-surface-variant group-hover:text-primary transition-colors">chevron_right</span>
</div>
<div class="flex items-center justify-between p-md hover:bg-surface-container/50 transition-colors cursor-pointer group">
<div class="flex items-center gap-md">
<div class="w-10 h-10 rounded-full bg-surface-container-highest flex items-center justify-center text-on-surface-variant group-hover:bg-surface-bright transition-colors">
<span class="material-symbols-outlined text-headline-md" style="font-variation-settings: 'FILL' 1;">tag</span>
</div>
<div>
<h3 class="font-label-md text-label-md text-on-surface">cyberpunkdance</h3>
<p class="font-label-sm text-label-sm text-on-surface-variant">1.2M posts</p>
</div>
</div>
<span class="material-symbols-outlined text-on-surface-variant group-hover:text-primary transition-colors">chevron_right</span>
</div>
</div>
</section>
<!-- Section: Top Videos (Asymmetric Masonry/Grid) -->
<section class="flex flex-col gap-sm">
<h2 class="font-headline-md text-headline-md text-on-surface">Top Videos</h2>
<div class="grid grid-cols-2 gap-xs md:gap-sm">
<!-- Video Item 1 (Tall) -->
<div class="relative rounded-lg overflow-hidden aspect-[9/16] group cursor-pointer">
<img class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" data-alt="A dynamic vertical shot capturing an urban street dancer mid-movement against a raw concrete backdrop at night. The scene is illuminated by dramatic, high-key directional lighting that highlights the textures of their streetwear. The color palette relies on deep blacks and cool concrete greys, with a bold pop of fluorescent orange from their jacket. The image exudes a sense of fluidity and raw energy, perfect for a modern video feed." src="https://lh3.googleusercontent.com/aida-public/AB6AXuAE5zOSaKho3IehqaATP0tZ03SH1sqNSSrJDw27KfsDErI4tmUce2w7c3F6p4UE-QcL4OXRx429e60oVFk33FRNQaxMthFcHdjjdhale15F4VQ3CBOASAJbT9gWAN4HOPZPyWs-bViss55vH2ZRT4e7ttmKLq5WXNyDUK6pylhiPvJKChRwDEHBx4x220DiujlnSkTXT_0tRthq5rwfFWslIgiGRbgYRTrDefRhuzYXhKs3IKKompXa5kJoyaC4bjDFCbvgbHghKE4">
<div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-80"></div>
<div class="absolute bottom-sm left-sm right-sm flex flex-col gap-xs">
<div class="flex items-center gap-xs text-white">
<span class="material-symbols-outlined text-label-sm" style="font-variation-settings: 'FILL' 1;">play_arrow</span>
<span class="font-label-sm text-label-sm">2.4M</span>
</div>
<p class="font-label-sm text-label-sm text-white/90 line-clamp-2 leading-tight">Neon vibes only tonight! Let's go 🚀 #neonbeats</p>
</div>
</div>
<!-- Video Item 2 (Tall) -->
<div class="relative rounded-lg overflow-hidden aspect-[9/16] group cursor-pointer">
<img class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" data-alt="A mesmerizing vertical video still showing a futuristic DJ mixing deck from a top-down angle, glowing in a dark club environment. The controllers and buttons emit vivid cyan and magenta lights that reflect softly on the surrounding dark matte surfaces. The focus is sharp on the illuminated controls, creating a depth of field that blurs the background. The visual style is highly polished, tech-forward, and immersive." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBTJL15OMnbCrmD1WSZz8QI_w2CRGBjxcVLRXhVom-PsP2tpsN0TYFM3wTXMcjlmQaappUHFohvYVYAVhYVT1daT5eCEr0WHW8DWqHCy5ptpFbKV3EWgpcTzlthpLH_OGWb3lqYsLISeFOeLZaORg-RblNDS0Q9bmNmARFvoPZxnulfMO-SqidoBpoLIRI21z5DlWxr9sRo9Ie4J70sI4OEyEzZjhlcD9ntAR0JfS6cWG-2PB39DLBUjSgPAFPpNBnDCdeZBkg4hfc">
<div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-80"></div>
<div class="absolute bottom-sm left-sm right-sm flex flex-col gap-xs">
<div class="flex items-center gap-xs text-white">
<span class="material-symbols-outlined text-label-sm" style="font-variation-settings: 'FILL' 1;">play_arrow</span>
<span class="font-label-sm text-label-sm">890K</span>
</div>
<p class="font-label-sm text-label-sm text-white/90 line-clamp-2 leading-tight">Studio session mixing the new track. Thoughts?</p>
</div>
</div>
</div>
</section>
</main>
<!-- Bottom Navigation Bar (from JSON schema for mobile) -->
<nav class="md:hidden fixed bottom-0 w-full z-50 pb-8 px-4 pointer-events-none">
<div class="backdrop-blur-2xl bg-white/10 border border-white/10 rounded-full mb-4 mx-4 shadow-[0px_30px_60px_-15px_rgba(91,94,255,0.2)] flex justify-around items-center h-16 w-full max-w-md mx-auto pointer-events-auto">
<a class="flex items-center justify-center text-on-surface-variant/60 hover:text-primary transition-colors active:scale-90 duration-150 p-2" href="#">
<span class="material-symbols-outlined text-headline-md">home</span>
</a>
<!-- Active State: Explore (Search Context) -->
<a class="flex items-center justify-center text-primary-fixed-dim scale-110 relative after:content-[''] after:absolute after:-bottom-1 after:w-1 after:h-1 after:bg-primary after:rounded-full hover:text-primary transition-colors active:scale-90 duration-150 p-2" href="#">
<span class="material-symbols-outlined text-headline-md" style="font-variation-settings: 'FILL' 1;">explore</span>
</a>
<a class="flex items-center justify-center text-on-surface-variant/60 hover:text-primary transition-colors active:scale-90 duration-150 p-2" href="#">
<span class="material-symbols-outlined text-headline-md">add_circle</span>
</a>
<a class="flex items-center justify-center text-on-surface-variant/60 hover:text-primary transition-colors active:scale-90 duration-150 p-2" href="#">
<span class="material-symbols-outlined text-headline-md">chat_bubble</span>
</a>
<a class="flex items-center justify-center text-on-surface-variant/60 hover:text-primary transition-colors active:scale-90 duration-150 p-2" href="#">
<span class="material-symbols-outlined text-headline-md">person</span>
</a>
</div>
</nav>


</body></html>