<div class="pl">
  <header class="pl-top">
    <h1>Pelayan</h1>
    <span class="pl-sub">Halo, <?= e($profil['nama']) ?> · Shift <?= e($profil['shift']) ?></span>
    <div class="pl-pills">
      <span class="pl-pill">Kosong <b id="cKosong"><?= $n['kosong'] ?></b></span>
      <span class="pl-pill">Terisi <b id="cTerisi"><?= $n['terisi'] ?></b></span>
      <span class="pl-pill">Antar <b id="cAntar"><?= $n['antar'] ?></b></span>
      <span class="pl-pill">Bantuan <b id="cBantuan"><?= $n['bantuan'] ?></b></span>
    </div>
    <button class="pl-out" id="btnBaru">+ Meja Baru</button>
    <time class="pl-clock" id="plClock">--.--</time>
  </header>

  <main class="container-fluid pl-main">
    <div class="row g-4 g-xl-5">
      <section class="pl-col col-12 col-lg-4">
        <div class="pl-h"><h2>Denah Meja</h2></div>
        <div class="pl-floor" id="floor"></div>
        <p class="pl-legend"><span><i class="lg-k"></i>Kosong</span><span><i class="lg-t"></i>Terisi</span><span><i class="lg-a"></i>Siap antar</span><span><i class="lg-b"></i>Bantuan</span></p>
        <div id="alerts" class="pl-alerts"></div>
      </section>

      <section class="pl-col col-12 col-lg-4">
        <div class="pl-h"><h2>Ambil Pesanan</h2></div>
        <article class="pl-card pl-order" id="orderCard">
          <h3 id="oTitle">Meja 07</h3>
          <p class="pl-meta" id="oMeta"></p>
          <div class="pl-tabs" id="oTabs"><button class="is-on" data-t="Makanan">Makanan</button><button data-t="Minuman">Minuman</button><button data-t="Camilan">Camilan</button></div>
          <ul class="pl-menu" id="oMenu"></ul>
          <label class="pl-note"><small>Catatan untuk dapur</small><textarea id="oNote" rows="2" maxlength="100" placeholder="Contoh: pedas level 3, tanpa timun"></textarea></label>
          <p class="pl-sum"><span id="oCount">0 item</span><b id="oSub">Subtotal Rp 0</b></p>
          <button class="pl-send" id="btnKirim">Kirim ke Dapur</button>
        </article>
      </section>

      <section class="pl-col col-12 col-lg-4">
        <div class="pl-h"><h2>Antar Pesanan</h2><span class="pl-count" id="hAntar"><?= $n['antar'] ?></span></div>
        <div id="antarList" class="pl-antar"></div>
        <p class="pl-none" id="antarNone" hidden>Tidak ada pesanan untuk diantar.</p>
        <article class="pl-card pl-shift">
          <h3>Ringkasan Shift Pelayan</h3>
          <dl id="shiftList"></dl>
          <p class="pl-shift-b"><span>Bantuan diterima</span><b id="sBantuan"></b></p>
        </article>
      </section>
    </div>
  </main>
</div>

<div class="modal fade pl-modal" id="dlgBuka" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="frmBuka" novalidate>
        <div class="modal-body">
          <h3>Buka Meja</h3>
          <label>Meja kosong<select class="pl-fld" id="bMeja"></select></label>
          <div class="row g-3">
            <div class="col-5"><label>Jumlah tamu<input class="pl-fld" type="number" id="bTamu" min="1" max="12" value="2"></label></div>
            <div class="col-7"><label>Nama (opsional)<input class="pl-fld" id="bNama" maxlength="30"></label></div>
          </div>
          <div class="pl-actions"><button type="button" class="pl-btn-out" data-bs-dismiss="modal">Batal</button><button type="submit" class="pl-send">Buka Meja</button></div>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="application/json" id="plData"><?= json_encode($plData, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) ?></script>
