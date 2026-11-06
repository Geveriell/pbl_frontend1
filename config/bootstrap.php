<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/helpers.php';

foreach (['Pricing', 'Menu', 'Cart', 'Admin', 'Kasir', 'Dapur', 'Pelayan', 'Owner'] as $model) {
    require_once BASE_PATH . '/models/' . $model . '.php';
}

Cart::seedDemo();
