<div class="ks">
  <header class="ks-top">
    <h1>Kasir</h1>
    <span class="ks-sub">Pembayaran · Hari ini</span>
    <div class="ks-pills">
      <span class="ks-pill">Belum Bayar <b id="cBelum"><?= count($antrean) ?></b></span>
      <span class="ks-pill">Lunas <b id="cLunas"><?= Kasir::lunas() ?></b></span>
      <span class="ks-pill">Split <b id="cSplit"><?= $split ?></b></span>
      <span class="ks-pill">Kas Hari Ini <b id="cKas">Rp <?= e($kasJt) ?> jt</b></span>
    </div>
    <time class="ks-clock" id="ksClock">--.--</time>
  </header>

  <main class="container-fluid ks-main">
    <div class="row g-4 g-xl-5">
    <section class="ks-col col-12 col-lg-4">
      <div class="ks-h"><h2>Antrean Pembayaran</h2><span class="ks-count" id="qCount"><?= count($antrean) ?></span></div>
      <ul class="ks-queue" id="queue"></ul>
      <article class="ks-card ks-shift">
        <h3>Ringkasan Shift</h3>
        <dl id="shiftList"></dl>
        <p class="ks-shift-total"><span>Total</span><b id="shiftTotal"></b></p>
      </article>
    </section>

    <section class="ks-col col-12 col-lg-4">
      <div class="ks-h"><h2>Rincian Pesanan</h2></div>
      <article class="ks-card ks-detail" id="detailCard">
        <div id="detailBody"></div>
        <p class="ks-empty" id="detailEmpty" hidden>Semua tagihan sudah lunas.</p>
        <div class="ks-actions" id="detailActions">
          <button class="ks-btn-out" id="btnEdit">Edit Pesanan</button>
          <button class="ks-btn-out" id="btnDiskon">Tambah Diskon</button>
        </div>
      </article>
    </section>

    <section class="ks-col col-12 col-lg-4">
      <div class="ks-h"><h2>Pembayaran</h2></div>
      <article class="ks-card ks-pay" id="payCard">
        <small>Total Tagihan</small>
        <p class="ks-total" id="payTotal">Rp 0</p>
        <p class="ks-paid" id="payPaid" hidden></p>
        <hr>
        <h4>Metode Pembayaran</h4>
        <div class="ks-methods" id="methods">
          <button data-m="Tunai" class="is-on">Tunai</button>
          <button data-m="QRIS">QRIS</button>
          <button data-m="Kartu">Kartu</button>
          <button data-m="Split Bill">Split Bill</button>
        </div>

        <div id="splitBox" hidden>
          <h4>Split Bill</h4>
          <div class="ks-split">
            <div class="ks-stepper"><button id="spMin" aria-label="Kurangi">−</button><b id="spN">2</b><button id="spPlus" aria-label="Tambah">+</button></div>
            <p><span id="spInfo"></span><b id="spShare"></b></p>
          </div>
          <div class="ks-chips" id="splitVia"><button data-v="Tunai" class="is-on">Tunai</button><button data-v="QRIS">QRIS</button><button data-v="Kartu">Kartu</button></div>
        </div>

        <div id="cashBox">
          <h4>Uang Diterima</h4>
          <input class="ks-input" id="cash" inputmode="numeric" autocomplete="off" aria-label="Uang diterima">
          <div class="ks-chips" id="quick"></div>
          <p class="ks-change"><span>Kembalian</span><b id="change">Rp 0</b></p>
        </div>
        <p class="ks-note" id="noteBox" hidden></p>

        <button class="ks-pay-btn" id="btnPay">Bayar &amp; Cetak Struk</button>
      </article>
    </section>
    </div>
  </main>
</div>

<div class="modal fade ks-modal" id="dlgDiskon" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="frmDiskon" novalidate>
        <div class="modal-body">
          <h3>Tambah Diskon</h3>
          <p>Diskon dihitung dari subtotal sebelum PB1.</p>
          <div class="ks-chips" id="dPreset"><button type="button" data-p="0">0%</button><button type="button" data-p="5">5%</button><button type="button" data-p="10">10%</button><button type="button" data-p="15">15%</button><button type="button" data-p="20">20%</button></div>
          <label>Persen (0–100)<input class="ks-input" type="number" id="dPct" min="0" max="100" step="1" value="0"></label>
          <div class="ks-actions"><button type="button" class="ks-btn-out" data-bs-dismiss="modal">Batal</button><button type="submit" class="ks-pay-btn">Terapkan</button></div>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="application/json" id="ksData"><?= json_encode($ksData, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) ?></script>
