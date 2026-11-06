  <main class="app">
    <?php partial('layout/customer_top'); ?>

    <div class="table-bar">
      <span><span class="dot"></span>Meja <?= e($meja) ?> • <?= e(AREA_MEJA) ?></span>
      <small>Menu Catalog</small>
    </div>
    <div class="table-bar table-bar--detail">
      <span class="tb-ico"><i data-ico="home"></i></span>
      <div class="tb-text"><span><span class="dot"></span><b>Meja <?= e($meja) ?> • <?= e(AREA_DETAIL) ?></b></span><?= e(APP_NAME) ?>, <?= e(APP_ADDRESS) ?></div>
      <button class="app-btn">Ganti</button>
    </div>

    <label class="search">
      <i data-ico="search"></i>
      <input id="searchInput" type="search" placeholder="Cari kopi, makanan, snack...">
    </label>

    <section class="promo">
      <div class="promo-top"><span class="promo-tag">PROMO JAM NGOPI</span><span>s/d 17:00 WIB</span></div>
      <h2>Diskon 15% Manual Brew &amp; Toast</h2>
      <p>Nikmati sore sejuk Malang dengan seduhan...</p>
      <i class="promo-art" data-ico="cup"></i>
    </section>

    <nav class="chips" id="chips" aria-label="Kategori">
      <?php foreach ($kategori as $i => $k): ?>
        <button class="chip<?= $i === 0 ? ' is-active' : '' ?>"><?= $i === 0 ? '<i data-ico="star"></i>' : '' ?><?= e($k) ?></button>
      <?php endforeach; ?>
    </nav>

    <div class="section-head">
      <h2>Menu Favorit</h2>
      <small id="menuCount"><?= count($menu) ?> Pilihan Tersedia</small>
      <a href="#">Kearifan Lokal <i data-ico="flame"></i></a>
    </div>

    <section class="menu-list" id="menuList">
      <?php foreach ($menu as $m): partial('customer/_menu_card', ['m' => $m]); endforeach; ?>
    </section>
  </main>

  <a class="cart-bar" id="cartBar" href="<?= e(url('cart')) ?>" <?= $cart['items'] === 0 ? 'hidden' : '' ?>>
    <span class="cart-ico"><i data-ico="basket"></i><span class="cart-count" id="cartCount"><?= $cart['items'] ?></span></span>
    <span class="cart-info"><span id="cartText"><?= $cart['items'] ?> Item • Meja <?= e($meja) ?></span><b id="cartTotal"><?= rp($cart['subtotal']) ?></b></span>
    <span class="app-btn app-btn--accent">Lihat Pesanan <i data-ico="arrow"></i></span>
  </a>

  <?php partial('layout/bottom_nav', ['active' => $active]); ?>
