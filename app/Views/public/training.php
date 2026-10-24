<?php
/** @var array $courses */
$title       = 'Training';
$description = 'Workshops, short courses, and certification programs from The Safe Center for Development.';
?>
<section class="page-banner"><div class="container">
  <h1>Training & Learning</h1>
  <p>Build practical skills that strengthen communities — through workshops, short courses, and certification programs.</p>
  <div class="breadcrumb"><a href="<?= url('index.html') ?>">Home</a> / Training</div>
</div></section>

<section class="section"><div class="container">
  <div class="section-header reveal"><span class="eyebrow">Programs</span><h2>Upcoming Courses & Workshops</h2></div>
<?php if ($courses === []): ?>
  <p class="text-center reveal" style="color: var(--color-muted);">New courses are being scheduled. <a href="<?= url('contact.html') ?>">Contact us</a> to hear when registration opens.</p>
<?php else: ?>
  <div class="grid grid-cards">
<?php foreach ($courses as $course): ?>
    <article class="card reveal">
<?php if ($course['image_path']): ?>
      <div class="card-media"><img loading="lazy" alt="" src="<?= e(fileUrl($course['image_path'])) ?>"/></div>
<?php endif; ?>
      <div class="card-body">
<?php if ($course['tag']): ?><span class="card-tag"><?= e($course['tag']) ?></span><?php endif; ?>
        <h3><?= e($course['title']) ?></h3>
        <p><?= e($course['details']) ?></p>
        <a class="card-link" href="#register">Register</a>
      </div>
    </article>
<?php endforeach; ?>
  </div>
<?php endif; ?>
</div></section>

<?php if ($courses !== []): ?>
<section class="section" id="register" style="background: var(--color-surface);"><div class="container">
  <div class="grid grid-2" style="align-items:center;">
    <div class="reveal">
      <span class="eyebrow">Register</span>
      <h2>Enroll for a course</h2>
      <p>Complete the form and our training team will confirm your seat within two working days.</p>
    </div>
    <form class="reveal" data-form action="https://formsubmit.co/ajax/thesafecenterfordevelopment@gmail.com" method="POST" style="background:var(--color-bg); padding:2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md);">
      <input type="hidden" name="_subject" value="Training Registration"/>
      <input type="hidden" name="_template" value="table"/>
      <input type="text" name="_honey" tabindex="-1" autocomplete="off" style="display:none"/>
      <div class="form-grid">
        <div class="field"><label for="first">First name</label><input id="first" name="first_name" type="text" required/></div>
        <div class="field"><label for="last">Last name</label><input id="last" name="last_name" type="text" required/></div>
        <div class="field full"><label for="email">Email</label><input id="email" name="email" type="email" required/></div>
        <div class="field full"><label for="course">Course</label>
          <select id="course" name="course" required>
            <option value="">Select a course…</option>
<?php foreach ($courses as $course): ?>
            <option><?= e($course['title']) ?></option>
<?php endforeach; ?>
          </select>
        </div>
        <div class="field full"><label for="note">Notes (optional)</label><textarea id="note" name="notes" rows="4"></textarea></div>
        <div class="field full"><button class="btn btn-primary" type="submit" data-label="Register">Register</button></div>
      </div>
      <p class="form-status" style="margin-top:1rem;"></p>
    </form>
  </div>
</div></section>
<?php endif; ?>
