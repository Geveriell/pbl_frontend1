  <main class="app app--bar" data-page="cart">
    <?php partial('layout/page_top', ['topBack' => $topBack, 'topTitle' => $topTitle, 'meja' => $meja]); ?>

    <?php if (!$lines): ?>
      <div class="empty">
        <i data-ico="basket"></i>
        <h2>Keranjang masih kosong</h2>
        <p>Pilih kopi atau makanan dari menu, lalu kembali ke sini.</p>
        <a class="app-btn app-btn--dark" href="<?= e(url('menu')) ?>">Lihat Menu</a>
      </div>
    <?php else: ?>
      <div class="sec-head cart-head">
        <h2>Pesanan Meja <?= e($meja) ?></h2>
        <a class="pill" href="<?= e(url('menu')) ?>"><i data-ico="plus"></i> Tambah Menu</a>
      </div>

      <section id="cartList" class="cart-list">
        <?php foreach ($lines as $l): $m = $l['m'];
          $edit = url('detail', ['id' => (int) $m['id'], 'line' => $l['lid'], 'from' => 'cart']);
          $more = url('detail', ['id' => (int) $m['id'], 'new' => 1, 'from' => 'cart']); ?>
          <article class="app-card cart-item" data-line="<?= e($l['lid']) ?>">
            <a class="menu-photo ph" href="<?= e($edit) ?>">
              <?php if ($m['foto']): ?><img src="<?= e(asset('assets/img/' . $m['foto'])) ?>" alt="<?= e($m['nama']) ?>" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;border-radius:inherit"><?php else: ?>foto<?php endif; ?>
            </a>
            <div class="ci-body">
              <h3><a href="<?= e($edit) ?>"><?= e($m['nama']) ?></a><?php if (($perMenu[$l['mid']] ?? 0) > 1): ?> <small class="ci-no">Porsi ke-<?= $l['no'] ?></small><?php endif; ?></h3>
              <?php if ($l['label']): ?><p class="ci-opt"><?= e($l['label']) ?></p><?php endif; ?>
              <?php if ($l['note']): ?><p class="ci-note"><i data-ico="note"></i> <?= e($l['note']) ?></p><?php endif; ?>
              <b class="ci-sum"><?= rp($l['sum']) ?></b>
              <div class="ci-actions">
                <a class="pill" href="<?= e($edit) ?>"><i data-ico="note"></i> Ubah Racikan</a>
                <a class="pill" href="<?= e($more) ?>"><i data-ico="plus"></i> Porsi Lagi</a>
                <button type="button" class="pill pill--del" data-act="remove">Hapus</button>
              </div>
            </div>
          </article>
        <?php endforeach; ?>
      </section>

      <section class="app-card sec sum">
        <div class="app-row"><span>Subtotal <small id="sItems">(<?= $sum['items'] ?> item)</small></span><b id="sSub"><?= rp($sum['subtotal']) ?></b></div>
        <div class="app-row"><span>Pajak &amp; Layanan (<?= (int) (PAJAK_SERVIS * 100) ?>%)</span><b id="sTax"><?= rp($sum['pajak']) ?></b></div>
      </section>
      <p class="notice"><i data-ico="info"></i><span>Pesanan baru dikirim ke dapur setelah pembayaran dikonfirmasi di langkah berikutnya.</span></p>
    <?php endif; ?>
  </main>

  <?php if ($lines): ?>
  <div class="action-bar above-nav" id="cartAction">
    <div class="action-row">
      <a class="btn-main" href="<?= e(url('checkout')) ?>"><span><i data-ico="receipt"></i> Lanjut ke Checkout</span><b id="sTotal"><?= rp($sum['total']) ?></b></a>
    </div>
  </div>
  <?php endif; ?>
  <?php partial('layout/bottom_nav', ['active' => $active]); ?>
