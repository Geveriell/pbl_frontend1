      <section class="page-title">
        <div><h1>Kasir &amp; Rekap</h1><p>Ringkasan pembayaran shift pagi dan tagihan yang masih terbuka.</p></div>
      </section>

      <section class="stat-row stat-row--4">
        <article class="stat-card"><small>Pendapatan Hari Ini</small><p class="amt-lg"><b id="kRev" data-val="<?= $pendapatan ?>"><?= rp($pendapatan) ?></b></p><span>Sudah termasuk pajak &amp; layanan</span></article>
        <article class="stat-card"><small>Transaksi Lunas</small><p><b id="kCount"><?= count($trx) ?></b> Bill</p><span>Rata-rata <?= rp((int) round($pendapatan / max(1, count($trx)))) ?></span></article>
        <article class="stat-card"><small>Menunggu Bayar</small><p><b class="c-red" id="kWait"><?= count($tunggu) ?></b> Meja</p><span class="c-red strong">QRIS, Tunai &amp; Split Bill</span></article>
        <article class="stat-card"><small>Metode Terbanyak</small><p><b class="c-amber"><?= e((string) array_key_first($metode)) ?></b></p><span><?= rp((int) reset($metode)) ?></span></article>
      </section>

      <section class="two-col">
        <article class="panel">
          <h2 class="panel-h">Menunggu Pembayaran</h2>
          <ul class="wait-list" id="waitList">
            <?php foreach ($tunggu as $w): ?>
              <li data-total="<?= $w['total'] ?>">
                <span class="m-no"><?= e($w['meja']) ?></span>
                <div><b><?= rp($w['total']) ?> <small><?= e($w['ref']) ?></small></b><span><?= e($w['metode']) ?> • <?= e($w['ket']) ?></span></div>
                <button class="btn-red" data-lunas>Tandai Lunas</button>
              </li>
            <?php endforeach; ?>
          </ul>
          <p class="empty-kds" id="emptyWait" hidden><i data-ico="smile"></i>Semua tagihan sudah lunas.</p>
        </article>

        <article class="panel">
          <h2 class="panel-h">Metode Pembayaran</h2>
          <ul class="mt-list">
            <?php foreach ($metode as $nama => $jml): ?>
              <li><span><?= e($nama) ?></span><div class="bar"><i style="width:<?= (int) round($jml / $pendapatan * 100) ?>%"></i></div><b><?= rp($jml) ?></b></li>
            <?php endforeach; ?>
          </ul>
        </article>
      </section>

      <section class="panel">
        <h2 class="panel-h">Transaksi Selesai</h2>
        <div class="tbl-scroll">
          <table class="trx" id="trxTable">
            <thead><tr><th>Ref</th><th>Meja</th><th>Metode</th><th>Jam</th><th class="r">Total</th><th>Status</th></tr></thead>
            <tbody>
              <?php foreach ($trx as $t): ?>
                <tr><td><?= e($t['ref']) ?></td><td><?= e($t['meja']) ?></td><td><?= e($t['metode']) ?></td><td><?= e($t['jam']) ?></td><td class="r"><b><?= rp($t['total']) ?></b></td><td><span class="tp tp-grey">LUNAS</span></td></tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </section>
