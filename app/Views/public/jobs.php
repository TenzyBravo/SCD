<?php
/** @var array $jobs */
$title       = 'Careers';
$description = 'Open roles, internships, consultancies, and volunteer opportunities.';
?>
<section class="page-banner"><div class="container">
  <h1>Careers</h1>
  <p>Join a team of passionate professionals working to build safer, more resilient communities across Zambia.</p>
  <div class="breadcrumb"><a href="<?= url('index.html') ?>">Home</a> / Jobs</div>
</div></section>

<?php if ($jobs === []): ?>
<section class="section">
  <div class="container">
    <div class="empty-state reveal">
      <div class="empty-illustration" aria-hidden="true">📭</div>
      <span class="eyebrow">All Positions Filled</span>
      <h2>No open vacancies right now</h2>
      <p>Thank you for your interest in joining The Safe Center for Development. We don't have any open positions at the moment, but new opportunities are posted regularly across our program, research, and support teams.</p>
      <p>Leave your details below and we'll get in touch as soon as a suitable role opens up.</p>

      <div class="empty-cta">
        <a href="#talent-pool" class="btn btn-primary">Join our talent pool</a>
        <a href="<?= url('index.html') ?>" class="btn btn-outline">Back to home</a>
      </div>
    </div>
  </div>
</section>

<section class="section" id="talent-pool" style="background: var(--color-surface);">
  <div class="container">
    <div class="section-header reveal">
      <span class="eyebrow">Talent Pool</span>
      <h2>Register your interest</h2>
      <p>Tell us a bit about yourself. We'll keep your CV on file and reach out when a matching role opens.</p>
    </div>
    <form data-form data-mailto="thesafecenterfordevelopment@gmail.com" data-subject="Talent Pool Registration" class="reveal" style="max-width:720px; margin:0 auto; background:var(--color-bg); padding:2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md);">
      <div class="form-grid">
        <div class="field"><label for="t-first">First name</label><input id="t-first" type="text" required/></div>
        <div class="field"><label for="t-last">Last name</label><input id="t-last" type="text" required/></div>
        <div class="field"><label for="t-email">Email</label><input id="t-email" type="email" required/></div>
        <div class="field"><label for="t-phone">Phone</label><input id="t-phone" type="tel"/></div>
        <div class="field full"><label for="t-interest">Area of interest</label>
          <select id="t-interest" required>
            <option value="">Select…</option>
            <option>Youth Empowerment</option>
            <option>Child Protection & Welfare</option>
            <option>Research & Innovation</option>
            <option>Community Development</option>
            <option>Health Promotion</option>
            <option>Education & Literacy</option>
            <option>Environmental Sustainability</option>
            <option>Partnerships & Collaboration</option>
            <option>Advocacy & Human Rights</option>
            <option>Emergency Response</option>
            <option>Finance / HR / Admin / IT</option>
            <option>Communications</option>
            <option>Volunteer / Internship</option>
          </select>
        </div>
        <div class="field full"><label for="t-cv">Upload CV (PDF)</label><input id="t-cv" type="file" accept=".pdf,.doc,.docx"/></div>
        <div class="field full"><label for="t-note">Tell us about yourself (optional)</label><textarea id="t-note" rows="4"></textarea></div>
        <div class="field full"><button class="btn btn-primary" type="submit" data-label="Join Talent Pool">Join Talent Pool</button></div>
      </div>
      <p class="form-status" style="margin-top:1rem;"></p>
    </form>
    <p class="text-center reveal" style="margin-top:2rem; color: var(--color-muted); font-size:.9rem;">The Safe Center for Development is an equal opportunity employer.</p>
  </div>
</section>
<?php else: ?>
<section class="section"><div class="container">
  <div class="section-header reveal"><span class="eyebrow">Open Roles</span><h2>Current Vacancies</h2></div>

  <div class="reveal">
<?php foreach ($jobs as $job): ?>
    <div class="job"><div>
      <h3><?= e($job['title']) ?></h3>
      <div class="job-meta">
<?php if ($job['location']): ?><span>📍 <?= e($job['location']) ?></span><?php endif; ?>
<?php if ($job['commitment']): ?><span>🕘 <?= e($job['commitment']) ?></span><?php endif; ?>
        <span>📅 <?= $job['deadline'] ? 'Deadline: ' . e(d($job['deadline'])) : 'Rolling' ?></span>
      </div>
      <p class="job-text"><?= nl2br(e($job['description']), false) ?></p>
<?php if ($job['how_to_apply']): ?>
      <p class="job-apply"><strong>To apply:</strong> <?= withEmailLinks($job['how_to_apply']) ?></p>
<?php endif; ?>
    </div><a class="btn btn-primary" href="#apply">Apply</a></div>
<?php endforeach; ?>
  </div>
</div></section>

<section class="section" id="apply" style="background: var(--color-surface);"><div class="container">
  <div class="section-header reveal"><span class="eyebrow">Application</span><h2>Apply Now</h2><p>Send us your CV and a short cover letter. We review applications on a rolling basis and get back to shortlisted candidates within two weeks.</p></div>
  <form action="https://formsubmit.co/thesafecenterfordevelopment@gmail.com" method="POST" enctype="multipart/form-data" class="reveal" style="max-width:720px; margin:0 auto; background:var(--color-bg); padding:2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md);">
    <input type="hidden" name="_subject" value="Job Application"/>
    <input type="hidden" name="_template" value="table"/>
    <input type="hidden" name="_captcha" value="false"/>
    <input type="hidden" name="_next" value="https://www.safecenterdev.org/thanks.html"/>
    <input type="text" name="_honey" tabindex="-1" autocomplete="off" style="display:none"/>
    <div class="form-grid">
      <div class="field"><label for="j-first">First name</label><input id="j-first" name="first_name" type="text" required/></div>
      <div class="field"><label for="j-last">Last name</label><input id="j-last" name="last_name" type="text" required/></div>
      <div class="field"><label for="j-email">Email</label><input id="j-email" name="email" type="email" required/></div>
      <div class="field"><label for="j-phone">Phone</label><input id="j-phone" name="phone" type="tel"/></div>
      <div class="field full"><label for="j-role">Position applying for</label>
        <select id="j-role" name="position" required>
          <option value="">Select…</option>
<?php foreach ($jobs as $job): ?>
          <option><?= e($job['title']) ?></option>
<?php endforeach; ?>
        </select>
      </div>
      <div class="field full"><label for="j-cv">Upload CV (PDF)</label><input id="j-cv" name="cv" type="file" accept=".pdf,.doc,.docx"/></div>
      <div class="field full"><label for="j-cover">Upload Cover Letter</label><input id="j-cover" name="cover_letter" type="file" accept=".pdf,.doc,.docx"/></div>
      <div class="field full"><label for="j-note">Message (optional)</label><textarea id="j-note" name="message" rows="4"></textarea></div>
      <div class="field full"><button class="btn btn-primary" type="submit" data-label="Submit Application">Submit Application</button></div>
    </div>
    <p class="form-status" style="margin-top:1rem;"></p>
  </form>
  <p class="text-center reveal" style="margin-top:2rem; color: var(--color-muted); font-size:.9rem;">The Safe Center For Development is an equal opportunity employer. We do not discriminate on the basis of race, colour, religion, gender, sexual orientation, national origin, age, disability, or veteran status.</p>
</div></section>
<?php endif; ?>
