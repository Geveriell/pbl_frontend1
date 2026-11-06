<?php
declare(strict_types=1);

require __DIR__ . '/config/bootstrap.php';

$routes = require __DIR__ . '/config/routes.php';

<<<<<<< HEAD
$alias = ['customer' => 'menu', 'home' => 'roles', 'admin' => 'admin-menu', 'cashier' => 'kasir', 'kitchen' => 'dapur', 'waiter' => 'pelayan', 'owner' => 'owner-control'];
$page  = (string) ($_GET['page'] ?? '');
if ($page === '') {
    $page = trim((string) ($_SERVER['PATH_INFO'] ?? ''), '/');
}
$page = $alias[$page] ?? ($page !== '' ? $page : 'menu');

if (!isset($routes[$page])) {
    http_response_code(404);
    render('errors/404', ['title' => 'Tidak ditemukan', 'css' => ['menu'], 'bodyClass' => 'wide']);
    exit;
}
=======
include __DIR__ . '/includes/head.php';
?>
  <main class="app app--menu">
    <?php include __DIR__ . '/includes/header.php'; ?>

    <div class="table-bars">
    <div class="table-bar">
      <span><span class="dot"></span>Meja <?= e($meja) ?> • <?= e(AREA_MEJA) ?></span>
      <small>Menu Catalog</small>
    </div>
    <div class="table-bar table-bar--detail">
      <span class="tb-ico"><i data-ico="home"></i></span>
      <div class="tb-text"><b><span class="dot"></span>Meja <?= e($meja) ?> • <?= e(AREA_DETAIL) ?></b><?= e(APP_NAME) ?>, <?= e(APP_ADDRESS) ?></div>
      <button class="btn">Ganti</button>
    </div>
    </div>
>>>>>>> 86ce094a8c2c90ac04beeb6125876965e70d8bc3

$route = $routes[$page];
$ctx   = ['error' => null];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($route['post'])) {
    $ctx['error'] = ($route['post'])();
}

$data = isset($route['data']) ? ($route['data'])($ctx) : [];
$meta = array_diff_key($route, ['view' => 1, 'data' => 1, 'post' => 1]);

render($route['view'], $data + $meta);
