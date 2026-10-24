<?php /** @var string $action @var string $what */ ?>
<form method="post" action="<?= e($action) ?>" class="d-inline" data-confirm="Delete “<?= e($what) ?>”? It will disappear from the website.">
  <?= csrf() ?>
  <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
</form>
