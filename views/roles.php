<main class="app">
  <?php partial('layout/customer_top'); ?>
  <div class="section-head"><h2>Pintu Masuk Role</h2></div>
  <?php foreach ($links as [$label, $desc, $route]): ?>
    <a class="app-card role-link" href="<?= e(url($route)) ?>"><b><?= e($label) ?></b><small><?= e($desc) ?> — <code>?page=<?= e($route) ?></code></small></a>
  <?php endforeach; ?>
</main>
