---
name: Lumina
colors:
  surface: '#10141a'
  surface-dim: '#10141a'
  surface-bright: '#353940'
  surface-container-lowest: '#0a0e14'
  surface-container-low: '#181c22'
  surface-container: '#1c2026'
  surface-container-high: '#262a31'
  surface-container-highest: '#31353c'
  on-surface: '#dfe2eb'
  on-surface-variant: '#c6c4d8'
  inverse-surface: '#dfe2eb'
  inverse-on-surface: '#2d3137'
  outline: '#908fa1'
  outline-variant: '#454555'
  surface-tint: '#c0c1ff'
  primary: '#c0c1ff'
  on-primary: '#0f00aa'
  primary-container: '#5b5eff'
  on-primary-container: '#fefaff'
  inverse-primary: '#4345e8'
  secondary: '#d2bbff'
  on-secondary: '#3f008e'
  secondary-container: '#6001d1'
  on-secondary-container: '#c9aeff'
  tertiary: '#ffb690'
  on-tertiary: '#542100'
  tertiary-container: '#bf5400'
  on-tertiary-container: '#fffbfa'
  error: '#ffb4ab'
  on-error: '#690005'
  error-container: '#93000a'
  on-error-container: '#ffdad6'
  primary-fixed: '#e1e0ff'
  primary-fixed-dim: '#c0c1ff'
  on-primary-fixed: '#06006c'
  on-primary-fixed-variant: '#2723d1'
  secondary-fixed: '#eaddff'
  secondary-fixed-dim: '#d2bbff'
  on-secondary-fixed: '#25005a'
  on-secondary-fixed-variant: '#5a00c6'
  tertiary-fixed: '#ffdbca'
  tertiary-fixed-dim: '#ffb690'
  on-tertiary-fixed: '#331100'
  on-tertiary-fixed-variant: '#783200'
  background: '#10141a'
  on-background: '#dfe2eb'
  surface-variant: '#31353c'
typography:
  display-lg:
    fontFamily: Inter
    fontSize: 48px
    fontWeight: '800'
    lineHeight: 56px
    letterSpacing: -0.04em
  headline-lg:
    fontFamily: Inter
    fontSize: 32px
    fontWeight: '700'
    lineHeight: 40px
    letterSpacing: -0.02em
  headline-lg-mobile:
    fontFamily: Inter
    fontSize: 28px
    fontWeight: '700'
    lineHeight: 34px
    letterSpacing: -0.02em
  headline-md:
    fontFamily: Inter
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 30px
    letterSpacing: -0.01em
  body-lg:
    fontFamily: Inter
    fontSize: 18px
    fontWeight: '400'
    lineHeight: 28px
    letterSpacing: 0em
  body-md:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
    letterSpacing: 0em
  label-md:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '600'
    lineHeight: 20px
    letterSpacing: 0.02em
  label-sm:
    fontFamily: Inter
    fontSize: 12px
    fontWeight: '500'
    lineHeight: 16px
    letterSpacing: 0.04em
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  base: 4px
  xs: 4px
  sm: 8px
  md: 16px
  lg: 24px
  xl: 32px
  2xl: 48px
  gutter: 16px
  margin-mobile: 16px
  margin-desktop: 120px
---

## Brand & Style

The design system is engineered for a premium, high-energy social media environment centered on vertical video. It merges the structural clarity of high-end productivity tools with the immersive, tactile nature of modern entertainment platforms.

The aesthetic follows a "Hyper-Refined Glassmorphism" approach. This involves layering translucent surfaces over deep, vibrant backgrounds to create a sense of physical space and hierarchy. The interface prioritizes content immersion, using subtle frosted glass effects to ensure UI controls feel lightweight and secondary to the video medium. 

Key emotional drivers are:
- **Focus:** Interface elements recede when not in use.
- **Fluidity:** Smooth transitions and micro-interactions mimic physical motion.
- **Prestige:** High-contrast typography and generous white space evoke a premium, editorial feel.

## Colors

The palette is optimized for high-dynamic-range content. While the design system supports both light and dark modes, the primary experience is tailored for **Dark Mode** to minimize bezel distraction during video playback.

