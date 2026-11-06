      <section class="an-head">
        <div class="an-t">
          <h1>Analisis &amp; Performa Penjualan</h1>
          <p>Monitoring omzet harian, volume pesanan meja, dan evaluasi menu terlaris</p>
        </div>
        <div class="an-tools">
          <div class="seg" id="anRange" role="tablist">
            <button class="is-on" data-r="hari">Hari Ini</button>
            <button data-r="minggu">7 Hari Terakhir</button>
            <button data-r="bulan">Bulan Ini</button>
            <button data-r="kustom"><i data-ico="calendar"></i> <span id="kLabel">Kustom Tanggal</span></button>
          </div>
          <button class="btn-brand" id="btnUnduh"><i data-ico="download"></i> Unduh Rekap Laporan</button>
        </div>
      </section>

      <section class="row g-4 an-cards">
        <div class="col-12 col-xl-4"><article class="an-card">
          <header><small>TOTAL PENJUALAN SHIFT</small><span class="an-ic"><i data-ico="cash"></i></span></header>
          <p class="an-big" id="aOmzet"></p>
          <p class="an-trend"><i data-ico="trend"></i><b id="aNaik"></b><span id="aBanding"></span></p>
          <p class="an-box"><span id="aTargetL"></span><b id="aTargetP"></b></p>
        </article></div>
        <div class="col-12 col-xl-4"><article class="an-card">
          <header><small>TOTAL TRANSAKSI &amp; MEJA</small><span class="an-ic"><i data-ico="receipt"></i></span></header>
          <p class="an-big"><span id="aTrx"></span> <em>Pesanan Meja</em></p>
          <p class="an-avg"><span>Rata-rata Tiket:</span><b id="aRata"></b><span>/ meja</span></p>
          <p class="an-box"><span id="aOkL"></span><b id="aOkP"></b></p>
        </article></div>
        <div class="col-12 col-xl-4"><article class="an-card">
          <header><small>KANAL PEMBAYARAN DOMINAN</small><span class="an-ic"><i data-ico="qr"></i></span></header>
          <p class="an-big" id="aKanal"></p>
          <p class="an-nom" id="aNominal"></p>
          <div class="an-stack" id="aStack"></div>
          <ul class="an-leg" id="aLeg"></ul>
        </article></div>
      </section>

      <section class="row g-4 an-lower">
        <div class="col-12 col-xl-8"><article class="an-panel">
          <header class="an-ph">
            <div><h2 id="cTitle">Tren Penjualan Jam Sibuk</h2><p id="cSub">Pola intensitas omzet &amp; volume pesanan berdasarkan jam operasional</p></div>
            <ul class="an-key"><li><i class="k-dark"></i>Omzet (Ratusan Ribu Rp)</li><li><i class="k-light"></i>Estimasi Rata-rata</li></ul>
          </header>
          <div class="chart" id="chart" role="img" aria-label="Grafik tren penjualan"></div>
        </article></div>
        <div class="col-12 col-xl-4"><article class="an-panel">
          <header class="an-ph"><div><h2>Distribusi Kategori</h2><p>Proporsi pesanan berdasarkan kategori kuliner</p></div></header>
          <div class="donut"><svg viewBox="0 0 120 120" id="donut" aria-hidden="true"></svg><p><b>100%</b><span id="dTiket"></span></p></div>
          <ul class="cat-list" id="catList"></ul>
        </article></div>
      </section>

      <div class="modal fade adm-modal" id="dlgTgl" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="frmTgl" novalidate>
        <div class="modal-body">
          <h3>Kustom Tanggal</h3>
          <div class="row g-3">
            <div class="col-6"><label>Dari<input class="fld" type="date" id="tglA" required></label></div>
            <div class="col-6"><label>Sampai<input class="fld" type="date" id="tglB" required></label></div>
          </div>
          <div class="dlg-act"><button type="button" class="btn-line" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn-brand">Terapkan</button></div>
        </div>
      </form>
    </div>
  </div>
</div>
      <script type="application/json" id="anData"><?= json_encode($salesData, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) ?></script>
