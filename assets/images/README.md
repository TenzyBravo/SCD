# Images

Drop images here. Recommended file naming: kebab-case, lowercase (e.g. `youth-training-kitwe.jpg`).

## Structure

```
assets/images/
├── logo.png              ← MAIN LOGO (referenced by every page's header & footer)
├── logo/                 ← Logo variants: logo-white.png, logo-dark.png, favicon.ico, etc.
├── hero/                 ← Full-width hero background photos (min 1920×1080)
├── programs/             ← Program/thematic photos for cards (recommended 800×500)
├── team/                 ← Leadership & staff portraits (recommended 600×600, square crop)
├── news/                 ← News/blog article images (recommended 800×500)
├── stories/              ← Beneficiary photos for testimonial slider (recommended 400×400, square)
├── gallery/              ← Media page photo gallery
├── partners/             ← Partner/donor logos (transparent PNG or SVG)
└── icons/                ← Custom icons if you want to replace the emoji icons
```

## Optimization tips

- Compress before uploading (use tinypng.com, squoosh.app, or `imagemin`)
- Prefer `.webp` for photos where possible; fall back to `.jpg` at ~80% quality
- Use `.svg` for logos and icons — they scale infinitely
- Aim for < 200 KB per photo, < 50 KB per thumbnail

## Referencing images from HTML

Local file:
```html
<img src="assets/images/programs/health-outreach.jpg" alt="Health outreach in Kitwe" />
```

The current pages use Unsplash CDN placeholders — swap them for local paths once you have your own photos.
