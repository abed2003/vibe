<!DOCTYPE html>

<html class="dark" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>VIBE - Registration</title>
<!-- Material Symbols -->
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<style>
        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined';
            font-weight: normal;
            font-style: normal;
            font-size: 24px;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            display: inline-block;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            -webkit-font-feature-settings: 'liga';
            -webkit-font-smoothing: antialiased;
        }

        /* Hide scrollbar for cleaner UI */
        ::-webkit-scrollbar {
            display: none;
        }
        * {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-primary-fixed-variant": "#2723d1",
                        "on-tertiary": "#542100",
                        "on-secondary-fixed": "#25005a",
                        "on-tertiary-fixed-variant": "#783200",
                        "secondary": "#d2bbff",
                        "tertiary-fixed-dim": "#ffb690",
                        "secondary-fixed": "#eaddff",
                        "on-tertiary-container": "#fffbfa",
                        "surface-bright": "#353940",
                        "error": "#ffb4ab",
                        "on-error-container": "#ffdad6",
                        "on-tertiary-fixed": "#331100",
                        "secondary-fixed-dim": "#d2bbff",
                        "on-primary-container": "#fefaff",
                        "surface-container-high": "#262a31",
                        "on-error": "#690005",
                        "inverse-surface": "#dfe2eb",
                        "on-surface": "#dfe2eb",
                        "surface": "#10141a",
                        "secondary-container": "#6001d1",
                        "inverse-primary": "#4345e8",
                        "surface-variant": "#31353c",
                        "primary": "#c0c1ff",
                        "outline-variant": "#454555",
                        "on-primary": "#0f00aa",
                        "surface-container-highest": "#31353c",
                        "surface-tint": "#c0c1ff",
                        "surface-dim": "#10141a",
                        "primary-container": "#5b5eff",
                        "primary-fixed": "#e1e0ff",
                        "outline": "#908fa1",
                        "surface-container-low": "#181c22",
                        "on-secondary-fixed-variant": "#5a00c6",
                        "on-secondary-container": "#c9aeff",
                        "on-secondary": "#3f008e",
                        "surface-container": "#1c2026",
                        "tertiary-container": "#bf5400",
                        "tertiary": "#ffb690",
                        "primary-fixed-dim": "#c0c1ff",
                        "on-background": "#dfe2eb",
                        "inverse-on-surface": "#2d3137",
                        "background": "#10141a",
                        "on-surface-variant": "#c6c4d8",
                        "tertiary-fixed": "#ffdbca",
                        "surface-container-lowest": "#0a0e14",
                        "error-container": "#93000a",
                        "on-primary-fixed": "#06006c"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "lg": "24px",
                        "margin-desktop": "120px",
                        "margin-mobile": "16px",
                        "md": "16px",
                        "base": "4px",
                        "xs": "4px",
                        "gutter": "16px",
                        "sm": "8px",
                        "xl": "32px",
                        "2xl": "48px"
                    },
                    "fontFamily": {
                        "headline-lg-mobile": ["Inter", "sans-serif"],
                        "body-lg": ["Inter", "sans-serif"],
                        "display-lg": ["Inter", "sans-serif"],
                        "body-md": ["Inter", "sans-serif"],
                        "headline-md": ["Inter", "sans-serif"],
                        "label-md": ["Inter", "sans-serif"],
                        "headline-lg": ["Inter", "sans-serif"],
                        "label-sm": ["Inter", "sans-serif"]
                    },
                    "fontSize": {
                        "headline-lg-mobile": ["28px", { "lineHeight": "34px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "body-lg": ["18px", { "lineHeight": "28px", "letterSpacing": "0em", "fontWeight": "400" }],
                        "display-lg": ["48px", { "lineHeight": "56px", "letterSpacing": "-0.04em", "fontWeight": "800" }],
                        "body-md": ["16px", { "lineHeight": "24px", "letterSpacing": "0em", "fontWeight": "400" }],
                        "headline-md": ["24px", { "lineHeight": "30px", "letterSpacing": "-0.01em", "fontWeight": "600" }],
                        "label-md": ["14px", { "lineHeight": "20px", "letterSpacing": "0.02em", "fontWeight": "600" }],
                        "headline-lg": ["32px", { "lineHeight": "40px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "label-sm": ["12px", { "lineHeight": "16px", "letterSpacing": "0.04em", "fontWeight": "500" }]
                    }
                }
            }
        }
    </script>
<style>
    body {
      min-height: max(884px, 100dvh);
    }
  </style>
  </head>
<body class="bg-background text-on-background min-h-screen relative overflow-x-hidden flex flex-col antialiased selection:bg-primary-container selection:text-on-primary-container">
<!-- Ambient Background Effects -->
<div class="fixed top-[-10%] left-[-10%] w-[50vw] h-[50vw] rounded-full bg-secondary-container/10 blur-[100px] pointer-events-none"></div>
<div class="fixed bottom-[-10%] right-[-10%] w-[60vw] h-[60vw] rounded-full bg-primary-container/10 blur-[120px] pointer-events-none"></div>
<main class="flex-grow flex flex-col items-center justify-center p-margin-mobile md:p-margin-desktop w-full max-w-[600px] mx-auto z-10">
<!-- Header -->
<header class="text-center mb-xl w-full">
<h1 class="font-display-lg text-display-lg bg-clip-text text-transparent bg-gradient-to-r from-secondary-container to-primary-container tracking-tighter">VIBE</h1>
<p class="font-body-lg text-body-lg text-on-surface-variant mt-sm">Create your identity.</p>
</header>
<form action="{{ route('feed') }}" class="w-full space-y-lg flex flex-col" method="GET">
<!-- Step 1: Identity Card (Glassmorphism) -->
<div class="backdrop-blur-[20px] bg-white/5 border-t border-l border-white/10 rounded-xl p-lg shadow-[0_30px_60px_rgba(0,0,0,0.4)] relative overflow-hidden group/card">
<div class="absolute inset-0 bg-gradient-to-br from-surface-container/50 to-transparent z-[-1]"></div>
<h2 class="font-headline-md text-headline-md text-on-surface mb-lg flex items-center gap-sm">
<span class="w-8 h-8 rounded-full bg-primary-container/20 flex items-center justify-center text-primary font-label-md text-label-md">1</span>
                    Profile
                </h2>
<!-- Profile Image Upload -->
<div class="flex justify-center mb-lg">
<div class="relative w-24 h-24 rounded-full bg-surface-container-high border-2 border-dashed border-outline-variant flex items-center justify-center cursor-pointer hover:border-primary hover:bg-surface-variant transition-all duration-300 group overflow-hidden">
<span class="material-symbols-outlined text-outline-variant group-hover:text-primary text-[32px] transition-colors" data-icon="add_a_photo">add_a_photo</span>
<!-- Subtle inner glow on hover -->
<div class="absolute inset-0 rounded-full shadow-[inset_0_0_20px_rgba(91,94,255,0)] group-hover:shadow-[inset_0_0_20px_rgba(91,94,255,0.2)] transition-shadow"></div>
</div>
</div>
<!-- Inputs Grid -->
<div class="space-y-md">
<div class="flex flex-col gap-xs">
<label class="font-label-md text-label-md text-on-surface-variant ml-1">Username</label>
<input class="bg-transparent border-b border-outline-variant focus:border-primary text-on-surface font-body-md text-body-md py-sm px-1 focus:outline-none transition-colors placeholder:text-on-surface-variant/40 w-full" placeholder="@yourhandle" type="text"/>
</div>
<div class="flex flex-col gap-xs">
<label class="font-label-md text-label-md text-on-surface-variant ml-1">Full Name</label>
<input class="bg-transparent border-b border-outline-variant focus:border-primary text-on-surface font-body-md text-body-md py-sm px-1 focus:outline-none transition-colors placeholder:text-on-surface-variant/40 w-full" placeholder="Alex Rivers" type="text"/>
</div>
<div class="flex flex-col gap-xs">
<label class="font-label-md text-label-md text-on-surface-variant ml-1">Email</label>
<input class="bg-transparent border-b border-outline-variant focus:border-primary text-on-surface font-body-md text-body-md py-sm px-1 focus:outline-none transition-colors placeholder:text-on-surface-variant/40 w-full" placeholder="alex@vibe.app" type="email"/>
</div>
<div class="flex flex-col gap-xs">
<label class="font-label-md text-label-md text-on-surface-variant ml-1">Password</label>
<div class="relative">
<input class="bg-transparent border-b border-outline-variant focus:border-primary text-on-surface font-body-md text-body-md py-sm px-1 focus:outline-none transition-colors placeholder:text-on-surface-variant/40 w-full pr-10" placeholder="••••••••" type="password"/>
<span class="material-symbols-outlined absolute right-2 top-1/2 -translate-y-1/2 text-on-surface-variant/60 cursor-pointer hover:text-on-surface text-[20px]" data-icon="visibility">visibility</span>
</div>
</div>
</div>
</div>
<!-- Step 2: Interests Card (Glassmorphism) -->
<div class="backdrop-blur-[20px] bg-white/5 border-t border-l border-white/10 rounded-xl p-lg shadow-[0_30px_60px_rgba(0,0,0,0.4)] relative overflow-hidden">
<div class="absolute inset-0 bg-gradient-to-br from-surface-container/50 to-transparent z-[-1]"></div>
<h2 class="font-headline-md text-headline-md text-on-surface flex items-center gap-sm">
<span class="w-8 h-8 rounded-full bg-secondary-container/20 flex items-center justify-center text-secondary font-label-md text-label-md">2</span>
                    Your Vibe
                </h2>
<p class="font-body-md text-body-md text-on-surface-variant mt-xs mb-md ml-10">Select at least 3 interests to personalize your feed.</p>
<!-- Chips Container -->
<div class="flex flex-wrap gap-sm mt-sm pl-10" id="interest-chips">
<!-- Chip items with interactive states -->
<button class="px-4 py-2 rounded-full border border-outline-variant text-on-surface-variant font-label-sm text-label-sm cursor-pointer hover:bg-secondary-container/30 hover:text-secondary-fixed hover:border-secondary transition-all" type="button">Music</button>
<button class="px-4 py-2 rounded-full border border-outline-variant text-on-surface-variant font-label-sm text-label-sm cursor-pointer hover:bg-secondary-container/30 hover:text-secondary-fixed hover:border-secondary transition-all" type="button">Art &amp; Design</button>
<button class="px-4 py-2 rounded-full border border-secondary text-secondary-fixed bg-secondary-container/40 font-label-sm text-label-sm cursor-pointer transition-all shadow-[0_0_15px_rgba(96,1,209,0.2)]" type="button">Gaming</button> <!-- Pre-selected state example -->
<button class="px-4 py-2 rounded-full border border-outline-variant text-on-surface-variant font-label-sm text-label-sm cursor-pointer hover:bg-secondary-container/30 hover:text-secondary-fixed hover:border-secondary transition-all" type="button">Technology</button>
<button class="px-4 py-2 rounded-full border border-secondary text-secondary-fixed bg-secondary-container/40 font-label-sm text-label-sm cursor-pointer transition-all shadow-[0_0_15px_rgba(96,1,209,0.2)]" type="button">Fashion</button> <!-- Pre-selected state example -->
<button class="px-4 py-2 rounded-full border border-outline-variant text-on-surface-variant font-label-sm text-label-sm cursor-pointer hover:bg-secondary-container/30 hover:text-secondary-fixed hover:border-secondary transition-all" type="button">Sports</button>
<button class="px-4 py-2 rounded-full border border-outline-variant text-on-surface-variant font-label-sm text-label-sm cursor-pointer hover:bg-secondary-container/30 hover:text-secondary-fixed hover:border-secondary transition-all" type="button">Photography</button>
<button class="px-4 py-2 rounded-full border border-outline-variant text-on-surface-variant font-label-sm text-label-sm cursor-pointer hover:bg-secondary-container/30 hover:text-secondary-fixed hover:border-secondary transition-all" type="button">Travel</button>
</div>
</div>
<!-- Action Area -->
<div class="pt-md">
<button class="w-full py-4 rounded-xl font-label-md text-label-md text-on-primary-container bg-gradient-to-r from-secondary-container to-primary-container shadow-[0_15px_40px_rgba(91,94,255,0.2)] hover:shadow-[0_20px_50px_rgba(91,94,255,0.4)] hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 relative overflow-hidden group" type="submit">
<!-- Premium inner glow -->
<div class="absolute inset-0 border-t border-white/30 rounded-xl pointer-events-none"></div>
<span class="relative z-10 flex items-center justify-center gap-xs">
                        Create Account
                        <span class="material-symbols-outlined text-[18px]" data-icon="arrow_forward">arrow_forward</span>
</span>
<!-- Hover sheen effect -->
<div class="absolute top-0 -inset-full h-full w-1/2 z-5 block transform -skew-x-12 bg-gradient-to-r from-transparent to-white opacity-20 group-hover:animate-[shimmer_1.5s_infinite]"></div>
</button>
<p class="font-body-md text-body-md text-center text-on-surface-variant/60 mt-lg">
                    Already have an account? <a class="text-primary hover:text-primary-fixed transition-colors" href="{{ route('login') }}">Log in</a>
</p>
</div>
</form>
</main>
<style>
        @keyframes shimmer {
            100% {
                left: 200%;
            }
        }
    </style>
<script>
        // Simple script to toggle chip selection for demonstration
        document.addEventListener('DOMContentLoaded', () => {
            const chipsContainer = document.getElementById('interest-chips');
            if(chipsContainer) {
                chipsContainer.addEventListener('click', (e) => {
                    if(e.target.tagName === 'BUTTON') {
                        const isSelected = e.target.classList.contains('bg-secondary-container/40');
                        
                        if(isSelected) {
                            // Deselect
                            e.target.classList.remove('bg-secondary-container/40', 'border-secondary', 'text-secondary-fixed', 'shadow-[0_0_15px_rgba(96,1,209,0.2)]');
                            e.target.classList.add('border-outline-variant', 'text-on-surface-variant');
                        } else {
                            // Select
                            e.target.classList.remove('border-outline-variant', 'text-on-surface-variant');
                            e.target.classList.add('bg-secondary-container/40', 'border-secondary', 'text-secondary-fixed', 'shadow-[0_0_15px_rgba(96,1,209,0.2)]');
                        }
                    }
                });
            }
        });
    </script>
</body></html>
