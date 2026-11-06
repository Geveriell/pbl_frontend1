<?php
$u = Owner::user();
$nav = [
    ['kontrol', 'Pusat Kontrol & Multi-Role', 'owner-control'],
    ['laporan', 'Laporan & Riwayat Periode', 'owner-report'],
    ['akses', 'Hak Akses & Kendali Sistem', 'owner-access'],
];
?>
<div class="ow-shell">
  <aside class="ow-side">
    <div class="ow-brand">
      <span class="ow-logo">S</span>
      <div><b>BON SURYA</b><small>SUPERVISOR ACCESS</small></div>
    </div>
    <nav class="ow-nav" aria-label="Menu owner">
      <?php foreach ($nav as [$k, $label, $route]): ?>
        <a href="<?= e(url($route)) ?>" class="<?= $active === $k ? 'is-active' : '' ?>"<?= $active === $k ? ' aria-current="page"' : '' ?>><?= e($label) ?></a>
      <?php endforeach; ?>
    </nav>
  </aside>

  <div class="ow-main">
    <header class="ow-top">
      <p><b><?= e($u['nama']) ?></b><small><?= e($u['peran']) ?></small></p>
      <a class="ow-avatar" href="<?= e(url('roles')) ?>" aria-label="Keluar ke daftar role"><?= e($u['inisial']) ?></a>
    </header>
    <main class="ow-body">