- **Primary & Secondary:** Used for high-priority actions and brand moments. The gradient transition from Deep Purple to Vibrant Blue serves as the signature interactive state.
- **Accent:** Reserved for notifications, live indicators, and specific call-to-actions that require immediate visual pop.
- **Surface Strategy:** 
    - **Dark Mode:** Deep Navy (`#0D1117`) as the base layer, with semi-transparent overlays (`rgba(255, 255, 255, 0.08)`) for cards.
    - **Light Mode:** Pure White (`#FFFFFF`) base with soft, cool-grey elevations and high-transparency glass layers.

## Typography

This design system utilizes **Inter** for its neutral, systematic utility and exceptional legibility at small sizes. 

- **Weight Strategy:** Use `ExtraBold` (800) for display headers to create an editorial impact. `SemiBold` (600) is preferred for interactive labels to ensure clarity against vibrant backgrounds.
- **Scaling:** Headlines shift significantly between mobile and desktop to maintain visual balance. Mobile headers favor tighter line heights to accommodate more vertical content.
- **Micro-copy:** Small labels (12px) should always use slightly increased letter spacing (0.04em) and medium/bold weights to ensure they don't get lost when placed over blurred video backgrounds.

## Layout & Spacing

This design system uses a 4px baseline grid to ensure mathematical harmony across all components.

- **Mobile Layout:** A single-column fluid layout with 16px side margins. Video content should be edge-to-edge (0px margin) to maximize immersion, with UI controls overlaid within safe areas.
- **Desktop/Tablet Layout:** A centered 12-column fixed-width grid (max-width 1200px). On wide screens, the video feed occupies the central 6 columns, while navigation and discovery tools occupy the side rails.
- **Safe Areas:** Implement a 48px top safe area and 32px bottom safe area for floating navigation bars to ensure accessibility on devices with notches and home indicators.

## Elevation & Depth

Elevation is communicated through **transparency and blur** rather than traditional opaque shadows.

- **Level 0 (Base):** Deep Navy or White background.
- **Level 1 (Cards):** 10% opacity white/black fill with a 20px backdrop blur and a 1px "glass-stroke" border (top-weighted).
- **Level 2 (Floating UI/Modals):** 20% opacity fill with 40px backdrop blur. These elements use an "Ambient Shadow": a soft, 30px blur shadow with 15% opacity, tinted with the Primary Indigo color (`#5B5EFF`).
- **Level 3 (Interactive):** Elements that are actively being touched or hovered scale by 2% and increase shadow spread to create a tactile "lifting" effect.

## Shapes

The shape language is "Optimistically Rounded." 

- **Standard Elements:** Buttons and input fields use a `0.5rem` (8px) radius.
- **Content Containers:** Video cards and main feed containers use `1rem` (16px) or `1.5rem` (24px) to create a soft, friendly framing for sharp video content.
- **Floating Navigation:** Uses a full pill-shape (`rounded-full`) to differentiate itself from content and emphasize its role as a persistent utility.
- **Interactive States:** When a card is expanded, its corner radius should animate to a sharper state (8px) to maximize screen real estate.

## Components

- **Buttons:** Primary buttons use the `primary-interactive` gradient with white text. They should have a subtle inner glow (1px white at 10% opacity) on the top edge to enhance the "premium" tactile feel.
- **Frosted Cards:** Every card must have a `backdrop-filter: blur(20px)`. Borders are mandatory; they should be a 1px solid line with 10% white opacity in dark mode to define the card's silhouette against dark video content.
- **Floating Navigation:** A bottom-anchored, pill-shaped bar. The background is a high-blur glass layer. The active icon should trigger a "ripple" or "pulse" animation in the Primary Blue color.
- **Input Fields:** Minimalist design with only a bottom border or a very subtle semi-transparent fill. On focus, the bottom border should animate to the `primary-interactive` gradient.
- **Chips/Tags:** Small, pill-shaped elements with 40% opacity secondary color backgrounds. Use these for categories or video metadata.
- **Video Controls:** Vertical stack on the right side for likes, comments, and shares. Icons should have a soft drop shadow (2px blur, 50% black opacity) to remain visible over light video scenes.