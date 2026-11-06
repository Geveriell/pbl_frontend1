  <main class="app app--pay" data-meja="<?= e($meja) ?>">
    <header class="pay-top">
      <a class="back" href="<?= e(url('payment')) ?>" aria-label="Kembali"><i data-ico="back"></i></a>
      <div class="pay-title"><b>MEJA <?= e($meja) ?></b><span>Split Bill</span></div>
      <span class="table-badge"><i data-ico="table"></i><?= e($meja) ?></span>
    </header>

    <section class="sp-total">
      <small><i data-ico="receipt"></i> TOTAL TAGIHAN MEJA <?= e($meja) ?></small>
      <strong><?= rp($sum['total']) ?></strong>
      <span><?= $sum['items'] ?> pesanan • sudah termasuk pajak &amp; layanan <?= (int) (PAJAK_SERVIS * 100) ?>%</span>
    </section>

    <div class="tabs" role="tablist">
      <button class="is-active" role="tab" data-mode="rata"><i data-ico="group"></i> Bagi Rata</button>
      <button role="tab" data-mode="item"><i data-ico="utensils"></i> Pilih per Item</button>
    </div>

    <section class="app-card sec" id="paneRata">
      <div class="sec-head"><div><h2>Simulasi Patungan</h2><small>Berapa orang yang bayar?</small></div>
        <div class="stepper"><button id="nMinus" aria-label="Kurangi orang"><i data-ico="minus"></i></button><span id="cnt">4</span><button class="plus" id="nPlus" aria-label="Tambah orang"><i data-ico="plus"></i></button></div>
      </div>
      <div class="share"><span class="m-ico"><i data-ico="cash"></i></span><div><small>Porsi pembayaran</small><b id="share">Rp 0</b> / orang</div><em id="pass"></em></div>
    </section>

    <section class="app-card sec" id="paneItem" hidden>
      <div class="sec-head"><div><h2>Pilih per Item</h2><small>Tentukan siapa yang membayar tiap menu</small></div></div>
      <ul class="assign" id="assign"></ul>
    </section>

    <div class="sec-head"><h2>Daftar Patungan Meja</h2><small id="partCount"></small></div>
    <ul class="people" id="people"></ul>

    <section class="split-share" id="btnShare" role="button" tabindex="0">
      <span class="m-ico"><i data-ico="share"></i></span>
      <div><b>Bagikan Rincian Meja <?= e($meja) ?></b><small>Kirim teks &amp; tautan QR ke WhatsApp Grup</small></div>
      <i data-ico="chevron"></i>
    </section>

    <a class="dev-skip" href="<?= e(url('status', ['paid' => 1, 'metode' => 'qris'])) ?>"><i data-ico="bolt"></i> Sementara: anggap semua sudah lunas<small>Lanjut ke Status Pesanan</small></a>
  </main>

  <div class="action-bar">
    <div class="prog"><b>Progress Pembayaran Meja: <span id="progTxt"></span></b><span id="progAmt"></span></div>
    <div class="prog-bar"><i id="progBar"></i></div>
    <a class="btn-main" href="<?= e(url('payment')) ?>"><span><i data-ico="qr"></i> Kembali ke QRIS Meja</span></a>
  </div>
  <script>window.SPLIT = <?= json_encode($splitData, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) ?>;</script>
