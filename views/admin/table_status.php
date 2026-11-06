      <section class="alert-bar" id="alertBar">
        <div class="alert-txt">
          <p><span class="tag"><?= e($al['tag']) ?></span><small>• <?= e($al['ago']) ?></small></p>
          <h2><?= e($al['teks']) ?></h2>
        </div>
        <div class="alert-act">
          <button class="btn-white" id="btnRespond" data-meja="<?= e($al['meja']) ?>"><i data-ico="eye"></i> Tanggapi Meja <?= e($al['meja']) ?></button>
          <button class="btn-ghost" id="btnDone">Tandai Selesai</button>
        </div>
      </section>

      <section class="stat-row">
        <article class="stat-card"><small>Kapasitas Lantai</small><p><b>16</b> Meja Aktif</p><span>8 Terisi • 5 Kosong</span></article>
        <article class="stat-card"><small>Menunggu Bayar</small><p><b class="c-red">3</b> Meja</p><span class="c-red strong">QRIS &amp; Split Bill</span></article>
        <article class="stat-card"><small>Kosong Bersih</small><p><b class="c-amber">5</b> Tersedia</p><span>3 Reguler | 2 VIP</span></article>
      </section>

      <?php foreach (Admin::meja() as $area): ?>
        <section class="area">
          <div class="area-head">
            <h2><?= e($area['judul']) ?></h2>
            <?php if ($area['jumlah']): ?><span class="tp tp-grey"><?= e($area['jumlah']) ?></span><?php endif; ?>
            <?php if ($area['ket']): ?><small><?= e($area['ket']) ?></small><?php endif; ?>
          </div>
          <div class="tbl-grid">
            <?php foreach ($area['meja'] as $t): partial('admin/_meja_card', ['t' => $t]); endforeach; ?>
          </div>
        </section>
      <?php endforeach; ?>

      <section class="side-row">
        <article class="pop">
          <span class="pop-img ph">foto menu</span>
          <div><small><span class="dot-warn"></span>42 porsi terhidang</small><h3>Ayam Geprek Sambal Matah Crispy</h3></div>
        </article>
        <article class="kds-link">
          <div><small>Status Antrian KDS</small><b><?= Admin::antri() ?> Antrian Aktif</b></div>
          <a class="btn-white" href="<?= e(url('admin-kds')) ?>">Buka Layar KDS <i data-ico="arrow"></i></a>
        </article>
      </section>
