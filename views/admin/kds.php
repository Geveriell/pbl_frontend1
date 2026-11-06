      <section class="kds-head">
        <span class="kds-ico"><i data-ico="ladle"></i></span>
        <h1>Station Utama,<br>Wok &amp; Bar</h1>
        <div class="kstat"><i data-ico="pot"></i><p><b id="kProses"><?= $menuProses ?></b><span>Menu<br>Diproses</span></p></div>
        <div class="kstat"><i data-ico="stopwatch"></i><p><b>11.2 <small>mnt</small></b><span>Avg Prep<br>Time</span></p></div>
        <div class="kstat kstat--red"><i data-ico="check"></i><p><b id="kSla"><?= $sla ?> Tiket</b><span>&gt;15 mnt<br>(SLA Over)</span></p></div>
      </section>

      <section class="kds-bar">
        <div class="stations" id="stations">
          <button class="chip-st is-active" data-st="all"><i data-ico="grid"></i>Semua Station <em data-count="all"><?= $sisa['all'] ?></em></button>
          <?php foreach ($stasiun as $k => [$nama, $ic]): ?>
            <button class="chip-st" data-st="<?= $k ?>"><i data-ico="<?= $ic ?>"></i><?= e($nama) ?> <em data-count="<?= $k ?>"><?= $sisa[$k] ?></em></button>
          <?php endforeach; ?>
        </div>
        <div class="kds-actions">
          <button class="btn-amber" id="btnWaiter"><i data-ico="bell"></i> Bunyikan Bel Waiter</button>
          <button class="btn-white" id="btnFull"><i data-ico="expand"></i> Layar Penuh KDS</button>
          <button class="btn-white" id="btnPrint"><i data-ico="printer"></i> Cetak Ulang Tiket</button>
        </div>
      </section>

      <section class="kds-grid" id="kdsGrid">
        <?php foreach ($tiket as $t): ?>
          <article class="ticket" data-meja="<?= e($t['meja']) ?>">
            <header class="tk-head tk-<?= e($t['state']) ?>">
              <span class="tk-tag"><?= e($t['label']) ?></span>
              <h2>Meja <?= e($t['meja']) ?></h2>
              <p><span>Server: <?= e($t['server']) ?></span><span><?= e($t['ago']) ?></span></p>
            </header>
            <div class="tk-body">
              <ul class="tk-items">
                <?php foreach ($t['items'] as $it): [$q, $nama, $cat, $st, $done, $hot] = $it; ?>
                  <li class="tk-it<?= $done ? ' is-done' : '' ?>" data-st="<?= e($st) ?>">
                    <label>
                      <input type="checkbox" <?= $done ? 'checked' : '' ?>>
                      <span class="cb"><i data-ico="tick"></i></span>
                      <span class="tk-t"><b><em><?= $q ?>×</em> <span class="nm"><?= e($nama) ?></span></b><small class="<?= $hot ? 'c-red' : '' ?>"><?= e($cat) ?></small></span>
                    </label>
                  </li>
                <?php endforeach; ?>
              </ul>
              <p class="tk-ok" hidden><i data-ico="verified"></i>Semua item telah siap di meja saji pass-through.</p>
              <button class="tk-btn" disabled>Selesaikan Tiket</button>
            </div>
          </article>
        <?php endforeach; ?>
      </section>
      <p class="empty-kds" id="emptyKds" hidden><i data-ico="smile"></i>Tidak ada tiket yang menunggu.</p>
