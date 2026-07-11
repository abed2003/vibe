<!DOCTYPE html>

<html class="dark" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>VIBE - Loading</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
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
                        "headline-lg-mobile": ["Inter"],
                        "body-lg": ["Inter"],
                        "display-lg": ["Inter"],
                        "body-md": ["Inter"],
                        "headline-md": ["Inter"],
                        "label-md": ["Inter"],
                        "headline-lg": ["Inter"],
                        "label-sm": ["Inter"]
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
                    },
                    "animation": {
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'progress': 'progress 2s ease-in-out infinite',
                        'fade-in': 'fadeIn 1s ease-out forwards'
                    },
                    "keyframes": {
                        progress: {
                            '0%': { width: '0%', marginLeft: '0%' },
                            '50%': { width: '50%', marginLeft: '25%' },
                            '100%': { width: '0%', marginLeft: '100%' }
                        },
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(10px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        }
                    }
                }
            }
        }
    </script>
<style>
        .glass-gradient {
            background: linear-gradient(135deg, #0D1117 0%, #1a1e2e 50%, #5B5EFF 150%);
        }
        
        .text-gradient {
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-image: linear-gradient(90deg, #d2bbff 0%, #c0c1ff 100%);
        }
    </style>
<style>
    body {
      min-height: max(884px, 100dvh);
    }
  </style>
  </head>
<body class="glass-gradient min-h-screen w-full flex flex-col items-center justify-center relative overflow-hidden text-on-background m-0 p-0">
<!-- Decorative background elements -->
<div class="absolute inset-0 pointer-events-none overflow-hidden">
<div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary-container/20 rounded-full blur-[100px] animate-pulse-slow"></div>
<div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-secondary-container/20 rounded-full blur-[100px] animate-pulse-slow" style="animation-delay: 1.5s;"></div>
</div>
<!-- Main Content Canvas -->
<main class="z-10 flex flex-col items-center justify-center flex-1 w-full max-w-md px-margin-mobile">
<!-- Logo Area -->
<div class="flex flex-col items-center justify-center mb-xl animate-fade-in">
<!-- Icon/Symbol -->
<div class="w-24 h-24 rounded-3xl bg-white/5 backdrop-blur-2xl border border-white/10 flex items-center justify-center shadow-[0_20px_50px_rgba(91,94,255,0.2)] mb-lg relative overflow-hidden group">
<div class="absolute inset-0 bg-gradient-to-tr from-primary-container/30 to-secondary-container/30 opacity-50 group-hover:opacity-100 transition-opacity duration-500"></div>
<span class="material-symbols-outlined text-display-lg text-primary z-10" data-icon="all_inclusive" style="font-variation-settings: 'FILL' 1;">all_inclusive</span>
</div>
<!-- Brand Name -->
<h1 class="font-display-lg text-display-lg text-gradient tracking-tighter drop-shadow-lg">VIBE</h1>
<p class="font-label-md text-label-md text-on-surface-variant/60 mt-xs uppercase tracking-widest">Connect your world</p>
</div>
</main>
<!-- Bottom Loading Area -->
<div class="absolute bottom-12 w-full max-w-[200px] px-margin-mobile flex flex-col items-center z-10 animate-fade-in" style="animation-delay: 0.5s;">
<div class="w-full h-1 bg-white/10 rounded-full overflow-hidden relative backdrop-blur-sm">
<div class="absolute top-0 bottom-0 left-0 bg-primary-container rounded-full animate-progress shadow-[0_0_10px_rgba(91,94,255,0.8)]"></div>
</div>
<span class="font-label-sm text-label-sm text-on-surface-variant/40 mt-sm tracking-widest uppercase">Initializing...</span>
</div>
<!-- Script for subtle interactive effect -->
<script>
        document.addEventListener('mousemove', (e) => {
            const x = e.clientX / window.innerWidth;
            const y = e.clientY / window.innerHeight;
            
            document.body.style.backgroundPosition = `${x * 10}% ${y * 10}%`;
        });
    </script>
</body></html>