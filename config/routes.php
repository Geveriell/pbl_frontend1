<?php
declare(strict_types=1);

$customer = ['layout' => 'customer', 'bodyClass' => 'wide'];

return [

    'roles' => $customer + [
        'view' => 'roles', 'title' => 'Pintu Masuk Role', 'css' => ['menu'],
        'data' => fn(): array => ['links' => [
            ['Customer', 'Pesan dari meja (menu, keranjang, pembayaran)', 'menu'],
            ['Kasir', 'Antrean pembayaran & ringkasan shift', 'kasir'],
            ['Dapur', 'Antrean pesanan masuk, dimasak, siap', 'dapur'],
            ['Pelayan', 'Denah meja, ambil pesanan, antar pesanan', 'pelayan'],
            ['Admin', 'Data menu, analisis penjualan, promo', 'admin-menu'],
            ['Owner', 'Pusat kontrol multi-role, laporan periode, hak akses', 'owner-control'],
        ]],
    ],

    'menu' => $customer + [
        'view' => 'customer/menu', 'title' => 'Menu', 'css' => ['menu'], 'js' => ['menu'], 'active' => 'menu',
        'data' => function (): array {
            $menu = Menu::all();
            foreach ($menu as &$m) {
                $m['qty'] = Cart::qty((int) $m['id']);
            }
            unset($m);
            return [
                'meja'     => meja(),
                'menu'     => $menu,
                'cart'     => Cart::summary(),
                'kategori' => ['Best Seller', 'Kopi Khas Malang', 'Makanan Utama'],
            ];
        },
    ],

    'detail' => ['layout' => 'customer', 'bodyClass' => 'wide cols'] + [
        'view' => 'customer/detail', 'title' => 'Detail Menu', 'css' => ['detail'], 'js' => ['detail'],
        'data' => function (): array {
            $meja = meja();
            $id   = (int) ($_GET['id'] ?? 0);
            $m    = Menu::find($id);
            if ($m === null) {
                redirect('menu');
            }
            $o = Menu::options($id);

            $lid  = (string) ($_GET['line'] ?? '');
            $edit = $lid !== '' ? Cart::line($lid) : null;
            if ($lid !== '' && ($edit === null || (int) $edit['mid'] !== $id)) {
                redirect('cart');
            }
            $backs = [
                'menu'     => [url('menu'), 'Kembali ke Menu'],
                'cart'     => [url('cart'), 'Kembali ke Keranjang'],
                'checkout' => [url('checkout'), 'Kembali ke Checkout'],
            ];
            $from = (string) ($_GET['from'] ?? '');
            if (!isset($backs[$from])) {
                $from = $edit ? 'cart' : 'menu';
            }
            [$backUrl, $backLabel] = $backs[$from];

            return [
                'meja' => $meja, 'id' => $id, 'm' => $m, 'o' => $o, 'lid' => $lid, 'edit' => $edit,
                'backUrl' => $backUrl, 'backLabel' => $backLabel,
                'saved' => $edit ?? ['r' => 0, 'a' => [], 'note' => ''],
                'no' => $edit ? (int) $edit['no'] : Cart::qty($id) + 1,
                'topTitle' => 'Detail Menu', 'topBack' => $backUrl,
            ];
        },
    ],

    'cart' => $customer + [
        'view' => 'customer/cart', 'title' => 'Keranjang', 'css' => ['cart'], 'js' => ['cart'], 'active' => 'pesanan',
        'data' => function (): array {
            $lines   = Cart::lines();
            $perMenu = [];
            foreach ($lines as $l) {
                $perMenu[$l['mid']] = ($perMenu[$l['mid']] ?? 0) + 1;
            }
            return [
                'meja' => meja(), 'lines' => $lines, 'sum' => Cart::summary($lines), 'perMenu' => $perMenu,
                'topTitle' => 'Keranjang Pesanan', 'topBack' => url('menu'),
            ];
        },
    ],

    'checkout' => ['layout' => 'customer', 'bodyClass' => 'wide cols'] + [
        'view' => 'customer/checkout', 'title' => 'Checkout', 'css' => ['cart'], 'js' => ['cart'],
        'data' => function (): array {
            $meja  = meja();
            $lines = Cart::lines();
            $sum   = Cart::summary($lines);
            if ($sum['items'] === 0) {
                redirect('cart');
            }
            $metode = [
                ['qris', 'qr', 'QRIS Instant', 'GoPay, OVO, ShopeePay, BCA Mobile, dll', 'Instan'],
                ['kartu', 'card', 'Kartu Debit / Kredit', 'Mesin EDC dibawa pelayan ke Meja ' . $meja, ''],
                ['tunai', 'cash', 'Bayar Tunai', 'Selesaikan transaksi langsung di kasir resto', ''],
            ];
            return [
                'meja' => $meja, 'lines' => $lines, 'sum' => $sum, 'metode' => $metode,
                'topTitle' => 'Konfirmasi Checkout', 'topBack' => url('cart'),
            ];
        },
    ],

    'payment' => ['layout' => 'customer', 'bodyClass' => 'wide cols'] + [
        'view' => 'customer/payment', 'title' => 'Pembayaran', 'css' => ['payment'], 'js' => ['payment'],
        'data' => function (): array {
            $cart = Cart::summary();
            if ($cart['items'] === 0) {
                redirect('menu');
            }
            return ['meja' => meja(), 'cart' => $cart, 'ref' => Cart::ref(), 'sisa' => BATAS_BAYAR - 13];
        },
    ],

    'split' => ['layout' => 'customer', 'bodyClass' => 'wide cols'] + [
        'view' => 'customer/split', 'title' => 'Split Bill', 'css' => ['payment', 'split'], 'js' => ['split'],
        'data' => function (): array {
            $lines = Cart::lines();
            $sum   = Cart::summary($lines);
            if ($sum['items'] === 0) {
                redirect('menu');
            }
            return [
                'meja' => meja(), 'sum' => $sum,
                'splitData' => [
                    'n' => 4, 'total' => $sum['total'], 'pajak' => PAJAK_SERVIS,
                    'lines' => array_map(fn($l) => ['n' => $l['qty'] . '× ' . $l['m']['nama'], 'sum' => $l['sum']], $lines),
                ],
            ];
        },
    ],

    'status' => ['layout' => 'customer', 'bodyClass' => 'wide cols'] + [
        'view' => 'customer/status', 'title' => 'Status Pesanan', 'css' => ['status', 'menu'], 'js' => ['status'], 'active' => 'status',
        'data' => function (): array {
            $meja = meja();
            if (isset($_GET['paid'])) {
                $metode = in_array($_GET['metode'] ?? '', ['qris', 'kartu', 'tunai'], true) ? $_GET['metode'] : 'qris';
                Cart::checkout($metode);
                redirect('status');
            }
            return [
                'meja' => $meja, 'order' => Cart::order(),
                'label' => ['qris' => 'QRIS', 'kartu' => 'Kartu', 'tunai' => 'Tunai'],
            ];
        },
    ],

    'kasir' => [
        'view' => 'kasir/cashier', 'layout' => 'kasir', 'bodyClass' => 'ks-body', 'title' => 'Kasir', 'css' => ['kasir'], 'js' => ['kasir'],
        'data' => function (): array {
            $antrean = Kasir::antrean();
            $shift   = Kasir::shift();
            $kas     = array_sum($shift);
            return [
                'antrean' => $antrean,
                'split'   => count(array_filter($antrean, fn($o) => $o['split'] !== null)),
                'lunas'   => Kasir::lunas(),
                'kasJt'   => rtrim(rtrim(number_format($kas / 1000000, 2, ',', ''), '0'), ','),
                'ksData'  => ['orders' => $antrean, 'shift' => $shift, 'lunas' => Kasir::lunas(), 'pajak' => PAJAK_SERVIS],
            ];
        },
    ],

    'dapur' => [
        'view' => 'dapur/kitchen', 'layout' => 'dapur', 'bodyClass' => 'dp-body', 'title' => 'Dapur', 'css' => ['dapur'], 'js' => ['dapur'],
        'data' => function (): array {
            $antrean = Dapur::antrean();
            $n = ['baru' => 0, 'masak' => 0, 'siap' => 0];
            foreach ($antrean as $o) {
                $n[$o['status']]++;
            }
            return ['antrean' => $antrean, 'n' => $n, 'dpData' => ['orders' => $antrean, 'batas' => Dapur::BATAS_TERLAMBAT]];
        },
    ],

    'pelayan' => [
        'view' => 'pelayan/waiter', 'layout' => 'pelayan', 'bodyClass' => 'pl-body', 'title' => 'Pelayan', 'css' => ['pelayan'], 'js' => ['pelayan'],
        'data' => function (): array {
            $meja = Pelayan::meja();
            $n = ['kosong' => 0, 'terisi' => 0, 'antar' => 0, 'bantuan' => 0];
            foreach ($meja as $t) {
                $k = in_array($t['status'], ['terisi', 'makan', 'terlambat'], true) ? 'terisi' : $t['status'];
                $n[$k]++;
            }
            return [
                'profil' => Pelayan::profil(), 'n' => $n,
                'plData' => [
                    'tables' => $meja, 'menu' => Pelayan::menu(), 'orders' => (object) Pelayan::pesananAktif(),
                    'antar' => Pelayan::antar(), 'alerts' => Pelayan::panggilan(), 'sum' => Pelayan::ringkasan(),
                ],
            ];
        },
    ],

    'admin-menu' => [
        'view' => 'admin/data_menu', 'layout' => 'admin', 'bodyClass' => 'adm', 'title' => 'Data Menu', 'css' => ['admin'], 'js' => ['admin'], 'active' => 'menu',
        'data' => fn(): array => ['menu' => Admin::dataMenu()],
    ],

    'admin-sales' => [
        'view' => 'admin/sales_analysis', 'layout' => 'admin', 'bodyClass' => 'adm', 'title' => 'Analisis Penjualan', 'css' => ['admin'], 'js' => ['admin'], 'active' => 'analisis',
        'data' => fn(): array => ['salesData' => Admin::penjualan()],
    ],

    'admin-promo' => [
        'view' => 'admin/promo_price', 'layout' => 'admin', 'bodyClass' => 'adm', 'title' => 'Harga & Diskon', 'crumb' => 'Promo & Reservasi', 'css' => ['admin'], 'js' => ['admin'], 'active' => 'promo',
        'post' => function (): ?string {
            if (!hash_equals(csrf_token(), (string) ($_POST['csrf'] ?? ''))) {
                return 'Sesi tidak valid, muat ulang halaman lalu coba lagi.';
            }
            $old   = Pricing::load();
            $harga = $old['harga'];
            $tanpa = [];
            foreach (Menu::raw() as $m) {
                $id = (int) $m['id'];
                $v  = (int) preg_replace('/\D/', '', (string) ($_POST['harga'][$id] ?? ''));
                if ($v > 0 && $v <= 10000000) {
                    if ($v !== (int) $m['harga'] || isset($harga[$id])) {
                        $harga[$id] = $v;
                    }
                }
                if (empty($_POST['ikut'][$id])) {
                    $tanpa[] = $id;
                }
            }
            $ok = Pricing::save([
                'diskon_aktif'  => !empty($_POST['aktif']),
                'diskon_persen' => max(0, min(90, (int) ($_POST['persen'] ?? 0))),
                'harga'         => $harga,
                'tanpa_diskon'  => $tanpa,
            ]);
            if ($ok) {
                redirect('admin-promo', ['ok' => 1]);
            }
            return 'Gagal menyimpan. Pastikan folder data/ bisa ditulis oleh server.';
        },
        'data' => function (array $ctx = []): array {
            $set  = Pricing::load();
            $rows = Menu::all();
            return [
                'err'   => $ctx['error'] ?? null,
                'set'   => $set,
                'rows'  => $rows,
                'ikutN' => count(array_filter($rows, fn($r) => !in_array((int) $r['id'], $set['tanpa_diskon'], true))),
            ];
        },
    ],

    'owner-control' => [
        'view' => 'owner/control', 'layout' => 'owner', 'bodyClass' => 'ow', 'title' => 'Pusat Kontrol & Multi-Role', 'css' => ['owner'], 'js' => ['owner'], 'active' => 'kontrol',
        'data' => function (): array {
            $tab = (string) ($_GET['tab'] ?? 'dapur');
            return [
                'tab' => in_array($tab, ['dapur', 'kasir', 'waiters', 'customer', 'admin'], true) ? $tab : 'dapur',
                'tabs' => Owner::tabs(), 'ringkas' => Owner::ringkasRole(),
                'antrean' => Dapur::antrean(), 'batas' => Dapur::BATAS_TERLAMBAT,
            ];
        },
    ],

    'owner-report' => [
        'view' => 'owner/report', 'layout' => 'owner', 'bodyClass' => 'ow', 'title' => 'Laporan & Riwayat Periode', 'css' => ['owner'], 'js' => ['owner'], 'active' => 'laporan',
        'data' => fn(): array => ['laporan' => Owner::laporan(), 'trx' => Owner::transaksi()],
    ],

    'owner-access' => [
        'view' => 'owner/access', 'layout' => 'owner', 'bodyClass' => 'ow', 'title' => 'Hak Akses & Kendali Sistem', 'css' => ['owner'], 'js' => ['owner'], 'active' => 'akses',
        'data' => fn(): array => [
            'k' => Owner::kendali(), 'staf' => Owner::staf(), 'peran' => Owner::peran(),
            'kolom' => Owner::matriksKolom(), 'matriks' => Owner::matriks(),
        ],
    ],

    'admin-tables' => [
        'view' => 'admin/table_status', 'layout' => 'admin', 'bodyClass' => 'adm', 'title' => 'Status Meja', 'css' => ['admin'], 'js' => ['admin'], 'active' => 'status',
        'data' => fn(): array => ['al' => Admin::alert()],
    ],

    'admin-kds' => [
        'view' => 'admin/kds', 'layout' => 'admin', 'bodyClass' => 'adm', 'title' => 'KDS / Dapur', 'css' => ['admin'], 'js' => ['admin'], 'active' => 'kds',
        'data' => function (): array {
            $tiket   = Admin::tiket();
            $stasiun = Admin::stasiun();
            $menuProses = 0;
            $sla  = 0;
            $sisa = ['all' => 0];
            foreach ($stasiun as $k => $_) {
                $sisa[$k] = 0;
            }
            foreach ($tiket as $t) {
                $sla += !empty($t['sla']) ? 1 : 0;
                foreach ($t['items'] as $it) {
                    $menuProses += $it[0];
                    if (!$it[4]) {
                        $sisa['all']++;
                        $sisa[$it[3]]++;
                    }
                }
            }
            return ['tiket' => $tiket, 'stasiun' => $stasiun, 'menuProses' => $menuProses, 'sla' => $sla, 'sisa' => $sisa];
        },
    ],

    'admin-cashier' => [
        'view' => 'admin/cashier_report', 'layout' => 'admin', 'bodyClass' => 'adm', 'title' => 'Kasir & Rekap', 'css' => ['admin'], 'js' => ['admin'], 'active' => 'kasir',
        'data' => function (): array {
            $trx    = Admin::transaksi();
            $metode = [];
            foreach ($trx as $t) {
                $metode[$t['metode']] = ($metode[$t['metode']] ?? 0) + $t['total'];
            }
            arsort($metode);
            return ['trx' => $trx, 'tunggu' => Admin::menunggu(), 'pendapatan' => array_sum(array_column($trx, 'total')), 'metode' => $metode];
        },
    ],
];
