<!DOCTYPE html>

<html class="dark" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>VIBE - Welcome</title>
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
                      "headline-lg-mobile": [
                              "Inter"
                      ],
                      "body-lg": [
                              "Inter"
                      ],
                      "display-lg": [
                              "Inter"
                      ],
                      "body-md": [
                              "Inter"
                      ],
                      "headline-md": [
                              "Inter"
                      ],
                      "label-md": [
                              "Inter"
                      ],
                      "headline-lg": [
                              "Inter"
                      ],
                      "label-sm": [
                              "Inter"
                      ]
              },
              "fontSize": {
                      "headline-lg-mobile": [
                              "28px",
                              {
                                      "lineHeight": "34px",
                                      "letterSpacing": "-0.02em",
                                      "fontWeight": "700"
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
                      "headline-md": [
                              "24px",
                              {
                                      "lineHeight": "30px",
                                      "letterSpacing": "-0.01em",
                                      "fontWeight": "600"
                              }
                      ],
                      "label-md": [
                              "14px",
                              {
                                      "lineHeight": "20px",
                                      "letterSpacing": "0.02em",
                                      "fontWeight": "600"
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
                      ]
              }
      },
          },
        }
      </script>
<style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #10141a;
            color: #dfe2eb;
            overflow-x: hidden;
        }
        
        /* Glassmorphism utility classes */
        .glass-panel {
            background: rgba(16, 20, 26, 0.4);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }

        .ambient-shadow {
            box-shadow: 0 0 30px 0 rgba(91, 94, 255, 0.15);
        }

        .primary-gradient-btn {
            background: linear-gradient(135deg, #6001d1 0%, #5b5eff 100%);
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.2), 0 4px 14px rgba(91, 94, 255, 0.3);
        }
        
        /* Subtle background glow effect */
        .bg-glow {
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(91,94,255,0.15) 0%, rgba(16,20,26,0) 70%);
            border-radius: 50%;
            z-index: -1;
            top: -100px;
            right: -200px;
        }
        .bg-glow-secondary {
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(96,1,209,0.1) 0%, rgba(16,20,26,0) 70%);
            border-radius: 50%;
            z-index: -1;
            bottom: -150px;
            left: -150px;
        }
      </style>
<style>
    body {
      min-height: max(884px, 100dvh);
    }
  </style>
  </head>
<body class="bg-background text-on-background min-h-screen relative flex flex-col items-center justify-center">
<!-- Decorative Glows -->
<div class="bg-glow"></div>
<div class="bg-glow-secondary"></div>
<main class="w-full max-w-[1200px] mx-auto px-margin-mobile md:px-margin-desktop py-2xl flex flex-col md:flex-row items-center justify-center gap-xl md:gap-2xl min-h-[795px]">
<!-- Hero Image / Visual Section -->
<div class="w-full md:w-1/2 flex-1 relative flex justify-center items-center">
<!-- Main Hero Image -->
<div class="relative w-full max-w-md aspect-[4/5] rounded-xl overflow-hidden glass-card ambient-shadow p-2 transition-transform duration-500 hover:scale-[1.02]">
<div class="absolute inset-0 bg-gradient-to-t from-background via-transparent to-transparent z-10"></div>
<img class="w-full h-full object-cover rounded-lg" data-alt="A vibrant, high-energy digital illustration in a futuristic social media environment. Young, stylish diverse creators are actively filming vertical video content using sleek modern smartphones. The scene is illuminated by striking neon purple and indigo rim lighting against a deep space-black background, fitting a premium dark mode UI aesthetic." src="https://lh3.googleusercontent.com/aida-public/AB6AXuCqwWOlfvtshLNjro8ZNw-14XhsrhZfhe8PP62kily4D_i1doCH9m4j1IqD9ZWpjcke8kAIgQBw8q95nXGpZfYySCgI8MN-EIVFS6PLfx5eIELe92-iZZo97atD0hEL8_VihhBwg6V3NiSWqc9xJkhDAf9Rl-aByGl_eJCHIdcFO_ogyu602om7N_f_RHpzx0n6si0z_Nt9LT6mEFbXHocni0PCSEOZveT4uqGiix6K3Ff5Zy2PeNhlhsuahP8axCYIiWRhqWlELAc"/>
<!-- Floating Elements over Hero -->
<div class="absolute top-8 right-8 glass-card rounded-full p-3 z-20 animate-[bounce_3s_ease-in-out_infinite]">
<span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">favorite</span>
</div>
<div class="absolute bottom-16 left-8 glass-card rounded-full p-3 z-20 animate-[bounce_4s_ease-in-out_infinite_reverse]">
<span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">videocam</span>
</div>
</div>
</div>
<!-- Content & Actions Section -->
<div class="w-full md:w-1/2 flex-1 flex flex-col justify-center items-center md:items-start text-center md:text-left z-10">
<!-- Brand -->
<div class="mb-sm">
<span class="font-display-lg text-display-lg bg-clip-text text-transparent bg-gradient-to-r from-secondary-container to-primary-container tracking-tight">VIBE</span>
</div>
<!-- Headlines -->
<h1 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface mb-xs">Express Yourself</h1>
<p class="font-body-lg text-body-lg text-on-surface-variant mb-xl max-w-md">Join the Vibe.</p>
<!-- Actions -->
<div class="w-full max-w-xs flex flex-col gap-md">
<a href="{{ route('register') }}" class="w-full primary-gradient-btn text-on-primary-container font-label-md text-label-md py-4 px-6 rounded-full transition-all duration-200 hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-2">
<span>Get Started</span>
<span class="material-symbols-outlined text-[18px]">arrow_forward</span>
</a>
<a href="{{ route('login') }}" class="w-full glass-card text-primary font-label-md text-label-md py-4 px-6 rounded-full transition-all duration-200 hover:bg-white/10 active:scale-95 text-center">
                    Login
</a>
<a href="{{ route('feed') }}" class="w-full text-on-surface-variant/70 font-label-sm text-label-sm py-2 mt-sm hover:text-primary transition-colors duration-200 text-center">
                    Continue as Guest
</a>
</div>
</div>
</main>
</body></html>
