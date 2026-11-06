<section class="ow-head ow-head--soft">
  <h1>Ringkasan Laporan &amp; Riwayat Penjualan</h1>
  <div class="ow-seg" id="owRange" role="tablist">
    <button class="is-on" data-r="hari">Hari Ini</button>
    <button data-r="minggu">7 Hari</button>
    <button data-r="bulan">1 Bulan</button>
    <button data-r="tahun">1 Tahun</button>
    <button data-r="kustom"><i data-ico="calendar"></i> <span id="owKustom">Pilih Tanggal</span></button>
  </div>
</section>

<section class="ow-stats ow-stats--2">
  <article class="ow-card ow-stat">
    <header><small>TOTAL PENDAPATAN</small><span class="ow-ic"><i data-ico="cash"></i></span></header>
    <p class="ow-big" id="rOmzet"></p>
    <p class="ow-trend"><i data-ico="trend"></i><b id="rNaik"></b><span>vs periode lalu</span></p>
  </article>
  <article class="ow-card ow-stat">
    <header><small>TOTAL TRANSAKSI</small><span class="ow-ic"><i data-ico="receipt"></i></span></header>
    <p class="ow-big"><span id="rTrx"></span> Struk</p>
    <p class="ow-trend"><span class="ow-dot"></span><span id="rRata"></span></p>
  </article>
</section>

<section class="ow-card ow-chart">
  <header>
    <div><h2>Tren Penjualan Ringkas</h2><p id="rChartSub">Aktivitas volume omset 7 hari terakhir</p></div>
    <span class="ow-legend"><i></i>Total Omset Harian</span>
  </header>
  <div class="ow-bars" id="rBars"></div>
</section>

<section class="ow-card ow-table">
  <header>
    <div><h2>Riwayat Transaksi Terbaru</h2><p>5 transaksi terverifikasi terakhir dari seluruh kasir cabang</p></div>
    <small>Pembaruan otomatis tiap 30 detik</small>
  </header>
  <div class="ow-scroll">
    <table>
      <thead><tr><th>ID STRUK</th><th>WAKTU</th><th>MEJA</th><th>METODE BAYAR</th><th class="r">TOTAL NOMINAL</th><th class="c">STATUS</th></tr></thead>
      <tbody>
        <?php foreach ($trx as [$id, $waktu, $meja, $metode, $total]): ?>
          <tr>
            <td class="id"><?= e($id) ?></td><td><?= e($waktu) ?></td><td><b><?= e($meja) ?></b></td><td><?= e($metode) ?></td>
            <td class="r"><b><?= e(rp($total)) ?></b></td><td class="c"><span class="ow-tag">Berhasil</span></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <footer class="ow-pager"><button disabled>Sebelumnya</button><span>1</span><button disabled>Berikutnya</button></footer>
</section>
<script type="application/json" id="owLaporan"><?= json_encode($laporan, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) ?></script>
