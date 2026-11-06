<nav class="bottom-nav">
  <a href="<?= e(url('menu')) ?>" class="<?= $active === 'menu' ? 'is-active' : '' ?>"><i data-ico="crossed"></i>Menu</a>
  <a href="<?= e(url('cart')) ?>" class="<?= $active === 'pesanan' ? 'is-active' : '' ?>"><i data-ico="bag"></i>Pesanan</a>
  <a href="<?= e(url('status')) ?>" class="<?= $active === 'status' ? 'is-active' : '' ?>"><i data-ico="receipt"></i>Status</a>
  <a href="#" class="<?= $active === 'resto' ? 'is-active' : '' ?>"><i data-ico="cup"></i><?= e(APP_NAME) ?></a>
</nav>
