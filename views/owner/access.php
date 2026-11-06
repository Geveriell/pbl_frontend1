<section class="ow-head">
  <h1>Pusat Kendali Sistem &amp; Manajemen Hak Akses (Super Admin)</h1>
  <div class="ow-actions">
    <button class="ow-btn ow-btn--danger" id="btnLockdown"><i data-ico="refresh"></i> Emergency Lockdown</button>
    <button class="ow-btn ow-btn--soft" id="btnPolicy"><i data-ico="note"></i> Kebijakan PIN/Auth</button>
  </div>
</section>

<section class="ow-stats ow-stats--3">
  <article class="ow-card ow-stat"><div><small>STAF AKTIF TEROTORISASI</small><p class="ow-big"><?= e($k['akun']) ?></p><span><?= e($k['akunKet']) ?></span></div><span class="ow-ic"><i data-ico="group"></i></span></article>
  <article class="ow-card ow-stat"><div><small>OVERRIDE HARI INI</small><p class="ow-big is-hot"><?= e($k['override']) ?></p><span><?= e($k['overrideKet']) ?></span></div><span class="ow-ic"><i data-ico="lock"></i></span></article>
  <article class="ow-card ow-stat"><div><small>INTEGRITAS KEAMANAN</small><p class="ow-big"><?= e($k['integritas']) ?></p><span><?= e($k['integritasKet']) ?></span></div><span class="ow-ic"><i data-ico="verified"></i></span></article>
</section>

<section class="ow-card ow-wrap">
  <div class="ow-box ow-box--head">
    <span class="ow-ic"><i data-ico="group"></i></span>
    <div><h2>Tabel Manajemen Karyawan</h2><p>Kelola data staf, peran akses, dan penempatan cabang restoran secara efisien.</p></div>
    <button class="ow-btn" id="btnTambah"><i data-ico="plus"></i> Tambah Karyawan</button>
  </div>

  <div class="ow-box ow-filter">
    <label class="ow-search"><i data-ico="search"></i><input type="search" id="stCari" placeholder="Cari staf atau NIK..."></label>
    <select id="stPeran" aria-label="Filter peran">
      <option value="">Semua Peran</option>
      <?php foreach ($peran as $kk => $label): ?><option value="<?= e($kk) ?>"><?= e($label) ?></option><?php endforeach; ?>
    </select>
  </div>

  <div class="ow-tablebox">
    <div class="ow-scroll">
      <table id="stTabel">
        <thead><tr><th>KARYAWAN</th><th>ANGGOTA KARYAWAN</th><th>KETERANGAN &amp; TUGAS</th><th class="r">AKSI</th></tr></thead>
        <tbody>
          <?php foreach ($staf as $s):
              $ini = strtoupper(implode('', array_map(fn($w) => $w[0], array_slice(explode(' ', $s['nama']), 0, 2)))); ?>
            <tr data-peran="<?= e($s['peran']) ?>" data-cari="<?= e(strtolower($s['nama'] . ' ' . $s['kode'])) ?>">
              <td><span class="ow-av<?= !empty($s['nonaktif']) ? ' is-off' : '' ?>"><?= e($ini) ?><i class="<?= $s['online'] ? 'on' : '' ?>"></i></span><span><b><?= e($s['nama']) ?></b><small><?= e($s['kode']) ?></small></span></td>
              <td><span class="ow-role ow-role--<?= e($s['peran']) ?>"><?= e($s['label']) ?></span></td>
              <td><?= e($s['tugas']) ?></td>
              <td class="r">
                <button class="ow-mini" data-aksi="Edit <?= e($s['nama']) ?>">Edit</button>
                <?php if (!empty($s['nonaktif'])): ?><button class="ow-mini ow-mini--ok" data-aksi="Akun <?= e($s['nama']) ?> diaktifkan">Aktifkan</button>
                <?php else: ?><button class="ow-mini ow-mini--pin" data-aksi="PIN <?= e($s['nama']) ?> direset">Reset PIN</button><?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <footer class="ow-pager ow-pager--wide">
      <span>Menampilkan <b id="stJumlah"><?= count($staf) ?></b> dari <b>48</b> karyawan terdaftar</span>
      <div><button disabled>« Sebelumnya</button><button class="is-on">1</button><button>2</button><button>3</button><em>…</em><button>8</button><button>Selanjutnya »</button></div>
    </footer>
  </div>

  <div class="ow-matrix">
    <header><div><h2>Matriks Izin Fitur</h2><p>Pemetaan otoritas sistem operasional per peran secara langsung.</p></div><small>Perubahan tersimpan otomatis</small></header>
    <div class="ow-scroll">
      <table>
        <thead><tr><th>MODUL OPERASIONAL</th><?php foreach ($kolom as $c): ?><th class="c"><?= e($c) ?></th><?php endforeach; ?></tr></thead>
        <tbody>
          <?php foreach ($matriks as $i => [$modul, $ic, $izin]): ?>
            <tr>
              <td><i data-ico="<?= e($ic) ?>"></i><?= e($modul) ?></td>
              <?php foreach ($izin as $j => $v): ?>
                <td class="c"><button class="ow-perm<?= $v ? ' is-on' : '' ?>" data-i="<?= $i ?>" data-j="<?= $j ?>" aria-pressed="<?= $v ? 'true' : 'false' ?>" aria-label="<?= e($modul . ' – ' . $kolom[$j]) ?>"><?= $v ? '<i data-ico="check"></i>' : '–' ?></button></td>
              <?php endforeach; ?>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
