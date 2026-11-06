      <section class="page-title">
        <div><h1>Harga &amp; Diskon</h1><p>Atur harga dasar tiap menu dan beri diskon sekaligus untuk seluruh menu. Perubahan langsung dipakai di halaman customer.</p></div>
      </section>

      <?php if (isset($_GET['ok'])): ?><p class="flash flash--ok" role="status">Perubahan harga &amp; diskon tersimpan.</p><?php endif; ?>
      <?php if ($err): ?><p class="flash flash--err" role="alert"><?= e($err) ?></p><?php endif; ?>

      <form method="post" id="hrgForm" autocomplete="off">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">

        <section class="panel disc">
          <div class="disc-t">
            <h2 class="panel-h">Diskon Pusat</h2>
            <p>Potongan persen yang berlaku untuk semua menu yang ikut diskon. Harga coret otomatis tampil di menu customer.</p>
          </div>
          <label class="switch" title="Aktifkan diskon pusat"><input type="checkbox" name="aktif" id="dAktif" <?= $set['diskon_aktif'] ? 'checked' : '' ?>><span></span></label>
          <label class="disc-in">
            <input type="number" name="persen" id="dPersen" min="0" max="90" step="1" value="<?= (int) $set['diskon_persen'] ?>" inputmode="numeric">
            <b>%</b>
          </label>
          <p class="disc-sum" id="dSum"><b id="dCount"><?= $ikutN ?></b> dari <?= count($rows) ?> menu ikut diskon</p>
        </section>

        <section class="panel">
          <div class="panel-bar">
            <label class="search-adm"><i data-ico="search"></i><input id="hrgSearch" type="search" placeholder="Cari menu..."></label>
            <button type="submit" class="btn-save">Simpan Perubahan</button>
          </div>
          <ul class="hrg-list" id="hrgList">
            <?php foreach ($rows as $r): $id = (int) $r['id']; $ikut = !in_array($id, $set['tanpa_diskon'], true); ?>
              <li class="hrg-row" data-nama="<?= e(strtolower($r['nama'])) ?>">
                <span class="stok-img ph"><?php if ($r['foto']): ?><img src="<?= e(asset('assets/img/' . $r['foto'])) ?>" alt=""><?php endif; ?></span>
                <div class="stok-t"><b><?= e($r['nama']) ?></b><small>Tampil ke customer: <b class="hrg-final"><?= rp((int) $r['harga']) ?></b> <s class="hrg-old" <?= $r['diskon_persen'] ? '' : 'hidden' ?>><?= $r['diskon_persen'] ? rp((int) $r['harga_coret']) : '' ?></s></small></div>
                <label class="hrg-in"><span>Rp</span><input type="text" name="harga[<?= $id ?>]" value="<?= (int) $r['harga_dasar'] ?>" inputmode="numeric" aria-label="Harga dasar <?= e($r['nama']) ?>"></label>
                <label class="hrg-ikut"><span>Ikut diskon</span><span class="switch"><input type="checkbox" name="ikut[<?= $id ?>]" value="1" <?= $ikut ? 'checked' : '' ?>><span></span></span></label>
              </li>
            <?php endforeach; ?>
          </ul>
        </section>
      </form>
