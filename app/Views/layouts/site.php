<?php
/**
 * Public layout. Mirrors the header and footer of the static .html pages —
 * when the navigation or footer changes there, change it here too.
 *
 * @var string $content
 * @var string|null $title
 * @var string|null $description
 * @var string|null $styles  extra CSS for this page
 */
$pageTitle = isset($title) ? $title . ' — The Safe Center For Development' : 'The Safe Center For Development';
$pageDesc  = $description ?? 'Empowering youth, protecting vulnerable children, and building resilient communities across Zambia.';
?><!DOCTYPE html>
<html lang="en"><head>
<meta charset="UTF-8"/><meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title><?= e($pageTitle) ?></title>
<meta name="description" content="<?= e($pageDesc) ?>"/>
<meta property="og:title" content="<?= e($pageTitle) ?>"/>
<meta property="og:description" content="<?= e($pageDesc) ?>"/>
<meta property="og:type" content="<?= isset($ogImage) ? 'article' : 'website' ?>"/>
<?php if (!empty($ogImage)): ?><meta property="og:image" content="<?= e($ogImage) ?>"/>
<?php endif; ?>
<?php if (!empty($canonical)): ?><link rel="canonical" href="<?= e($canonical) ?>"/>
<?php endif; ?>
<link rel="preconnect" href="https://fonts.googleapis.com"/><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet"/>
<link rel="shortcut icon" href="<?= url('assets/images/logo/wnbg.jpeg') ?>"/>
<link rel="stylesheet" href="<?= url('css/styles.css') ?>"/>
<?php if (!empty($styles)): ?><style><?= $styles ?></style>
<?php endif; ?>
</head><body>
<a class="skip-link" href="#main">Skip to content</a>
<header class="site-header"><div class="container nav">
  <a class="brand" href="<?= url('index.html') ?>" aria-label="The Safe Center For Development — Home"><img class="brand-logo" src="<?= url('assets/images/logo/wnbg.jpeg') ?>" alt="The Safe Center For Development"/></a>
  <nav aria-label="Primary"><ul class="nav-links">
    <li><a href="<?= url('index.html') ?>">Home</a></li><li><a href="<?= url('about.html') ?>">About</a></li><li><a href="<?= url('focus.html') ?>">Areas of Focus</a></li>
    <li><a href="<?= url('support.html') ?>">Support Units</a></li><li><a href="<?= url('media.html') ?>">Media</a></li><li><a href="<?= url('training.html') ?>">Training</a></li>
    <li><a href="<?= url('toolkits.html') ?>">Toolkits</a></li><li><a href="<?= url('jobs.html') ?>">Jobs</a></li><li><a href="<?= url('contact.html') ?>">Contact</a></li>
  </ul></nav>
  <div class="nav-actions"><button class="icon-btn" id="theme-toggle" aria-label="Toggle theme">☾</button><a class="btn btn-accent" href="<?= url('contact.html') ?>">Donate</a><button class="nav-toggle" aria-label="Menu" aria-expanded="false"><span></span></button></div>
</div></header>

<main id="main">
<?= $content ?>
</main>

<footer class="site-footer">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <a href="<?= url('index.html') ?>" class="brand-logo-wrap" aria-label="The Safe Center For Development — Home">
          <img src="<?= url('assets/images/logo/wnbg.jpeg') ?>" alt="The Safe Center For Development"/>
        </a>
        <p>Empowering youth, protecting vulnerable children, and building resilient communities across Zambia.</p>
        <div class="footer-social" aria-label="Social media">
          <a href="#" aria-label="Facebook">f</a>
          <a href="#" aria-label="Twitter">𝕏</a>
          <a href="#" aria-label="Instagram">ig</a>
          <a href="https://www.linkedin.com/in/the-safe-center-for-development-625987335/" aria-label="LinkedIn">in</a>
          <a href="#" aria-label="YouTube">▶</a>
        </div>
      </div>
      <div>
        <h4>Quick Links</h4>
        <ul class="footer-links">
          <li><a href="<?= url('about.html') ?>">About</a></li>
          <li><a href="<?= url('focus.html') ?>">Areas of Focus</a></li>
          <li><a href="<?= url('training.html') ?>">Training</a></li>
          <li><a href="<?= url('toolkits.html') ?>">Toolkits</a></li>
          <li><a href="<?= url('jobs.html') ?>">Jobs</a></li>
        </ul>
      </div>
      <div>
        <h4>Resources</h4>
        <ul class="footer-links">
          <li><a href="<?= url('media.html') ?>">News &amp; Media</a></li>
          <li><a href="<?= url('toolkits.html') ?>">Publications</a></li>
          <li><a href="<?= url('about.html#reports') ?>">Annual Reports</a></li>
          <li><a href="<?= url('contact.html') ?>">Contact</a></li>
        </ul>
      </div>
      <div>
        <h4>Get in Touch</h4>
        <ul class="footer-links footer-contact">
          <li>📍  Plot 5 Ndibu Drive, Kansenshi, Ndola, Zambia</li>
          <li>📞 +260 962 964 827 · +260 962 036 697 · +260 770 417 104</li>
          <li>✉ thesafecenterfordevelopment@gmail.com</li>
          <li>🕘 Mon–Fri • 08:00–17:00</li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <span>© <span id="year"></span> The Safe Center For Development. All rights reserved.</span>
    </div>
  </div>
</footer>
<button class="back-to-top" aria-label="Back to top">↑</button>
<script src="<?= url('js/main.js') ?>"></script>
</body></html>
