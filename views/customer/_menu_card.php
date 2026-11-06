<article class="app-card menu-item" data-id="<?= (int) $m['id'] ?>" data-name="<?= e(strtolower($m['nama'] . ' ' . $m['deskripsi'])) ?>">
  <div class="menu-main">
    <a class="menu-photo ph" href="<?= e(url('detail', ['id' => (int) $m['id']])) ?>" aria-label="Detail <?= e($m['nama']) ?>">
      <?php if ($m['favorit']): ?><span class="badge-fav"><i data-ico="star"></i> Favorit</span><?php endif; ?>
      <?php if ($m['foto']): ?>
        <img src="<?= e(asset('assets/img/' . $m['foto'])) ?>" alt="<?= e($m['nama']) ?>" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;border-radius:inherit">
      <?php else: ?>foto menu<?php endif; ?>
    </a>
    <div class="menu-body">
      <h3><a href="<?= e(url('detail', ['id' => (int) $m['id']])) ?>"><?= e($m['nama']) ?></a></h3>
      <div class="menu-buy">
        <div class="price<?= $m['harga_coret'] ? ' price--sale' : '' ?>">
          <?php if ($m['harga_coret']): ?><s><?= rp((int) $m['harga_coret']) ?></s><?php endif; ?>
          <b><?= rp((int) $m['harga']) ?></b>
        </div>
        <div class="buy-ctrl" data-add="<?= e(url('detail', ['id' => (int) $m['id'], 'new' => 1, 'from' => 'menu'])) ?>">
          <?php if ($m['qty'] > 0): ?>
            <div class="qty">
              <button data-act="dec" aria-label="Hapus porsi terakhir"><i data-ico="minus"></i></button>
              <span><?= $m['qty'] ?></span>
              <a class="plus" href="<?= e(url('detail', ['id' => (int) $m['id'], 'new' => 1, 'from' => 'menu'])) ?>" aria-label="Tambah porsi dan racik"><i data-ico="plus"></i></a>
            </div>
          <?php else: ?>
            <a class="app-btn app-btn--accent btn-add" href="<?= e(url('detail', ['id' => (int) $m['id'], 'new' => 1, 'from' => 'menu'])) ?>"><i data-ico="plus"></i> Tambah</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
  <?php if ($m['opsi']): ?>
    <div class="menu-opts"><i data-ico="<?= e($m['ikon_opsi'] ?: 'sliders') ?>"></i><span><?= e($m['opsi']) ?></span></div>
  <?php endif; ?>
</article>
