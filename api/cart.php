<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/bootstrap.php';

header('Content-Type: application/json; charset=utf-8');

function fail(int $code, string $msg): never
{
    http_response_code($code);
    echo json_encode(['ok' => false, 'error' => $msg]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    fail(405, 'Metode tidak diizinkan');
}
if (!hash_equals(csrf_token(), $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '')) {
    fail(403, 'Token tidak valid');
}

$in     = json_decode((string) file_get_contents('php://input'), true) ?: [];
$id     = (int) ($in['id'] ?? 0);
$lid    = (string) ($in['line'] ?? '');
$action = (string) ($in['action'] ?? '');

if (!in_array($action, ['add', 'update', 'remove', 'dec'], true)) {
    fail(422, 'Data tidak valid');
}

$r    = (int) ($in['r'] ?? 0);
$a    = array_map('intval', (array) ($in['a'] ?? []));
$note = (string) ($in['note'] ?? '');

switch ($action) {
    case 'add':
        $lid = Cart::add($id, $r, $a, $note) ?? '';
        if ($lid === '') {
            fail(422, 'Pilihan tidak valid atau keranjang penuh');
        }
        break;
    case 'update':
        if (!Cart::update($lid, $r, $a, $note)) {
            fail(422, 'Porsi tidak ditemukan atau pilihan tidak valid');
        }
        break;
    case 'remove':
        if (!Cart::remove($lid)) {
            fail(404, 'Porsi tidak ditemukan');
        }
        break;
    case 'dec':
        if (Menu::find($id) === null) {
            fail(404, 'Menu tidak ditemukan');
        }
        Cart::removeLast($id);
        break;
}

$s = Cart::summary();
echo json_encode([
    'ok'       => true,
    'id'       => $id,
    'line'     => $lid,
    'qty'      => $id > 0 ? Cart::qty($id) : 0,
    'items'    => $s['items'],
    'total'    => $s['subtotal'],
    'totalFmt' => rp($s['subtotal']),
    'pajakFmt' => rp($s['pajak']),
    'grandFmt' => rp($s['total']),
]);
