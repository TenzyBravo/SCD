<?php
/**
 * About page. Everything here is static except the Leadership Team, which is
 * managed under Admin → Team. Rendered without a layout because the page has
 * its own <head>; keep its header/footer in step with the static pages.
 *
 * @var array $team
 */
use App\Models\TeamMember;
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>About — The Safe Center For Development</title>
<meta name="description" content="Our story, mission, vision, leadership, and strategic goals."/>
<meta property="og:title" content="About — The Safe Center For Development"/>
<meta property="og:description" content="Our story, mission, vision, leadership, and strategic goals."/>
<meta property="og:type" content="website"/>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet"/>
<link rel="shortcut icon" href="assets/images/logo/wnbg.jpeg"/>
<link rel="stylesheet" href="css/styles.css"/>
<link rel="canonical" href="https://safecenterdev.org/about.html"/>
<meta property="og:url" content="https://safecenterdev.org/about.html"/>
<meta property="og:site_name" content="The Safe Center For Development"/>
<meta property="og:image" content="https://safecenterdev.org/assets/images/hero/hero.jpeg"/>
<meta name="twitter:card" content="summary_large_image"/>
<meta name="twitter:image" content="https://safecenterdev.org/assets/images/hero/hero.jpeg"/>
</head>
<body>
<a class="skip-link" href="#main">Skip to content</a>

<header class="site-header">
  <div class="container nav">
    <a class="brand" href="index.html" aria-label="The Safe Center For Development — Home"><img class="brand-logo" src="assets/images/logo/wnbg.jpeg" alt="The Safe Center For Development"/></a>
    <nav aria-label="Primary"><ul class="nav-links">
      <li><a href="index.html">Home</a></li><li><a href="about.html">About</a></li>
      <li><a href="focus.html">Areas of Focus</a></li><li><a href="support.html">Support Units</a></li>
      <li><a href="media.html">Media</a></li><li><a href="training.html">Training</a></li>
      <li><a href="toolkits.html">Toolkits</a></li><li><a href="jobs.html">Jobs</a></li>
      <li><a href="contact.html">Contact</a></li>
    </ul></nav>
    <div class="nav-actions">
      <button class="icon-btn" id="theme-toggle" aria-label="Toggle theme">☾</button>
      <a class="btn btn-accent" href="contact.html">Donate</a>
      <button class="nav-toggle" aria-label="Open menu" aria-expanded="false"><span></span></button>
    </div>
  </div>
</header>

