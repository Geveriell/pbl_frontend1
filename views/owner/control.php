<?php
$aktif = $tab;
$hitung = ['baru' => 0, 'masak' => 0, 'siap' => 0];
foreach ($antrean as $o) {
    $hitung[$o['status']]++;
}
$kolom = ['baru' => 'Pesanan Baru', 'masak' => 'Sedang Dimasak', 'siap' => 'Siap Disajikan'];
$mmss = fn(int $s): string => sprintf('%02d:%02d', intdiv($s, 60), $s % 60);
?>
<nav class="ow-tabs" id="owTabs" role="tablist" aria-label="Role">
  <?php foreach ($tabs as [$k, $label, $ic]): ?>
    <button role="tab" class="<?= $aktif === $k ? 'is-on' : '' ?>" data-tab="<?= e($k) ?>" aria-selected="<?= $aktif === $k ? 'true' : 'false' ?>">
      <i data-ico="<?= e($ic) ?>"></i><?= e($label) ?><?php if ($k === 'dapur'): ?><em><?= count($antrean) ?></em><?php endif; ?>
    </button>
  <?php endforeach; ?>
</nav>

<section class="ow-panel" data-panel="dapur"<?= $aktif === 'dapur' ? '' : ' hidden' ?>>
  <div class="ow-kbar">
    <h1>Dapur</h1>
    <div class="ow-pills">
      <span>Baru <b><?= $hitung['baru'] ?></b></span>
      <span>Diproses <b><?= $hitung['masak'] ?></b></span>
      <span>Siap <b><?= $hitung['siap'] ?></b></span>
      <span>Rata-rata: <b class="is-plain"><?= Dapur::RATA_MENIT ?> mnt</b></span>
    </div>
  </div>
  <div class="ow-board" data-batas="<?= (int) $batas ?>">
    <?php foreach ($kolom as $st => $judul): ?>
      <section class="ow-kcol">
        <div class="ow-kh ow-kh--<?= $st ?>"><h2><?= e($judul) ?></h2><span><?= $hitung[$st] ?></span></div>
        <?php foreach ($antrean as $o): if ($o['status'] !== $st) continue;
            $late = $st === 'masak' && $o['detik'] >= $batas;
            $sub = $st === 'siap' ? 'Menunggu diantar' : ($late ? 'Prioritas Utama' : $o['tipe']); ?>
          <article class="ow-kcard t-<?= $st ?><?= $late ? ' is-late' : '' ?>">
            <header>
              <div>
                <h3>Meja <?= e($o['meja']) ?><?php if ($late): ?><span class="ow-late">TERLAMBAT</span><?php endif; ?></h3>
                <p>#<?= e($o['id']) ?> • <?= e($sub) ?></p>
              </div>
              <time data-detik="<?= (int) $o['detik'] ?>"><?= $mmss((int) $o['detik']) ?></time>
            </header>
            <div class="ow-kbody">
              <ul>
                <?php foreach ($o['items'] as [$q, $nama]): ?><li><em><?= (int) $q ?>×</em><span><?= e($nama) ?></span></li><?php endforeach; ?>
              </ul>
              <?php if ($o['catatan'] !== ''): ?><p class="ow-note"><?= $late ? '! ' : '' ?>Catatan: <?= e($o['catatan']) ?></p><?php endif; ?>
              <?php if ($st === 'baru'): ?><button class="ow-kbtn ow-kbtn--go" data-act="Pesanan dimulai dimasak">Mulai Masak</button>
              <?php elseif ($st === 'masak'): ?><button class="ow-kbtn ow-kbtn--ready" data-act="Pesanan ditandai siap">Tandai Siap</button>
              <?php else: ?><button class="ow-kbtn ow-kbtn--done" data-act="Pesanan sudah diantar">Sudah Diantar</button><?php endif; ?>
            </div>
          </article>
        <?php endforeach; ?>
        <?php if ($st === 'siap'): ?>
          <p class="ow-hint">Pesanan yang ditandai siap akan otomatis memunculkan notifikasi di ponsel waiter &amp; pelanggan pada halaman pelacakan pesanan meja.</p>
        <?php endif; ?>
      </section>
    <?php endforeach; ?>
  </div>
</section>

<?php foreach ($ringkas as $k => [$judul, $desc, $route, $info]): ?>
  <section class="ow-panel" data-panel="<?= e($k) ?>"<?= $aktif === $k ? '' : ' hidden' ?>>
    <div class="ow-kbar"><h1><?= e($judul) ?></h1><div class="ow-pills"><span><?= e($info) ?></span></div></div>
    <div class="ow-card ow-open">
      <p><?= e($desc) ?></p>
      <a class="ow-btn" href="<?= e(url($route)) ?>">Buka halaman <?= e($judul) ?></a>
    </div>
  </section>
<?php endforeach; ?>
