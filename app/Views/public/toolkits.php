<?php
/** @var array<string,array> $groups */
use App\Models\Resource;

$title       = 'Toolkits';
$description = 'Free practical guidelines, templates, manuals, and research from The Safe Center for Development.';
$icons       = ['guideline' => '📋', 'manual' => '📖', 'template' => '📝', 'research' => '🔬'];
?>
<section class="page-banner"><div class="container">
  <h1>Toolkits & Resources</h1>
  <p>Practical guidelines, templates, manuals, and research — free to download and adapt.</p>
  <div class="breadcrumb"><a href="<?= url('index.html') ?>">Home</a> / Toolkits</div>
</div></section>

<section class="section">
  <div class="container">
<?php if ($groups === []): ?>
    <div class="empty-state reveal">
      <div class="empty-illustration" aria-hidden="true">📚</div>
      <span class="eyebrow">Coming Soon</span>
      <h2>Our resource library is being prepared</h2>
      <p>We're finalising a collection of guidelines, manuals, templates, and research publications drawn from our work across Zambia. Once approved for release, they will be free to download and adapt.</p>
      <div class="empty-cta">
        <a href="<?= url('contact.html') ?>" class="btn btn-primary">Subscribe for updates</a>
        <a href="<?= url('contact.html') ?>" class="btn btn-outline">Request a resource</a>
      </div>
    </div>

    <div class="coming-soon reveal">
      <div class="icon-card"><div class="icon-badge">📋</div><h3>Guidelines</h3><p>Frameworks for our programmatic areas.</p></div>
      <div class="icon-card"><div class="icon-badge">📖</div><h3>Manuals</h3><p>Practical, field-tested implementation guides.</p></div>
      <div class="icon-card"><div class="icon-badge">📝</div><h3>Templates</h3><p>Editable formats for assessments, budgets, and plans.</p></div>
      <div class="icon-card"><div class="icon-badge">🔬</div><h3>Research</h3><p>Studies, case studies, and evaluation reports.</p></div>
    </div>
<?php else: ?>
<?php foreach (Resource::CATEGORIES as $key => $name): if (empty($groups[$key])) { continue; } ?>
    <div class="resource-group reveal">
      <h2><?= e($name) ?></h2>
<?php foreach ($groups[$key] as $item): ?>
      <div class="resource">
        <div class="resource-icon" aria-hidden="true"><?= $icons[$key] ?></div>
        <div>
          <h3><?= e($item['title']) ?></h3>
<?php if ($item['description']): ?>
          <p><?= e($item['description']) ?></p>
<?php endif; ?>
          <div class="resource-meta"><?= e(strtoupper(pathinfo($item['file_name'], PATHINFO_EXTENSION))) ?> · <?= e(bytes((int)$item['file_size'])) ?></div>
        </div>
        <a class="btn btn-primary" href="<?= e(fileUrl($item['file_path'])) ?>" download>Download</a>
      </div>
<?php endforeach; ?>
    </div>
<?php endforeach; ?>
    <p class="text-center reveal" style="color: var(--color-muted);">Looking for something else? <a href="<?= url('contact.html') ?>">Request a resource</a>.</p>
<?php endif; ?>
  </div>
</section>
