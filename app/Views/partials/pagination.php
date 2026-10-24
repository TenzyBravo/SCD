<?php /** @var array $page */ if ($page['pages'] <= 1) { return; } ?>
<nav aria-label="Pages"><ul class="pagination">
<?php for ($i = 1; $i <= $page['pages']; $i++): ?>
  <li class="page-item<?= $i === $page['page'] ? ' active' : '' ?>"><a class="page-link" href="<?= e(queryWith(['page' => $i])) ?>"><?= $i ?></a></li>
<?php endfor; ?>
</ul></nav>
