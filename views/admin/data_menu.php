      <section class="pg-head">
        <div>
          <small class="eyebrow">KATALOG DAPUR &amp; KASIR</small>
          <h1>Data Menu</h1>
          <p>Kelola data hidangan, kategori, harga, dan ketersediaan stok menu restoran</p>
        </div>
        <button class="btn-brand" id="btnAdd"><i data-ico="plus"></i> Tambah Menu Baru</button>
      </section>

      <section class="dm-filter">
        <div class="dm-row">
          <label class="dm-search"><i data-ico="search"></i><input id="dmSearch" type="search" placeholder="Cari nama hidangan, atau bahan..." autocomplete="off"></label>
          <div class="pills" id="dmStatus">
            <button class="pill-f is-on" data-s="all">Semua Status (<span data-n="all"></span>)</button>
            <button class="pill-f" data-s="ok">Tersedia (<span data-n="ok"></span>)</button>
            <button class="pill-f" data-s="low">Stok Kritis (<span data-n="low"></span>)</button>
            <button class="pill-f" data-s="out">Habis / Sold Out (<span data-n="out"></span>)</button>
          </div>
        </div>
        <div class="dm-row dm-row--cat">
          <span class="dm-cat-l"><i data-ico="sliders"></i> Kategori:</span>
          <div class="pills" id="dmCat"></div>
        </div>
      </section>

      <section class="dm-table" aria-label="Daftar menu">
        <div class="dm-th"><span>MENU</span><span>KATEGORI</span><span>HARGA SATUAN</span><span>FOOD COST / MARGIN</span><span>STOK</span><span>AKSI</span></div>
        <div id="dmRows"></div>
        <p class="dm-none" id="dmNone" hidden>Tidak ada menu yang cocok.</p>
        <div class="dm-pager" id="dmPager"></div>
      </section>

      <div class="modal fade adm-modal" id="dlgMenu" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="frmMenu" novalidate>
        <div class="modal-body">
          <h3 id="dlgTitle">Tambah Menu Baru</h3>
          <label>Nama hidangan<input class="fld" id="fNama" required maxlength="60"></label>
          <label>Kategori<select class="fld" id="fKat"><option>Makanan Utama</option><option>Minuman</option><option>Camilan &amp; Dessert</option></select></label>
          <div class="row g-3">
            <div class="col-6"><label>Harga satuan (Rp)<input class="fld" id="fHarga" type="number" min="1" step="100" required></label></div>
            <div class="col-6"><label>Food cost (Rp)<input class="fld" id="fCost" type="number" min="0" step="10" required></label></div>
          </div>
          <label>Stok (porsi)<input class="fld" id="fStok" type="number" min="0" step="1" required></label>
          <div class="dlg-act"><button type="button" class="btn-line" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn-brand">Simpan</button></div>
        </div>
      </form>
    </div>
  </div>
</div>
      <script type="application/json" id="dmData"><?= json_encode($menu, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) ?></script>
