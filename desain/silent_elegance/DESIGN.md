---
name: Silent Elegance
colors:
  surface: '#faf9f6'
  surface-dim: '#dbdad7'
  surface-bright: '#faf9f6'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f4f3f1'
  surface-container: '#efeeeb'
  surface-container-high: '#e9e8e5'
  surface-container-highest: '#e3e2e0'
  on-surface: '#1a1c1a'
  on-surface-variant: '#4e463a'
  inverse-surface: '#2f312f'
  inverse-on-surface: '#f2f1ee'
  outline: '#807668'
  outline-variant: '#d1c5b5'
  surface-tint: '#765a27'
  primary: '#765a27'
  on-primary: '#ffffff'
  primary-container: '#b5935b'
  on-primary-container: '#422c00'
  inverse-primary: '#e7c185'
  secondary: '#605e58'
  on-secondary: '#ffffff'
  secondary-container: '#e6e2da'
  on-secondary-container: '#66645e'
  tertiary: '#5f5e5e'
  on-tertiary: '#ffffff'
  tertiary-container: '#999898'
  on-tertiary-container: '#313030'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#ffdeab'
  primary-fixed-dim: '#e7c185'
  on-primary-fixed: '#271900'
  on-primary-fixed-variant: '#5c4212'
  secondary-fixed: '#e6e2da'
  secondary-fixed-dim: '#c9c6bf'
  on-secondary-fixed: '#1c1c17'
  on-secondary-fixed-variant: '#484741'
  tertiary-fixed: '#e4e2e1'
  tertiary-fixed-dim: '#c8c6c6'
  on-tertiary-fixed: '#1b1c1c'
  on-tertiary-fixed-variant: '#474747'
  background: '#faf9f6'
  on-background: '#1a1c1a'
  surface-variant: '#e3e2e0'
typography:
  display-lg:
    fontFamily: EB Garamond
    fontSize: 48px
    fontWeight: '500'
    lineHeight: '1.1'
    letterSpacing: -0.02em
  headline-lg:
    fontFamily: EB Garamond
    fontSize: 32px
    fontWeight: '500'
    lineHeight: '1.2'
  headline-lg-mobile:
    fontFamily: EB Garamond
    fontSize: 28px
    fontWeight: '500'
    lineHeight: '1.2'
  headline-md:
    fontFamily: EB Garamond
    fontSize: 24px
    fontWeight: '500'
    lineHeight: '1.3'
  body-lg:
    fontFamily: Hanken Grotesk
    fontSize: 18px
    fontWeight: '400'
    lineHeight: '1.6'
  body-md:
    fontFamily: Hanken Grotesk
    fontSize: 16px
    fontWeight: '400'
    lineHeight: '1.6'
  label-md:
    fontFamily: Hanken Grotesk
    fontSize: 14px
    fontWeight: '600'
    lineHeight: '1.4'
    letterSpacing: 0.05em
  caption:
    fontFamily: Hanken Grotesk
    fontSize: 12px
    fontWeight: '400'
    lineHeight: '1.4'
rounded:
  sm: 0.125rem
  DEFAULT: 0.25rem
  md: 0.375rem
  lg: 0.5rem
  xl: 0.75rem
  full: 9999px
spacing:
  unit: 8px
  container-max: 1120px
  gutter: 24px
  margin-desktop: 64px
  margin-mobile: 20px
  stack-sm: 16px
  stack-md: 32px
  stack-lg: 64px
---

## Brand & Style

The brand personality is rooted in "Silent Elegance"—a design philosophy that prioritizes reverence, tranquility, and historical weight through a contemporary lens. The target audience includes parishioners seeking spiritual connection and visitors exploring the cathedral's heritage. The UI must evoke a sense of calm, providing a digital sanctuary that feels airy and sophisticated rather than stiff or institutional.

The visual style is **Refined Minimalism**. It leverages expansive whitespace to symbolize openness and peace. Drawing inspiration from modern editorial design, the system avoids heavy ornamentation, instead using high-quality typography and a restricted color palette to convey value. Interaction is guided by soft transitions and subtle depth, ensuring the technology remains a quiet facilitator of the cathedral’s mission.

## Colors

The palette is intentionally muted to maintain a serene atmosphere. 

