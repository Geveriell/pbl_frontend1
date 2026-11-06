<article class="tbl<?= !empty($t['action']) ? ' tbl--action' : '' ?>" data-meja="<?= e($t['no']) ?>" tabindex="0">
  <?php if (!empty($t['action'])): ?><span class="take">TAKE ACTION</span><?php endif; ?>
  <div class="tbl-head"><b class="<?= !empty($t['idle']) ? '' : 'c-hot' ?>"><?= e($t['no']) ?></b><span class="tp tp-<?= e($t['warna']) ?>"><?= e($t['pill']) ?></span></div>
  <p class="tbl-info"><i data-ico="<?= e($t['ikon']) ?>"></i><?= e($t['info']) ?></p>
  <div class="tbl-foot">
    <?php if (isset($t['prog'])): ?>
      <div class="prog-line"><span class="<?= !empty($t['progred']) ? 'c-red' : '' ?>"><?= e($t['proglabel']) ?></span><?php if (!empty($t['amount'])): ?><b><?= e($t['amount']) ?></b><?php else: ?><b class="c-hot"><?= (int) $t['prog'] ?>%</b><?php endif; ?></div>
      <div class="bar"><i class="<?= !empty($t['progred']) ? 'bar-red' : '' ?>" style="width:<?= (int) $t['prog'] ?>%"></i></div>
      <?php if (!empty($t['linkcta'])): ?><p class="c-red link-cta"><?= e($t['linkcta']) ?></p><?php endif; ?>
    <?php else: ?>
      <?php if (!empty($t['amount']) && empty($t['big'])): ?><b class="amt"><?= e($t['amount']) ?></b><?php endif; ?>
      <?php if (!empty($t['foot'])): ?><p class="foot-txt <?= ($t['footc'] ?? '') === 'red' ? 'c-red' : '' ?>"><span><?= e($t['foot']) ?></span><?php if (!empty($t['fi'])): ?><i data-ico="<?= e($t['fi']) ?>" class="c-ok"></i><?php endif; ?></p><?php endif; ?>
      <?php if (!empty($t['amount']) && !empty($t['big'])): ?><b class="amt amt--big"><?= e($t['amount']) ?></b><?php endif; ?>
      <?php if (!empty($t['cta'])): ?><button class="cta-pink"><?= e($t['cta']) ?></button><?php endif; ?>
    <?php endif; ?>
  </div>
</article>
