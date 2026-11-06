<?php

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
if ($path !== '/' && is_file(__DIR__ . $path)) {
    return false;
}
$slug = trim((string) $path, '/');
if ($slug !== '' && $slug !== 'index.php') {
    $_GET['page'] = $_GET['page'] ?? $slug;
}
$_SERVER['SCRIPT_NAME'] = '/index.php';
require __DIR__ . '/index.php';
