/* The Safe Center For Development — main.js
   Handles: nav toggle, active link, theme, reveal-on-scroll,
   counters, testimonial slider, back-to-top, forms, year stamp. */

document.addEventListener('DOMContentLoaded', () => {
  initYear();
  initNav();
  initTheme();
  initReveal();
  initCounters();
  initSlider();
  initBackToTop();
  initForms();
});

/* ---- Footer year ---- */
function initYear() {
  const y = document.getElementById('year');
  if (y) y.textContent = new Date().getFullYear();
}

/* ---- Mobile nav + active link ---- */
function initNav() {
  const toggle = document.querySelector('.nav-toggle');
  const links = document.querySelector('.nav-links');
  if (toggle && links) {
    toggle.addEventListener('click', () => {
      const open = links.classList.toggle('open');
      toggle.setAttribute('aria-expanded', open);
    });
    links.querySelectorAll('a').forEach(a =>
      a.addEventListener('click', () => links.classList.remove('open'))
    );
  }
  // Active link
  const path = window.location.pathname.split('/').pop() || 'index.html';
  document.querySelectorAll('.nav-links a').forEach(a => {
    if (a.getAttribute('href') === path) a.classList.add('active');
  });
}

/* ---- Dark mode toggle (persisted) ---- */
function initTheme() {
  const btn = document.getElementById('theme-toggle');
  const stored = localStorage.getItem('theme');
  if (stored) document.documentElement.setAttribute('data-theme', stored);
  if (!btn) return;
  btn.addEventListener('click', () => {
    const current = document.documentElement.getAttribute('data-theme');
    const next = current === 'dark' ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', next);
    localStorage.setItem('theme', next);
  });
}

/* ---- Reveal on scroll (IntersectionObserver) ---- */
function initReveal() {
  const els = document.querySelectorAll('.reveal');
  if (!('IntersectionObserver' in window)) {
    els.forEach(el => el.classList.add('visible'));
    return;
  }
  const io = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) { e.target.classList.add('visible'); io.unobserve(e.target); }
    });
  }, { threshold: 0.15 });
  els.forEach(el => io.observe(el));
}

/* ---- Animated counters ---- */
function initCounters() {
  const counters = document.querySelectorAll('[data-counter]');
  if (!counters.length) return;
  const animate = (el) => {
    const target = parseFloat(el.getAttribute('data-counter'));
    const suffix = el.getAttribute('data-suffix') || '';
    const duration = 1600;
    const start = performance.now();
    const tick = (now) => {
      const p = Math.min((now - start) / duration, 1);
      const eased = 1 - Math.pow(1 - p, 3);
      const val = target * eased;
      el.textContent = (target >= 100 ? Math.round(val).toLocaleString() : val.toFixed(1).replace(/\.0$/, '')) + suffix;
      if (p < 1) requestAnimationFrame(tick);
    };
    requestAnimationFrame(tick);
  };
  const io = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) { animate(e.target); io.unobserve(e.target); } });
  }, { threshold: 0.4 });
  counters.forEach(c => io.observe(c));
}

/* ---- Testimonial slider ---- */
function initSlider() {
  const slider = document.querySelector('.story-slider');
  if (!slider) return;
  const track = slider.querySelector('.story-track');
  const stories = track.querySelectorAll('.story');
  const dotsWrap = slider.querySelector('.slider-dots');
  let idx = 0;

  stories.forEach((_, i) => {
    const b = document.createElement('button');
    b.setAttribute('aria-label', `Slide ${i + 1}`);
    if (i === 0) b.classList.add('active');
    b.addEventListener('click', () => go(i));
    dotsWrap.appendChild(b);
  });
  const dots = dotsWrap.querySelectorAll('button');

  function go(i) {
    idx = (i + stories.length) % stories.length;
    track.style.transform = `translateX(-${idx * 100}%)`;
    dots.forEach((d, di) => d.classList.toggle('active', di === idx));
  }
  let timer = setInterval(() => go(idx + 1), 6000);
  slider.addEventListener('mouseenter', () => clearInterval(timer));
  slider.addEventListener('mouseleave', () => { timer = setInterval(() => go(idx + 1), 6000); });
}

/* ---- Back to top ---- */
function initBackToTop() {
  const btn = document.querySelector('.back-to-top');
  if (!btn) return;
  window.addEventListener('scroll', () => {
    btn.classList.toggle('visible', window.scrollY > 400);
  }, { passive: true });
  btn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
}

/* ---- Forms (submit to FormSubmit — https://formsubmit.co) ----
   • Forms with file uploads (e.g. Jobs/CV) submit natively via a normal POST,
     because file attachments can't be sent through the AJAX endpoint.
   • All other forms submit via fetch() to the FormSubmit AJAX endpoint so the
     visitor stays on the page and sees the inline confirmation message.
   • A legacy `data-mailto` path is kept for any form that still uses it. */
function initForms() {
  document.querySelectorAll('form[data-form]').forEach(form => {
    const hasFile = !!form.querySelector('input[type="file"]');

    form.addEventListener('submit', (e) => {
      const status = form.querySelector('.form-status');
      const submit = form.querySelector('button[type="submit"]');

      /* 1) Legacy: open the visitor's email app (fallback only) */
      const mailto = form.dataset.mailto;
      if (mailto) {
        e.preventDefault();
        const subject = form.dataset.subject || 'Website submission';
        const lines = [];
        form.querySelectorAll('input, select, textarea').forEach(el => {
          if (!el.name && !el.id) return;
          if (el.type === 'file' || el.type === 'submit' || el.type === 'button' || el.type === 'hidden') return;
          const label = (form.querySelector(`label[for="${el.id}"]`)?.textContent || el.name || el.id).trim();
          const value = (el.value || '').trim();
          if (value) lines.push(`${label}: ${value}`);
        });
        if (form.querySelector('input[type="file"]')?.files?.length > 0) {
          lines.push('', '(Please attach your CV to this email before sending.)');
        }
        window.location.href = `mailto:${mailto}?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(lines.join('\n'))}`;
        if (status) { status.textContent = '✓ Opening your email app… please review and send.'; status.style.color = 'var(--color-primary)'; }
        return;
      }

      /* 2) Forms with file uploads submit natively (browser handles the POST) */
      if (hasFile) return;

      /* 3) Everything else: AJAX POST to the form's action (FormSubmit) */
      const action = form.getAttribute('action');
      if (!action) return;
      e.preventDefault();
      if (submit) { submit.disabled = true; submit.dataset.orig = submit.textContent; submit.textContent = 'Sending…'; }

      fetch(action, {
        method: 'POST',
        body: new FormData(form),
        headers: { 'Accept': 'application/json' }
      })
        .then(res => res.json().catch(() => ({})).then(data => ({ ok: res.ok, data })))
        .then(({ ok, data }) => {
          if (!ok) throw new Error(data.message || 'Submission failed');
          if (status) { status.textContent = '✓ Thank you — we\'ve received your message and will be in touch.'; status.style.color = 'var(--color-primary)'; }
          form.reset();
        })
        .catch(() => {
          if (status) { status.textContent = '⚠ Sorry, something went wrong. Please email thesafecenterfordevelopment@gmail.com directly.'; status.style.color = '#c0392b'; }
        })
        .finally(() => {
          if (submit) { submit.disabled = false; submit.textContent = submit.dataset.label || submit.dataset.orig || 'Submit'; }
        });
    });
  });
}
