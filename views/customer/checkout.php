  <main class="app app--bar" data-page="checkout">
    <?php partial('layout/page_top', ['topBack' => $topBack, 'topTitle' => $topTitle, 'meja' => $meja]); ?>

    <section class="app-card sec co-intro">
      <div class="co-top"><span class="co-ico"><i data-ico="receipt"></i></span><b>Finalisasi Santap</b><span class="pill"><span class="dot"></span>Meja Aktif</span></div>
      <h2>Checkout Pesanan Meja <?= e($meja) ?></h2>
      <p>Konfirmasi hidanganmu sebelum disajikan hangat oleh koki.</p>
    </section>

    <section class="app-card sec">
      <div class="sec-head"><h2><i data-ico="utensils"></i> Rincian Hidangan</h2><span class="pill">Dine-in</span></div>
      <ul class="co-items">
        <?php foreach ($lines as $l): $m = $l['m']; ?>
          <li>
            <div>
              <b><?= e($m['nama']) ?></b>
              <small><?= e($l['label']) ?><?= $l['note'] ? ' • “' . e($l['note']) . '”' : '' ?></small>
              <a class="pill" href="<?= e(url('detail', ['id' => (int) $m['id'], 'line' => $l['lid'], 'from' => 'checkout'])) ?>"><i data-ico="note"></i> Ubah Racikan</a>
            </div>
            <span class="co-p"><?= rp($l['sum']) ?></span>
          </li>
        <?php endforeach; ?>
      </ul>
      <div class="app-row"><span><?= $sum['items'] ?> item hidangan</span><b><?= rp($sum['subtotal']) ?></b></div>
      <div class="app-row app-row--sub"><span>Pajak &amp; Layanan (<?= (int) (PAJAK_SERVIS * 100) ?>%)</span><b><?= rp($sum['pajak']) ?></b></div>
      <div class="co-total"><div><small>Total Bayar</small><em>Sudah termasuk PPN</em></div><strong><?= rp($sum['total']) ?></strong></div>
    </section>

    <section class="app-card sec">
      <div class="sec-head"><h2><i data-ico="tag"></i> Kode Promo &amp; Member</h2></div>
      <div class="promo-in">
        <input id="promoCode" type="text" placeholder="Masukkan kode voucher / nomor member" autocomplete="off">
        <button type="button" class="app-btn app-btn--accent" id="btnPromo">Pakai</button>
      </div>
      <p class="notice"><i data-ico="star"></i><span>Dapatkan poin loyalty &amp; diskon promo khusus member pada setiap pesanan (minimal pembelian 300rb).</span></p>
    </section>

    <div class="sec-head"><h2><i data-ico="cash"></i> Metode Pembayaran</h2><small>Pilih salah satu</small></div>
    <div class="methods" id="methods">
      <?php foreach ($metode as $i => [$k, $ic, $nama, $ket, $badge]): ?>
        <label class="app-card method">
          <input type="radio" name="metode" value="<?= $k ?>" <?= $i === 0 ? 'checked' : '' ?>>
          <span class="m-ico"><i data-ico="<?= $ic ?>"></i></span>
          <span class="m-t"><b><?= e($nama) ?> <?php if ($badge): ?><em><?= e($badge) ?></em><?php endif; ?></b><small><?= e($ket) ?></small></span>
          <span class="opt-mark"><i data-ico="tick"></i></span>
        </label>
      <?php endforeach; ?>
    </div>
    <p class="notice"><i data-ico="info"></i><span>Setelah menekan tombol bayar, tim dapur akan langsung memproses pesanan Meja <?= e($meja) ?>.</span></p>
  </main>

  <div class="action-bar">
    <a class="btn-main" id="payBtn" href="<?= e(url('payment')) ?>"><span><i data-ico="bolt"></i> Pesan &amp; Bayar Sekarang</span><b><?= rp($sum['total']) ?></b></a>
    <p class="action-note"><i data-ico="lock"></i> Transaksi enkripsi aman &amp; otomatis terhubung kasir</p>
  </div>
