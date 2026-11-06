<?php

if ($layout === 'admin') { partial('layout/admin_close'); }
if ($layout === 'owner') { partial('layout/owner_close'); }
?>
  <script src="<?= e(asset('js/icons.js')) ?>"></script>
  <script src="<?= e(asset('js/bootstrap.bundle.min.js')) ?>"></script>
<?php foreach ($js as $j): ?>
  <script src="<?= e(asset('js/pages/' . $j . '.js')) ?>"></script>
<?php endforeach; ?>
</body>
</html>
