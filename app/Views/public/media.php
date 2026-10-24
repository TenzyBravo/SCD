<?php
/** @var array $posts @var string $type */
use App\Models\Post;

$title       = 'Media';
$description = 'News, press releases, photos, and stories from The Safe Center for Development.';
?>
<section class="page-banner"><div class="container">
  <h1>Media Center</h1>
  <p>News, press releases, photos, and stories from our work across Zambia.</p>
  <div class="breadcrumb"><a href="<?= url('index.html') ?>">Home</a> / Media</div>
</div></section>

<section class="section">
  <div class="container">
<?php if ($posts === [] && $type === ''): ?>
    <div class="empty-state reveal">
      <div class="empty-illustration" aria-hidden="true">📰</div>
      <span class="eyebrow">Coming Soon</span>
      <h2>Our media center is being prepared</h2>
      <p>We're currently curating our news, press releases, photo galleries, and impact stories. Check back soon — or subscribe to our newsletter and we'll email you when the first stories go live.</p>
      <div class="empty-cta">
        <a href="<?= url('contact.html') ?>" class="btn btn-primary">Subscribe for updates</a>
        <a href="<?= url('contact.html') ?>" class="btn btn-outline">Contact our team</a>
      </div>
    </div>

    <div class="coming-soon reveal">
      <div class="icon-card"><div class="icon-badge">📢</div><h3>News</h3><p>Announcements and updates from our programs.</p></div>
      <div class="icon-card"><div class="icon-badge">📄</div><h3>Press Releases</h3><p>Official statements for media partners.</p></div>
      <div class="icon-card"><div class="icon-badge">📸</div><h3>Photo Gallery</h3><p>Moments from communities we serve.</p></div>
      <div class="icon-card"><div class="icon-badge">💬</div><h3>Success Stories</h3><p>Voices of the youth and children whose lives are changing.</p></div>
    </div>
<?php else: ?>
    <nav class="filter-bar" aria-label="Filter stories">
      <a class="filter-chip<?= $type === '' ? ' active' : '' ?>" href="<?= url('media.html') ?>">All</a>
<?php foreach (Post::TYPES as $key => $name): ?>
      <a class="filter-chip<?= $type === $key ? ' active' : '' ?>" href="<?= url('media.html') ?>?type=<?= e($key) ?>"><?= e($name) ?></a>
<?php endforeach; ?>
    </nav>

<?php if ($posts === []): ?>
    <p class="text-center" style="color: var(--color-muted);">Nothing here yet. <a href="<?= url('media.html') ?>">See all stories</a>.</p>
<?php else: ?>
    <div class="grid grid-cards">
<?php foreach ($posts as $post): ?>
      <article class="card reveal">
<?php if ($post['image_path']): ?>
        <div class="card-media"><img loading="lazy" alt="" src="<?= e(fileUrl($post['image_path'])) ?>"/></div>
<?php endif; ?>
        <div class="card-body">
          <span class="card-tag"><?= e(Post::TYPES[$post['type']] ?? '') ?></span>
          <h3><?= e($post['title']) ?></h3>
          <span class="card-date"><?= e(d($post['published_at'])) ?></span>
          <p><?= e(excerpt($post['excerpt'] ?: $post['body'], 160)) ?></p>
          <a class="card-link" href="<?= url('media/' . rawurlencode($post['slug'])) ?>">Read more</a>
        </div>
      </article>
<?php endforeach; ?>
    </div>
<?php endif; ?>
<?php endif; ?>
  </div>
</section>