<main id="main">
  <section class="page-banner">
    <div class="container">
      <h1>About Us</h1>
      <p>A Zambian non-profit committed to empowering youth, protecting vulnerable children, and building resilient communities.</p>
      <div class="breadcrumb"><a href="index.html">Home</a> / About</div>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="grid grid-2" style="align-items: center;">
        <div class="reveal">
          <span class="eyebrow">Our Story</span>
          <h2>Community-first development, rooted on the Copperbelt</h2>
          <p>The Safe Center for Development (SCD) is a Zambian non-profit registered with the Registrar of Non-Governmental Organizations under the Ministry of Community Development and Social Services. Headquartered in the Copperbelt Province, we operate across the country through regional, district, and branch offices as our programs expand.</p>
          <p>We are non-profit, non-political, and non-discriminatory — working hand-in-hand with communities, government, faith-based organizations, and development partners to empower youth, protect vulnerable children, and foster sustainable community development throughout Zambia.</p>
        </div>
        <div class="reveal">
          <img style="border-radius: var(--radius-lg);" alt="The Safe Center for Development community outreach" src="assets/images/hero/hero.jpeg"/>
        </div>
      </div>
    </div>
  </section>

  <section class="section" style="background: var(--color-surface);">
    <div class="container">
      <div class="section-header reveal"><span class="eyebrow">Foundations</span><h2>Mission, Vision & Values</h2></div>
      <div class="grid grid-3">
        <div class="icon-card reveal"><div class="icon-badge">🎯</div><h3>Mission</h3><p>To empower youth through skills development, education, health awareness, and access to essential information while uplifting vulnerable children through comprehensive support, protection, and opportunities to thrive.</p></div>
        <div class="icon-card reveal"><div class="icon-badge">🌍</div><h3>Vision</h3><p>A future where every Zambian youth is empowered to drive sustainable development, and every vulnerable child feels safe, valued, and empowered to reach their full potential.</p></div>
        <div class="icon-card reveal"><div class="icon-badge">💚</div><h3>Core Principle</h3><p>Non-profit · Non-political · Non-discriminatory — committed to improving lives, empowering youth, and fostering sustainable community development across Zambia.</p></div>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="section-header reveal"><span class="eyebrow">Objectives</span><h2>Our Main & Specific Objectives</h2><p><strong>Main objective:</strong> To promote the holistic transformation of youth, vulnerable children, and disadvantaged communities through empowerment, education, health information, innovation, and sustainable development opportunities that improve livelihoods and enhance overall well-being.</p></div>
      <div class="grid grid-3">
        <div class="icon-card reveal"><div class="icon-badge">1</div><h3>Youth Empowerment</h3><p>Vocational skills, entrepreneurship, digital literacy, healthcare awareness, leadership, and wellness programs.</p></div>
        <div class="icon-card reveal"><div class="icon-badge">2</div><h3>Child Protection & Welfare</h3><p>Safeguarding policies, education, healthcare, psychosocial support, and family strengthening.</p></div>
        <div class="icon-card reveal"><div class="icon-badge">3</div><h3>Research & Innovation</h3><p>Data-driven studies that promote evidence-based decisions and program effectiveness.</p></div>
        <div class="icon-card reveal"><div class="icon-badge">4</div><h3>Community Development</h3><p>Capacity building, economic empowerment, and sustainable livelihood interventions.</p></div>
        <div class="icon-card reveal"><div class="icon-badge">5</div><h3>Health Promotion</h3><p>Preventive healthcare, health education, nutrition, mental health, and access to information.</p></div>
        <div class="icon-card reveal"><div class="icon-badge">6</div><h3>Education & Literacy</h3><p>Access to quality education, literacy programs, and lifelong learning for all ages.</p></div>
        <div class="icon-card reveal"><div class="icon-badge">7</div><h3>Environmental Sustainability</h3><p>Conservation, climate resilience, sustainable agriculture, and natural resource management.</p></div>
        <div class="icon-card reveal"><div class="icon-badge">8</div><h3>Partnerships & Collaboration</h3><p>Strategic partnerships with government, private sector, NGOs, and international partners.</p></div>
        <div class="icon-card reveal"><div class="icon-badge">9</div><h3>Advocacy & Human Rights</h3><p>Advocacy for children's rights, gender equality, social justice, and inclusive development.</p></div>
        <div class="icon-card reveal"><div class="icon-badge">10</div><h3>Emergency Response</h3><p>Humanitarian assistance, disaster preparedness, relief, recovery, and resilience-building.</p></div>
      </div>
    </div>
  </section>

  <section class="section" style="background: var(--color-surface);" id="leadership">
    <div class="container">
      <div class="section-header reveal"><span class="eyebrow">People</span><h2>Leadership Team</h2><p>Meet the people leading The Safe Center for Development.</p></div>
      <div class="grid grid-3">
<?php foreach ($team as $member): ?>
        <article class="card reveal">
<?php if ($member['image_path']): ?>
          <div class="card-media" style="aspect-ratio: 1/1;"><img loading="lazy" alt="<?= e($member['name']) ?>" src="<?= e(fileUrl($member['image_path'])) ?>" style="object-position: <?= e(TeamMember::POSITIONS[$member['image_position']][1] ?? 'center top') ?>;"/></div>
<?php endif; ?>
          <div class="card-body">
            <span class="card-tag"><?= e($member['title']) ?></span>
            <h3><?= e($member['name']) ?></h3>
<?php if ($member['bio']): ?>
            <p><?= e($member['bio']) ?></p>
<?php endif; ?>
          </div>
        </article>
<?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="section" id="reports">
    <div class="container">
      <div class="section-header reveal"><span class="eyebrow">Registration & Governance</span><h2>Legal Status</h2></div>
      <div class="grid grid-2">
        <div class="icon-card reveal"><div class="icon-badge">📜</div><h3>Registered NGO</h3><p>SCD is registered with the Registrar of Non-Governmental Organizations under the Ministry of Community Development and Social Services of the Republic of Zambia.</p></div>
        <div class="icon-card reveal"><div class="icon-badge">🏛️</div><h3>Governance</h3><p>Governed by a Board of Directors under the SCD Constitution. The headquarters is on the Copperbelt, with authority to establish regional, district, and branch offices as required.</p></div>
      </div>
    </div>
  </section>
</main>

<footer class="site-footer">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <a href="index.html" class="brand-logo-wrap" aria-label="The Safe Center For Development — Home">
          <img src="assets/images/logo/wnbg.jpeg" alt="The Safe Center For Development"/>
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
          <li><a href="about.html">About</a></li>
          <li><a href="focus.html">Areas of Focus</a></li>
          <li><a href="training.html">Training</a></li>
          <li><a href="toolkits.html">Toolkits</a></li>
          <li><a href="jobs.html">Jobs</a></li>
        </ul>
      </div>
      <div>
        <h4>Resources</h4>
        <ul class="footer-links">
          <li><a href="media.html">News &amp; Media</a></li>
          <li><a href="toolkits.html">Publications</a></li>
          <li><a href="about.html#reports">Annual Reports</a></li>
          <li><a href="contact.html">Contact</a></li>
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
<script src="js/main.js"></script>
</body>
</html>
