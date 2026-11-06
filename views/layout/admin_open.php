<?php

$u = Admin::user();
$nav = [
    ['menu', 'Data Menu', 'book', 'admin-menu'],
    ['analisis', 'Analisis Penjualan', 'chart', 'admin-sales'],
    ['promo', 'Promo & Reservasi', 'chair', 'admin-promo'],
];

$polos = $active === 'menu';
?>
<div class="adm-shell">
  <aside class="adm-side">
    <div class="adm-brand">
      <span class="adm-logo"><i data-ico="utensils"></i></span>
      <?php if ($polos): ?><div><b>Admin Page</b></div><?php else: ?><div><b>Savor &amp; Dine</b><small>PORTAL ADMIN OPERASIONAL</small></div><?php endif; ?>
    </div>
    <p class="adm-label">MENU OPERASIONAL</p>
    <nav class="adm-nav" aria-label="Menu admin">
      <?php foreach ($nav as [$k, $label, $ic, $route]): ?>
        <a href="<?= e(url($route)) ?>" class="<?= $active === $k ? 'is-active' : '' ?>"<?= $active === $k ? ' aria-current="page"' : '' ?>>
          <i data-ico="<?= $ic ?>"></i><span><?= e($label) ?></span>
        </a>
      <?php endforeach; ?>
    </nav>
    <div class="adm-me">
      <p><i class="avatar" data-ico="user"></i><span><b><?= e($u['nama']) ?></b><small><?= e($u['peran']) ?></small></span></p>
      <a href="<?= e(url('roles')) ?>" class="adm-out"><i data-ico="logout"></i>Keluar</a>
    </div>
  </aside>

  <div class="adm-main">
    <header class="adm-top">
      <span class="adm-brand-mini"><span class="adm-logo"><i data-ico="utensils"></i></span></span>
      <nav class="crumb" aria-label="Breadcrumb"><a href="<?= e(url('admin-menu')) ?>">Admin Page</a><i data-ico="chevron"></i><span><?= e($crumb) ?></span></nav>
      <?php if ($polos): ?><span class="ms-auto"></span><?php else: ?><button class="adm-bell" id="btnBell" aria-label="Notifikasi"><i data-ico="bell"></i><em></em></button><?php endif; ?>
      <i class="avatar" data-ico="user" aria-label="<?= e($u['nama']) ?>"></i>
    </header>
    <main class="adm-body">