- **Primary (Antique Gold):** Used sparingly for accents, icons, and primary actions. It should never be used as a gradient or high-gloss finish, but rather as a flat, matte tone that suggests quality.
- **Secondary (Soft Champagne):** Primarily used for container backgrounds, subtle section highlighting, and secondary buttons. It provides a warm transition between the background and content.
- **Deep Charcoal:** The primary color for all long-form text and iconography to ensure high legibility while appearing softer than pure black.
- **Background (Bone White):** A very light off-white (#FAF9F6) serves as the canvas, preventing the "digital glare" of pure #FFFFFF and adding a paper-like, organic quality to the interface.

## Typography

The typographic system relies on a high-contrast pairing of a classic Serif and a modern Sans-Serif.

- **Headlines:** *EB Garamond* provides a sense of history and grace. It should be used for all significant headings. For display sizes, a slight negative letter-spacing enhances the "editorial" feel.
- **Body & Interface:** *Hanken Grotesk* offers exceptional clarity and a contemporary edge. Its generous x-height ensures readability for community news, scriptures, and service times.
- **Labels:** Labels use *Hanken Grotesk* in uppercase with increased letter-spacing to create a clear hierarchy for small metadata or section overviews without needing heavy colors.

## Layout & Spacing

This design system utilizes a **Fixed Grid** approach for desktop to maintain the integrity of the white space, while transitioning to a fluid model for mobile.

- **Desktop:** 12-column grid with a 1120px max-width. Centered layout with generous outer margins (64px) to frame the content.
- **Tablet:** 8-column grid with 32px margins.
- **Mobile:** 4-column grid with 20px margins.
- **Vertical Rhythm:** Spacing is built on an 8px base unit. Use "stack-lg" (64px) between major sections to allow the content to "breathe." Content blocks within sections should favor "stack-md" (32px).

## Elevation & Depth

To maintain the "Silent Elegance" theme, depth is achieved through **Tonal Layers** rather than physical shadows.

1.  **Base Layer:** The Bone White background (#FAF9F6).
2.  **Surface Layer:** Soft Champagne (#F7F3EB) is used for cards or containers that need to stand out slightly. These containers should not have borders.
3.  **Shadows:** When shadows are required for functional elevation (e.g., dropdowns or modals), use an extremely diffused, low-opacity shadow: `box-shadow: 0 4px 20px rgba(45, 45, 45, 0.04)`. The shadow color should be tinted with the Deep Charcoal text color to feel integrated.
4.  **Glassmorphism:** Use very light backdrop blurs (8px to 12px) for sticky navigation bars to keep the sense of space while scrolling.

## Shapes

The shape language is **Soft**. Sharp edges are avoided to ensure the UI feels welcoming and approachable, yet we avoid large "pill" shapes which can feel too casual for a cathedral setting. 

- **Standard Elements:** 0.25rem (4px) corner radius for small inputs and buttons.
- **Large Elements:** 0.5rem (8px) corner radius for cards and image containers.
- **Imagery:** Large hero imagery may occasionally use a "soft-top" radius where only the top corners are rounded, echoing the architectural arches of the cathedral.

## Components

### Buttons
- **Primary:** Antique Gold background, Deep Charcoal text. No border. Soft (4px) corners.
- **Secondary:** Transparent background, Deep Charcoal text, 1px Antique Gold border (low opacity).
- **Ghost:** Deep Charcoal text, no background or border, used for low-priority actions.

### Inputs & Fields
- **Text Fields:** Subtle Soft Champagne background with a 1px bottom border in Antique Gold. Focus state should slightly darken the background color rather than adding a heavy outline.

### Cards
- **Informational Cards:** Soft Champagne background, no border, 8px corner radius. Padding should be generous (min 24px) to prevent text from feeling cramped.

### Chips & Tags
- Used for categorizing events (e.g., "Mass," "Community," "Youth"). Use Soft Champagne background with uppercase Hanken Grotesk labels in Antique Gold.

### Navigation
- Top navigation should be minimal. Use the Serif font for the "Cathedral" logotype and the Sans-Serif for navigation links. Active states are indicated by a simple dot beneath the link in Antique Gold.

### Lists
- Lists in prayer or schedule sections should be separated by very thin (0.5px) Deep Charcoal lines at 10% opacity. Avoid heavy dividers.