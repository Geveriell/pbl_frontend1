  <main class="app app--pay" data-sisa="<?= $sisa ?>" data-batas="<?= BATAS_BAYAR ?>" data-meja="<?= e($meja) ?>">

    <header class="pay-top">
<<<<<<< HEAD:views/customer/payment.php
      <a class="back" href="<?= e(url('checkout')) ?>" aria-label="Kembali"><i data-ico="back"></i></a>
=======
      <a class="back" href="index.php" aria-label="Kembali ke menu"><i data-ico="back"></i></a>
>>>>>>> 86ce094a8c2c90ac04beeb6125876965e70d8bc3:pembayaran.php
      <div class="pay-title"><b>MEJA <?= e($meja) ?></b><span>Payment Method</span></div>
      <span class="table-badge"><i data-ico="table"></i><?= e($meja) ?></span>
      <button class="icon-btn icon-btn--accent" aria-label="Akun"><i data-ico="user"></i></button>
    </header>

    <!-- Ponsel: satu kolom (urutan diatur lewat CSS order). Desktop: QR kiri, rincian kanan. -->
    <div class="pay-layout">

<<<<<<< HEAD:views/customer/payment.php
    <section class="app-card qris-card">
      <div class="qris-head">
        <span class="qris-logo">QRIS</span><span class="qris-tag">NASIONAL</span>
        <span class="qris-gpn">GPN &nbsp;Bersama</span>
=======
      <div class="pay-col pay-col--qr">
        <section class="card qris-card">
          <div class="qris-head">
            <span class="qris-logo">QRIS</span><span class="qris-tag">NASIONAL</span>
            <span class="qris-gpn">GPN &nbsp;Bersama</span>
          </div>

          <div class="qris-total">
            <small>TOTAL NOMINAL MEJA <?= e($meja) ?></small>
            <strong><?= rp($cart['total']) ?></strong>
            <em>Ref Pesanan: <?= e($ref) ?></em>
          </div>

          <div class="qr-box">
            <!-- Ganti <svg> ini dengan <img src="..."> QRIS dari payment gateway -->
            <svg id="qrGrid" viewBox="0 0 25 25" fill="#111" shape-rendering="crispEdges" role="img" aria-label="Kode QRIS pembayaran"></svg>
            <span class="c1"></span><span class="c2"></span>
            <span class="qr-logo"><i data-ico="utensils"></i></span>
          </div>

          <button class="btn btn--soft btn-block" id="btnSave"><i data-ico="download"></i> Simpan Gambar</button>

          <div class="wallets">
            <p>Dapat dibayar dari m-Banking &amp; Dompet Digital apa saja:</p>
            <ul><?php foreach (['GoPay', 'OVO', 'ShopeePay', 'DANA', 'BCA', 'Mandiri', 'BRI'] as $w): ?><li><?= e($w) ?></li><?php endforeach; ?></ul>
          </div>
        </section>
