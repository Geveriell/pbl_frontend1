  <main class="app" data-meja="<?= e($meja) ?>">
    <?php partial('layout/customer_top'); ?>

    <div class="table-bar">
      <span><span class="dot"></span>Meja <?= e($meja) ?> • <?= e(AREA_MEJA) ?></span>
      <small>Order Status</small>
    </div>

    <?php if (!$order): ?>
      <div class="empty">
        <i data-ico="receipt"></i>
        <h2>Belum ada pesanan aktif</h2>
        <p>Pesanan yang sudah dibayar akan muncul di sini beserta progres dapurnya.</p>
        <a class="app-btn app-btn--dark" href="<?= e(url('menu')) ?>">Lihat Menu</a>
      </div>
    <?php else: $s = $order['sum']; ?>
      <section class="live">
        <div class="live-top"><span class="pill live-pill"><span class="dot"></span>LIVE TRACKER</span><span><?= e($order['ref']) ?></span></div>
        <h2>Pesanan Meja <?= e($meja) ?> telah masuk!</h2>
        <p>Duduk manis, nikmati suasana sejuk Malang. Barista &amp; Dapur <?= e(APP_NAME) ?> sedang menyiapkan pesanan Anda dengan penuh kehangatan.</p>
      </section>

      <section class="app-card sec">
        <div class="eta"><div><small>Estimasi tiba di meja</small><strong>8 – 12 Menit</strong></div><span class="m-ico"><i data-ico="stopwatch"></i></span></div>
        <ol class="steps">
          <li class="done"><span class="dotx"><i data-ico="tick"></i></span><div><b>Pesanan Diterima <small><?= e($order['jam']) ?> WIB</small></b><p><?= $order['metode'] === 'tunai' ? 'Pesanan masuk antrean; bayar tunai di kasir.' : 'Sistem telah memverifikasi pembayaran ' . e($label[$order['metode']]) . '. Masuk ke antrean barista.' ?></p></div></li>
          <li class="now"><span class="dotx"><i data-ico="pot"></i></span><div><b>Sedang Diracik &amp; Dimasak <em>Proses</em></b><p>Barista dan dapur sedang menyiapkan <?= $order['sum']['items'] ?> hidangan Anda.</p><span class="chips2"><span class="pill"><i data-ico="cup"></i> Bar Barista</span><span class="pill"><i data-ico="flame"></i> Dapur Utama</span></span></div></li>
          <li><span class="dotx"><i data-ico="cloche"></i></span><div><b>Siap Diantar ke Meja <?= e($meja) ?></b><p>Pelayan <?= e(APP_NAME) ?> akan langsung membawakan ke meja Anda.</p></div></li>
          <li><span class="dotx"><i data-ico="smile"></i></span><div><b>Selesai &amp; Selamat Menikmati</b><p>Momen bersantai penuh kelezatan di <?= e(APP_ADDRESS) ?>.</p></div></li>
        </ol>
      </section>

      <section class="app-card sec">
        <div class="sec-head"><h2><i data-ico="receipt"></i> Rincian Pesanan</h2><span class="pill"><?= $s['items'] ?> item</span></div>
        <ul class="ord">
          <?php foreach ($order['lines'] as $l): $m = $l['m']; ?>
            <li>
              <span class="menu-photo ph" style="position:relative"><?php if ($m['foto']): ?><img src="<?= e(asset('assets/img/' . $m['foto'])) ?>" alt="" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;border-radius:inherit"><?php endif; ?></span>
              <div><b><?= $l['qty'] ?>× <?= e($m['nama']) ?><i><?= rp($l['sum']) ?></i></b><small><?= e($l['label']) ?><?= $l['note'] ? ' • ' . e($l['note']) : '' ?></small></div>
            </li>
          <?php endforeach; ?>
        </ul>
        <div class="ord-sum">
          <div><span>Subtotal</span><span><?= rp($s['subtotal']) ?></span></div>
          <div><span>PB1 Restoran (<?= (int) (PAJAK_SERVIS * 100) ?>%)</span><span><?= rp($s['pajak']) ?></span></div>
          <div class="grand-l"><span>Total Pembayaran <?= e($label[$order['metode']]) ?></span><span><?= rp($s['total']) ?> (<?= $order['metode'] === 'qris' ? 'Lunas' : 'Bayar di meja' ?>)</span></div>
        </div>
      </section>

      <button class="call" id="btnCall"><i data-ico="bell"></i><span>Panggil Pelayan ke Meja <?= e($meja) ?></span><i data-ico="chevron"></i></button>
      <div class="st-actions">
        <button class="app-btn app-btn--soft" id="btnStruk"><i data-ico="receipt"></i> Struk Digital</button>
        <a class="app-btn app-btn--accent" href="<?= e(url('menu')) ?>"><i data-ico="plus"></i> Pesan Tambahan</a>
      </div>
    <?php endif; ?>
  </main>
  <?php partial('layout/bottom_nav', ['active' => $active]); ?>
