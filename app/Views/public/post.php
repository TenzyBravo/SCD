<?php
/** @var array $post */
use App\Models\Post;

$title       = $post['title'];
$description = excerpt($post['excerpt'] ?: $post['body'], 160);
$canonical   = url('media/' . rawurlencode($post['slug']));
if ($post['image_path']) {
    $ogImage = fileUrl($post['image_path']);
}
?>
<section class="page-banner"><div class="container">
  <h1><?= e($post['title']) ?></h1>
  <div class="breadcrumb"><a href="<?= url('index.html') ?>">Home</a> / <a href="<?= url('media.html') ?>">Media</a> / <?= e(Post::TYPES[$post['type']] ?? '') ?></div>
</div></section>

<section class="section">
  <article class="container article">
    <p class="article-meta"><?= e(Post::TYPES[$post['type']] ?? '') ?> · <?= e(d($post['published_at'])) ?></p>
<?php if ($post['image_path']): ?>
    <img class="article-image" src="<?= e(fileUrl($post['image_path'])) ?>" alt=""/>
<?php endif; ?>
    <div class="article-body"><?= richText($post['body']) ?></div>
    <p style="margin-top:2.5rem;"><a class="btn btn-outline" href="<?= url('media.html') ?>">← Back to Media</a></p>
  </article>
</section>