>>>>>>> 86ce094a8c2c90ac04beeb6125876965e70d8bc3:pembayaran.php
      </div>

      <div class="pay-col pay-col--info">
        <section class="timer">
          <div class="timer-head">
            <b><i data-ico="stopwatch"></i>BATAS WAKTU BAYAR</b>
            <span class="timer-clock" id="clock">14:47</span>
          </div>
          <p>Sistem mendeteksi transaksi secara real-time. QRIS otomatis terverifikasi begitu transfer berhasil.</p>
          <div class="timer-bar"><i id="timerBar"></i></div>
        </section>

        <section class="card detail">
          <div class="detail-head">
            <h2><i data-ico="receipt"></i>Rincian Pembayaran</h2>
            <span>Meja <?= e($meja) ?></span>
          </div>
          <div class="row"><span>Subtotal Hidangan <small>(<?= $cart['items'] ?> item)</small></span><b><?= rp($cart['subtotal']) ?></b></div>
          <div class="row"><span>PB1 &amp; Servis Resto (<?= (int) (PAJAK_SERVIS * 100) ?>%)</span><b><?= rp($cart['pajak']) ?></b></div>
          <div class="grand">
            <div><small>TOTAL YANG HARUS DIBAYAR</small><strong><?= rp($cart['total']) ?></strong></div>
            <span class="netto"><i data-ico="check"></i>Pas / Netto</span>
          </div>
        </section>

        <section class="split">
          <span class="split-ico"><i data-ico="group"></i></span>
          <div class="split-text"><b>Patungan Sama Teman?</b><span>Bagi total bill rata atau per menu.</span></div>
          <a class="btn btn--dark" id="btnSplit" href="split.php">Split Bill <i data-ico="arrow"></i></a>
        </section>

        <button class="check-status" id="btnCheck"><i data-ico="refresh"></i>Cek Status Pembayaran Manual</button>

        <p class="help"><i data-ico="bell"></i><span>Mengalami kendala? <a href="#" id="btnCall">Panggil Kasir ke Meja <?= e($meja) ?></a></span></p>
      </div>

<<<<<<< HEAD:views/customer/payment.php
      <div class="qr-box">

        <svg id="qrGrid" viewBox="0 0 25 25" fill="#111" shape-rendering="crispEdges"></svg>
        <span class="c1"></span><span class="c2"></span>
        <span class="qr-logo"><i data-ico="utensils"></i></span>
      </div>

      <button class="app-btn app-btn--soft btn-block" id="btnSave"><i data-ico="download"></i> Simpan Gambar</button>

      <div class="wallets">
        <p>Dapat dibayar dari m-Banking &amp; Dompet Digital apa saja:</p>
        <ul><?php foreach (['GoPay', 'OVO', 'ShopeePay', 'DANA', 'BCA', 'Mandiri', 'BRI'] as $w): ?><li><?= e($w) ?></li><?php endforeach; ?></ul>
      </div>
    </section>

    <section class="app-card detail">
      <div class="detail-head">
        <h2><i data-ico="receipt"></i>Rincian Pembayaran</h2>
        <span>Meja <?= e($meja) ?></span>
      </div>
      <div class="app-row"><span>Subtotal Hidangan <small>(<?= $cart['items'] ?> item)</small></span><b><?= rp($cart['subtotal']) ?></b></div>
      <div class="app-row"><span>PB1 &amp; Servis Resto (<?= (int) (PAJAK_SERVIS * 100) ?>%)</span><b><?= rp($cart['pajak']) ?></b></div>
      <div class="grand">
        <div><small>TOTAL YANG HARUS DIBAYAR</small><strong><?= rp($cart['total']) ?></strong></div>
        <span class="netto"><i data-ico="check"></i>Pas / Netto</span>
      </div>
    </section>

    <section class="split">
      <span class="split-ico"><i data-ico="group"></i></span>
      <div class="split-text"><b>Patungan Sama Teman?</b><span>Bagi total bill rata atau per menu.</span></div>
      <a class="app-btn app-btn--dark" href="<?= e(url('split')) ?>">Split Bill <i data-ico="arrow"></i></a>
    </section>

    <button class="check-status" id="btnCheck"><i data-ico="refresh"></i>Cek Status Pembayaran Manual</button>

    <a class="dev-skip" href="<?= e(url('status', ['paid' => 1, 'metode' => 'qris'])) ?>"><i data-ico="bolt"></i> Sementara: anggap sudah dibayar<small>Lanjut ke Status Pesanan</small></a>

    <p class="help"><i data-ico="bell"></i><span>Mengalami kendala? <a href="#" id="btnCall">Panggil Kasir ke Meja <?= e($meja) ?></a></span></p>
=======
    </div>
>>>>>>> 86ce094a8c2c90ac04beeb6125876965e70d8bc3:pembayaran.php
  </main>
