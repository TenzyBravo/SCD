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

/* ---- Forms (client-side stub — swap for Postgres/API later) ---- */
function initForms() {
  document.querySelectorAll('form[data-form]').forEach(form => {
    form.addEventListener('submit', (e) => {
      e.preventDefault();
      const status = form.querySelector('.form-status');
      const submit = form.querySelector('button[type="submit"]');
      const mailto = form.dataset.mailto;

      if (mailto) {
        const subject = form.dataset.subject || 'Website submission';
        const lines = [];
        form.querySelectorAll('input, select, textarea').forEach(el => {
          if (!el.name && !el.id) return;
          if (el.type === 'file' || el.type === 'submit' || el.type === 'button') return;
          const label = (form.querySelector(`label[for="${el.id}"]`)?.textContent || el.name || el.id).trim();
          const value = (el.value || '').trim();
          if (value) lines.push(`${label}: ${value}`);
        });
        const hasFile = form.querySelector('input[type="file"]')?.files?.length > 0;
        if (hasFile) lines.push('', '(Please attach your CV to this email before sending.)');
        const href = `mailto:${mailto}?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(lines.join('\n'))}`;
        window.location.href = href;
        if (status) {
          status.textContent = '✓ Opening your email app… please review and send.';
          status.style.color = 'var(--color-primary)';
        }
        return;
      }

      if (submit) { submit.disabled = true; submit.textContent = 'Sending…'; }
      setTimeout(() => {
        if (status) {
          status.textContent = '✓ Thank you — we\'ll be in touch shortly.';
          status.style.color = 'var(--color-primary)';
        }
        form.reset();
        if (submit) { submit.disabled = false; submit.textContent = submit.dataset.label || 'Submit'; }
      }, 700);
    });
  });
}
