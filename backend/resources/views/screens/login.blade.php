<!DOCTYPE html>

<html class="dark" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>VIBE - Login</title>
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
                    }
                }
            }
        }
    </script>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet"/>
<style>
        .glass-panel {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(40px);
            -webkit-backdrop-filter: blur(40px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .input-glass {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid transparent;
            transition: all 0.3s ease;
        }
        .input-glass:focus {
            border-bottom-color: #5B5EFF;
            background: rgba(255, 255, 255, 0.08);
            outline: none;
            box-shadow: 0 4px 20px rgba(91, 94, 255, 0.1);
        }
        .input-glass::placeholder {
            color: #908fa1;
        }
    </style>
<style>
    body {
      min-height: max(884px, 100dvh);
    }
  </style>
  </head>
<body class="bg-surface text-on-surface min-h-screen flex items-center justify-center relative overflow-hidden font-body-md text-body-md">
<div class="absolute top-[-10%] left-[-10%] w-[50vw] h-[50vw] rounded-full bg-primary-container/20 blur-[120px] pointer-events-none"></div>
<div class="absolute bottom-[-10%] right-[-10%] w-[40vw] h-[40vw] rounded-full bg-secondary-container/20 blur-[100px] pointer-events-none"></div>
<main class="relative z-10 w-full max-w-[440px] px-margin-mobile">
<div class="text-center mb-xl">
<h1 class="font-display-lg text-display-lg bg-clip-text text-transparent bg-gradient-to-r from-secondary-container to-primary-container tracking-tight">VIBE</h1>
<p class="font-body-lg text-body-lg text-on-surface-variant mt-sm">Welcome back to the vibe.</p>
</div>
<div class="glass-panel rounded-[24px] p-lg sm:p-xl shadow-[0_30px_60px_rgba(0,0,0,0.4)] relative">
<form action="{{ route('feed') }}" class="space-y-lg" method="GET">
<div>
<label class="block font-label-md text-label-md text-on-surface-variant mb-xs" for="email">Email Address</label>
<div class="relative">
<span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant">mail</span>
<input class="input-glass w-full rounded-xl py-3 pl-12 pr-4 text-on-surface font-body-md text-body-md focus:ring-0" id="email" name="email" placeholder="Enter your email" required="" type="email"/>
</div>
</div>
<div>
<label class="block font-label-md text-label-md text-on-surface-variant mb-xs" for="password">Password</label>
<div class="relative">
<span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant">lock</span>
<input class="input-glass w-full rounded-xl py-3 pl-12 pr-12 text-on-surface font-body-md text-body-md focus:ring-0" id="password" name="password" placeholder="Enter your password" required="" type="password"/>
<button class="absolute right-4 top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-primary transition-colors" type="button">
<span class="material-symbols-outlined">visibility</span>
</button>
</div>
</div>
<div class="flex items-center justify-between">
<label class="flex items-center gap-2 cursor-pointer group">
<input class="w-4 h-4 rounded border-outline-variant bg-surface-container-high text-primary-container focus:ring-primary focus:ring-offset-surface focus:ring-offset-2" type="checkbox"/>
<span class="font-label-md text-label-md text-on-surface-variant group-hover:text-on-surface transition-colors">Remember me</span>
</label>
<a class="font-label-md text-label-md text-primary hover:text-primary-fixed transition-colors" href="#">Forgot Password?</a>
</div>
<button class="w-full relative overflow-hidden group rounded-full bg-gradient-to-r from-primary-container to-secondary-container py-4 px-6 font-label-md text-label-md text-on-primary-container shadow-[0_10px_30px_rgba(91,94,255,0.3)] hover:shadow-[0_15px_40px_rgba(91,94,255,0.5)] hover:-translate-y-0.5 transition-all duration-300 border-t border-white/20" type="submit">
<div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
<span class="relative z-10 font-bold">Login to VIBE</span>
</button>
</form>
<div class="my-lg flex items-center gap-4">
<div class="h-px flex-1 bg-gradient-to-r from-transparent via-outline-variant/50 to-transparent"></div>
<span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Or continue with</span>
<div class="h-px flex-1 bg-gradient-to-r from-transparent via-outline-variant/50 to-transparent"></div>
</div>
<div class="grid grid-cols-2 gap-4">
<button class="glass-panel flex items-center justify-center gap-2 py-3 rounded-xl hover:bg-white/10 transition-colors group">
<svg class="w-5 h-5 text-on-surface group-hover:scale-110 transition-transform" fill="currentColor" viewbox="0 0 24 24">
<path d="M12.152 6.896c-.948 0-2.415-1.078-3.96-1.04-2.04.027-3.91 1.183-4.961 3.014-2.117 3.675-.546 9.103 1.519 12.09 1.013 1.454 2.208 3.128 3.801 3.07 1.531-.059 2.115-.989 3.961-.989 1.83 0 2.37.989 3.978.96 1.637-.027 2.65-1.528 3.65-2.981 1.157-1.69 1.635-3.328 1.66-3.415-.035-.013-3.181-1.22-3.21-4.856-.026-3.04 2.482-4.494 2.597-4.559-1.429-2.09-3.623-2.324-4.39-2.376-2-.156-3.675 1.09-4.645 1.09zM15.53 3.83c.843-1.012 1.4-2.427 1.245-3.83-1.207.05-2.762.807-3.63 1.81-.767.876-1.439 2.336-1.253 3.706 1.348.106 2.793-.67 3.638-1.686z"></path>
</svg>
<span class="font-label-md text-label-md text-on-surface">Apple</span>
</button>
<button class="glass-panel flex items-center justify-center gap-2 py-3 rounded-xl hover:bg-white/10 transition-colors group">
<svg class="w-5 h-5 group-hover:scale-110 transition-transform" viewbox="0 0 24 24">
<path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"></path>
<path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"></path>
<path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"></path>
<path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"></path>
</svg>
<span class="font-label-md text-label-md text-on-surface">Google</span>
</button>
</div>
</div>
<p class="text-center mt-lg font-body-md text-body-md text-on-surface-variant">
            Don't have an account? 
            <a class="font-label-md text-label-md text-primary hover:text-primary-fixed transition-colors border-b border-primary/30 pb-0.5" href="{{ route('register') }}">Sign up</a>
</p>
</main>
</body></html>
