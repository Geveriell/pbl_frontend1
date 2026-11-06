  <main class="app app--bar">
    <?php partial('layout/page_top', ['topBack' => $topBack, 'topTitle' => $topTitle, 'meja' => $meja]); ?>

    <div class="det-bar">
      <a class="pill" href="<?= e($backUrl) ?>"><i data-ico="back"></i> <?= e($backLabel) ?></a>
      <?php if ($m['favorit']): ?><span class="pill"><i data-ico="flame"></i> Best Seller</span><?php endif; ?>
    </div>

    <div class="det-hero ph">
      <?php if ($m['foto']): ?><img src="<?= e(asset('assets/img/' . $m['foto'])) ?>" alt="<?= e($m['nama']) ?>"><?php else: ?>foto menu<?php endif; ?>
      <span class="det-tag"><i data-ico="utensils"></i> Porsi ke-<?= $no ?> • Meja <?= e($meja) ?></span>
      <div class="det-price"><small><?= !empty($m['diskon_persen']) ? 'Diskon ' . (int) $m['diskon_persen'] . '%' : 'Harga Dasar' ?></small><?php if ($m['harga_coret']): ?><s><?= rp((int) $m['harga_coret']) ?></s> <?php endif; ?><b><?= rp((int) $m['harga']) ?></b></div>
      <button class="det-heart" id="btnHeart" aria-label="Favorit" aria-pressed="false"><i data-ico="heart"></i></button>
    </div>

    <section class="app-card sec">
      <div class="sec-head">
        <h2 class="det-name"><?= e($m['nama']) ?></h2>
        <span class="det-cloche"><i data-ico="cloche"></i></span>
      </div>
      <p class="det-meta"><span><i data-ico="star"></i> <?= e($o['rating']) ?></span><span><i data-ico="clock"></i> <?= e($o['waktu']) ?></span></p>
      <p class="det-desc"><?= e($m['deskripsi']) ?></p>
      <p class="det-tags"><?php foreach ($o['tags'] as $t): ?><span><?= e($t) ?></span><?php endforeach; ?></p>
    </section>

    <form id="detForm" data-id="<?= $id ?>" data-base="<?= (int) $m['harga'] ?>" data-line="<?= e($edit ? $lid : '') ?>" data-back="<?= e($backUrl) ?>" onsubmit="return false">
      <section class="app-card sec">
        <div class="sec-head"><div><h2><?= e($o['req']['title']) ?></h2><small><?= e($o['req']['sub']) ?></small></div><span class="pill">Wajib</span></div>
        <?php foreach ($o['req']['items'] as $i => $it): ?>
          <label class="opt">
            <input type="radio" name="r" value="<?= $i ?>" data-p="<?= (int) $it[2] ?>" <?= (int) $saved['r'] === $i ? 'checked' : '' ?>>
            <span class="opt-mark"></span>
            <span class="opt-t"><b><?= e($it[0]) ?></b><small><?= e($it[1]) ?></small></span>
            <?php if ($it[2]): ?><em>+<?= rp((int) $it[2]) ?></em><?php endif; ?>
          </label>
        <?php endforeach; ?>
      </section>

      <?php if ($o['add']): ?>
      <section class="app-card sec">
        <div class="sec-head"><div><h2>Tambahan / Add-ons</h2><small>Bisa pilih lebih dari satu</small></div><span class="pill">Opsional</span></div>
        <?php foreach ($o['add'] as $i => $it): ?>
          <label class="opt opt--check">
            <input type="checkbox" name="a" value="<?= $i ?>" data-p="<?= (int) $it[2] ?>" <?= in_array($i, $saved['a'], true) ? 'checked' : '' ?>>
            <span class="opt-mark"><i data-ico="tick"></i></span>
            <span class="opt-t"><b><?= e($it[0]) ?></b><small><?= e($it[1]) ?></small></span>
            <em>+<?= rp((int) $it[2]) ?></em>
          </label>
        <?php endforeach; ?>
      </section>
      <?php endif; ?>

      <section class="app-card sec">
        <div class="sec-head"><div><h2><i data-ico="note"></i> Catatan Khusus untuk Dapur</h2><small>Beri tahu koki preferensi rasa atau alergi Anda.</small></div><span class="pill" id="noteCount">0/100</span></div>
        <textarea id="note" maxlength="100" rows="3" placeholder="Contoh: sambal dipisah, jangan pakai timun"><?= e($saved['note']) ?></textarea>
        <div class="quick">
          <?php foreach (['Sambal dipisah', 'Tanpa timun', 'Goreng kering'] as $q): ?><button type="button" class="pill" data-quick="<?= e($q) ?>"><i data-ico="plus"></i> <?= e($q) ?></button><?php endforeach; ?>
        </div>
      </section>
    </form>

    <p class="notice"><i data-ico="check"></i><span>Pesanan langsung dikirim ke antrean dapur Meja <?= e($meja) ?> sesaat setelah Anda mengonfirmasi keranjang.</span></p>
  </main>

  <div class="action-bar">
    <div class="action-row">
      <a class="app-btn app-btn--soft" href="<?= e($backUrl) ?>">Batal</a>
      <button type="button" class="btn-main" id="btnSave"><span><i data-ico="tick"></i> <?= $edit ? 'Simpan Perubahan' : 'Selesai' ?></span><b id="btnTotal"><?= rp((int) $m['harga']) ?></b></button>
    </div>
    <p class="action-note"><?= $edit ? 'Mengubah racikan porsi ke-' . $no : 'Selesai meracik, lalu kembali untuk menambah porsi lain atau lanjut ke keranjang' ?></p>
  </div>
