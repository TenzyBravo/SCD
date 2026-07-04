# The Safe Center For Development — Website

Static HTML/CSS/JS site. Postgres integration to follow.

## Structure

```
safe-center-web/
├── index.html          Home
├── about.html          About
├── focus.html          Areas of Focus
├── support.html        Support Units
├── media.html          News, press, downloads
├── training.html       Courses + registration form
├── toolkits.html       Publications & downloads
├── jobs.html           Careers + application form
├── contact.html        Contact, map, offices
├── css/styles.css      Full design system + dark mode
├── js/main.js          Nav, theme, reveal, counters, slider, forms
└── assets/images/      Drop the logo + real photos here
```

## Run locally

Any static server works. Simplest:

```bash
cd safe-center-web
python3 -m http.server 8080
# then open http://localhost:8080
```

Or with Node:

```bash
npx serve .
```

## Swapping in real assets

- **Logo**: replace the `<span class="brand-mark">SCD</span>` block in every HTML file's header/footer with `<img src="assets/images/logo.svg" alt="The Safe Center For Development" />`. Size ~42×42 in the header.
- **Hero image**: change the URL in `css/styles.css` under `.hero::before`.
- **Program/news photos**: swap the Unsplash `src` attributes on `.card-media img`.

## Next step: Postgres backend

The forms (newsletter, training registration, job application, contact) all post through `initForms()` in `js/main.js`. When the backend is ready, replace the `setTimeout` stub inside that function with a `fetch()` to your API. Suggested endpoints:

- `POST /api/newsletter`
- `POST /api/training/register`
- `POST /api/jobs/apply` (multipart for CV + cover letter)
- `POST /api/contact`
- `GET  /api/news`, `GET /api/jobs`, `GET /api/toolkits` — to make Media/Jobs/Toolkits pages dynamic

Any Postgres-friendly stack works (Node/Express, Fastify, Django, Laravel, etc.). Pick whichever you're comfortable maintaining.

## Features shipped

- Fully responsive, sticky nav with mobile drawer
- Dark mode toggle (persisted)
- Scroll reveal animations, animated counters, autoplay testimonial slider
- Partner logo marquee, back-to-top button, skip link, reduced-motion support
- Accessible forms with client-side stub submission
- SEO meta + OG tags, semantic HTML
- Google Fonts (Poppins + Inter), emerald/gold palette per brief

## Known placeholders

- Logo (using text mark "SCD" — swap for real file when supplied)
- All body copy is plausible sample text — replace with approved SCD copy
- Photos are Unsplash CDN links — swap for real field photos
- Google Map is an OpenStreetMap embed with approximate Lusaka coordinates — swap for real address embed
