<div class="dp">
  <header class="dp-top">
    <h1>Dapur</h1>
    <span class="dp-sub">Antrean pesanan · Hari ini</span>
    <div class="dp-pills">
      <span class="dp-pill">Baru <b id="cBaru"><?= $n['baru'] ?></b></span>
      <span class="dp-pill">Diproses <b id="cMasak"><?= $n['masak'] ?></b></span>
      <span class="dp-pill">Siap <b id="cSiap" class="is-plain"><?= $n['siap'] ?></b></span>
      <span class="dp-pill">Rata-rata <b class="is-plain"><?= Dapur::RATA_MENIT ?> mnt</b></span>
    </div>
    <a class="dp-out" href="<?= e(url('admin-menu')) ?>">Stok Menu</a>
    <time class="dp-clock" id="dpClock">--.--</time>
  </header>

  <main class="container-fluid dp-main">
    <div class="row g-4 g-xl-5">
    <section class="dp-col col-12 col-lg-4" data-col="baru">
      <div class="dp-h dp-h--baru"><h2>Pesanan Baru</h2><span class="dp-count" id="hBaru"><?= $n['baru'] ?></span></div>
      <div class="dp-list" id="listBaru"></div>
      <p class="dp-empty" data-empty="baru" hidden>Tidak ada pesanan baru.</p>
    </section>
    <section class="dp-col col-12 col-lg-4" data-col="masak">
      <div class="dp-h dp-h--masak"><h2>Sedang Dimasak</h2><span class="dp-count" id="hMasak"><?= $n['masak'] ?></span></div>
      <div class="dp-list" id="listMasak"></div>
      <p class="dp-empty" data-empty="masak" hidden>Belum ada yang dimasak.</p>
    </section>
    <section class="dp-col col-12 col-lg-4" data-col="siap">
      <div class="dp-h dp-h--siap"><h2>Siap Disajikan</h2><span class="dp-count dp-count--siap" id="hSiap"><?= $n['siap'] ?></span></div>
      <div class="dp-list" id="listSiap"></div>
      <p class="dp-hint">Pesanan yang ditandai siap akan memunculkan notifikasi di ponsel pelanggan pada halaman pelacakan pesanan.</p>
    </section>
    </div>
  </main>
</div>
<script type="application/json" id="dpData"><?= json_encode($dpData, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) ?></script>
