<?php

$appJs = [
    'api'    => asset('api/cart.php'),
    'routes' => ['payment' => url('payment'), 'statusPaid' => url('status', ['paid' => 1])],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <meta name="csrf-token" content="<?= e(csrf_token()) ?>">
  <title><?= e(APP_NAME) ?> — <?= e($title) ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= e(asset('css/bootstrap.min.css')) ?>">
  <link rel="stylesheet" href="<?= e(asset('css/style.css')) ?>">
<?php foreach ($css as $c): ?>
  <link rel="stylesheet" href="<?= e(asset('css/pages/' . $c . '.css')) ?>">
<?php endforeach; ?>
  <script>window.APP = <?= json_encode($appJs, JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP) ?>; window.API_CART = window.APP.api;</script>
</head>
<body<?= $bodyClass !== '' ? ' class="' . e($bodyClass) . '"' : '' ?>>
<?php if ($layout === 'admin') { partial('layout/admin_open', ['active' => $active, 'crumb' => $crumb ?? $title]); } ?>
<?php if ($layout === 'owner') { partial('layout/owner_open', ['active' => $active]); } ?>
