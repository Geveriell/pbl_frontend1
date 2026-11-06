<?php
declare(strict_types=1);

class Admin
{
    public static function user(): array
    {
        return ['nama' => 'Budi Setiadi', 'peran' => 'Admin Operasional', 'lantai' => 'Lantai 1 – Dining Room', 'shift' => 'Shift Pagi: 07:00 - 15:00', 'panggilan' => 2];
    }

    public static function alert(): array
    {
        return ['tag' => 'PRIORITY', 'ago' => '2 mnt ago', 'meja' => '07', 'teks' => 'Meja 07 minta bantuan cetak QR Split Bill (Tamu 4 orang)'];
    }

    public static function meja(): array
    {
        return [
            ['judul' => 'Area Utama • Indoor AC', 'jumlah' => '', 'ket' => '', 'meja' => [
                ['no' => '01', 'pill' => 'KOSONG', 'warna' => 'amber', 'idle' => true, 'ikon' => 'group', 'info' => '2 Kursi', 'foot' => 'Bersih & Siap Buka', 'footc' => 'ok', 'fi' => 'verified'],
                ['no' => '02', 'pill' => 'KOSONG', 'warna' => 'amber', 'idle' => true, 'ikon' => 'group', 'info' => '4 Kursi', 'foot' => 'Selesai Sanitasi', 'footc' => 'ok', 'fi' => 'verified'],
                ['no' => '03', 'pill' => 'COOKING', 'warna' => 'pink', 'ikon' => 'group', 'info' => '2 Tamu • waited', 'prog' => 75, 'proglabel' => 'Progres: 3/4 Menu'],
                ['no' => '04', 'pill' => 'LUNAS', 'warna' => 'grey', 'idle' => true, 'ikon' => 'group', 'info' => '2 Tamu • Done', 'amount' => 'Rp 182.000', 'cta' => 'Siap Bersihkan Meja'],
                ['no' => '05', 'pill' => 'BAYAR', 'warna' => 'red', 'ikon' => 'group', 'info' => '3 Tamu • 45 mnt', 'foot' => 'Tunggu QRIS Kasir', 'footc' => 'red', 'amount' => 'Rp 145.000', 'big' => true],
                ['no' => '06', 'pill' => 'DESSERT', 'warna' => 'grey', 'ikon' => 'group', 'info' => '2 Tamu • 54 mnt', 'foot' => 'Pisang Bakar & Gelato', 'amount' => 'Rp 112.000'],
                ['no' => '08', 'pill' => 'ORDER BARU', 'warna' => 'grey', 'ikon' => 'group', 'info' => '4 Tamu • Baru Masuk', 'foot' => '5 Item Belum ACC Dapur', 'footc' => 'red', 'amount' => 'Rp 182.500'],
            ]],
            ['judul' => 'Area Semi-Outdoor & VIP Balkon', 'jumlah' => '4 Meja', 'ket' => 'Smoking & Garden View', 'meja' => [
                ['no' => '07', 'pill' => 'SPLIT BILL', 'warna' => 'pink', 'ikon' => 'group', 'info' => '4 Tamu • 38 mnt', 'action' => true, 'prog' => 25, 'proglabel' => '1/4 Lunas (QRIS)', 'amount' => 'Rp 96.800', 'progred' => true, 'linkcta' => 'Minta cetak QR Split Bill'],
                ['no' => '10', 'pill' => 'MAKAN', 'warna' => 'pink', 'ikon' => 'group', 'info' => '6 Tamu • 62 mnt', 'foot' => 'Order Keluarga Besar', 'amount' => 'Rp 312.000'],
                ['no' => '11', 'pill' => 'PILIH MENU', 'warna' => 'amber', 'ikon' => 'device', 'info' => '4 Tamu • 8 mnt', 'foot' => 'Self-Order Session'],
                ['no' => '12', 'pill' => 'VIP ROOM', 'warna' => 'amber', 'idle' => true, 'ikon' => 'star', 'info' => '8 Kursi • Private', 'foot' => 'Siap Reservasi', 'fi' => 'door'],
            ]],
        ];
    }

    public static function stasiun(): array
    {
        return ['wok' => ['Wok & Tumis', 'flame'], 'grill' => ['Grill & Bakar', 'flame'], 'bar' => ['Bar & Minuman', 'cup']];
    }

    public static function tiket(): array
    {
        return [
            ['meja' => '03', 'state' => 'timeout', 'label' => 'TIME OUT', 'server' => 'Bagas P.', 'ago' => '18 Mnt lalu', 'sla' => true, 'items' => [
                [2, 'Capcay Goreng Ayam Spesial', 'Porsi 2 Orang, Kuah Kental', 'wok', true, false],
                [2, 'Es Jeruk Murni', 'Gula Normal, Es Sedang', 'bar', true, false],
            ]],
            ['meja' => '07', 'state' => 'process', 'label' => 'ON PROCESS', 'server' => 'Bagas P.', 'ago' => '12 Mnt lalu', 'items' => [
                [1, 'Ayam Geprek Sambal Matah', 'Level 3 Pedas • Sambal Dipisah • +Extra Nasi Putih', 'wok', false, true],
                [1, 'Dimsum Mentai Panggang', 'Porsi 4 pcs • Saus Mentai Bakar Ekstra', 'grill', false, false],
                [2, 'Es Teh Leci Savor', 'Less Sugar • Extra Ice', 'bar', true, false],
            ]],
            ['meja' => '09', 'state' => 'new', 'label' => 'NEW', 'server' => 'Bagas P.', 'ago' => '3 Mnt lalu', 'items' => [
                [1, 'Nasi Goreng Spesial Savor', 'Telur Mata Sapi 1/2 Matang • Pedas Sedang', 'wok', false, false],
                [1, 'Es Kopi Gula Aren', 'Normal Sweet • Susu Oat Plant-based', 'bar', false, false],
            ]],
            ['meja' => '10', 'state' => 'new', 'label' => 'NEW', 'server' => 'Bagas P.', 'ago' => '2 Mnt lalu', 'items' => [
                [1, 'Gurame Bakar Madu', 'Pedas Manis • Porsi Besar 800gr', 'grill', false, false],
                [1, 'Kangkung Belacan', 'Tumis Terasi Gurih • Sedang Pedas', 'wok', false, false],
                [4, 'Nasi Putih Pulen', 'Sajikan Hangat Bersama Ikan Bakar', 'wok', false, false],
            ]],
            ['meja' => '12', 'state' => 'new', 'label' => 'NEW', 'server' => 'Dewi A.', 'ago' => '1 Mnt lalu', 'items' => [
                [2, 'Cireng Krispi Sambal Rujak', 'Porsi Berbagi • Sambal Rujak Ekstra', 'wok', false, false],
                [1, 'Surya Citrus Cold Brew', 'Es Batu Normal • Bulir Jeruk Segar', 'bar', false, false],
            ]],
        ];
    }

    public static function antri(): int
    {
        return count(self::tiket());
    }

    public static function stok(): array
    {
        $isi = [1 => [42, 'Kopi'], 2 => [18, 'Makanan'], 3 => [6, 'Snack'], 4 => [0, 'Kopi'], 5 => [12, 'Pastry']];
        $rows = [];
        foreach (Menu::all() as $m) {
            $id = (int) $m['id'];
            $rows[] = ['id' => $id, 'nama' => $m['nama'], 'harga' => (int) $m['harga'], 'foto' => $m['foto'],
                       'stok' => $isi[$id][0] ?? 20, 'kategori' => $isi[$id][1] ?? 'Lainnya', 'tampil' => ($isi[$id][0] ?? 20) > 0];
        }
        return $rows;
    }

    public static function transaksi(): array
    {
        return [
            ['ref' => '#A1031', 'meja' => '04', 'metode' => 'QRIS', 'total' => 182000, 'jam' => '10:58'],
            ['ref' => '#A1029', 'meja' => '02', 'metode' => 'QRIS', 'total' => 96800, 'jam' => '10:21'],
            ['ref' => '#A1027', 'meja' => '01', 'metode' => 'Kartu', 'total' => 254100, 'jam' => '09:47'],
            ['ref' => '#A1024', 'meja' => '09', 'metode' => 'Tunai', 'total' => 68200, 'jam' => '09:15'],
            ['ref' => '#A1020', 'meja' => '11', 'metode' => 'QRIS', 'total' => 143000, 'jam' => '08:42'],
            ['ref' => '#A1018', 'meja' => '06', 'metode' => 'Kartu', 'total' => 121000, 'jam' => '08:10'],
        ];
    }

    public static function perJam(): array
    {
        $jam = [];
        for ($h = 7; $h <= 14; $h++) {
            $jam[sprintf('%02d', $h)] = 0;
        }
        foreach (self::transaksi() as $t) {
            $jam[substr($t['jam'], 0, 2)] += $t['total'];
        }
        return $jam;
    }

    public static function terlaris(): array
    {
        return [['Kopi Susu Surya Gula Aren', 38], ['Ayam Geprek Sambal Matah Crispy', 32], ['Nasi Goreng Bromo Rempah', 27], ['Surya Citrus Cold Brew', 21], ['Croissant Butter Warm', 17]];
    }

    public static function dataMenu(): array
    {
        $U = 'Makanan Utama'; $M = 'Minuman'; $C = 'Camilan & Dessert';
        $raw = [
            ['Ayam Geprek Sambal Matah', $U, 28000, 10640, 32], ['Capcay Goreng Ayam Spesial', $U, 54800, 23016, 18],
            ['Es Teh Leci', $M, 14000, 3300, 18], ['Dimsum Mentai Panggang', $C, 24000, 7680, 2],
            ['Ikan Bakar Jimbaran', $U, 65000, 31200, 0], ['Nasi Goreng Bromo Rempah', $U, 34000, 13600, 25],
            ['Gurame Bakar Madu', $U, 88000, 40480, 9], ['Soto Ayam Lamongan', $U, 30000, 10800, 21],
            ['Rawon Daging Surabaya', $U, 42000, 18480, 14], ['Mie Goreng Jawa', $U, 32000, 11520, 19],
            ['Bakso Malang Komplit', $U, 28000, 11200, 27], ['Sate Ayam Madura', $U, 36000, 15120, 3],
            ['Pecel Lele Sambal Terasi', $U, 26000, 9360, 16], ['Kangkung Belacan', $U, 24000, 7200, 12],
            ['Nasi Putih Pulen', $U, 6000, 1800, 60], ['Ayam Bakar Taliwang', $U, 40000, 16000, 11],
            ['Kopi Susu Gula Aren', $M, 22000, 7040, 40], ['Surya Citrus Cold Brew', $M, 26000, 8320, 4],
            ['Soya Choa Cold Brew', $M, 28000, 9520, 15], ['Es Jeruk Murni', $M, 15000, 4200, 30],
            ['Es Kopi Susu Oat', $M, 28000, 10360, 12], ['Teh Tarik Hangat', $M, 16000, 4160, 22],
            ['Wedang Jahe Malang', $M, 15000, 3600, 17], ['Es Cendol Durian', $M, 20000, 7000, 11],
            ['Cireng Krispi Sambal Rujak', $C, 18000, 5760, 26], ['Croissant Cokelat', $C, 30000, 12000, 13],
            ['Pisang Bakar Gelato', $C, 27000, 9720, 10], ['Kentang Goreng Keju', $C, 20000, 6000, 23],
        ];
        $out = [];
        foreach ($raw as $i => [$nama, $kat, $harga, $cost, $stok]) {
            $out[] = ['id' => $i + 1, 'nama' => $nama, 'kategori' => $kat, 'harga' => $harga, 'cost' => $cost, 'stok' => $stok];
        }
        return $out;
    }

    public static function penjualan(): array
    {
        $kanal = fn($q, $e, $t) => [['QRIS', $q[0], $q[1]], ['EDC', $e[0], $e[1]], ['Tunai', $t[0], $t[1]]];
        return [
            'hari' => ['label' => 'Hari Ini', 'omzet' => 4850000, 'banding' => 4330000, 'bandingLabel' => 'kemarin', 'targetLabel' => 'Target Harian', 'target' => 6500000,
                'trx' => 38, 'okupansi' => [19, 24], 'kanal' => $kanal([3240000, 25], [1000000, 8], [610000, 5]),
                'bars' => [['10:00', 100000, ''], ['11:00', 270000, ''], ['12:00', 780000, 'LUNCH RUSH'], ['13:00', 720000, 'LUNCH RUSH'], ['14:00', 300000, ''], ['15:00', 180000, ''], ['17:00', 220000, ''], ['18:30', 880000, 'DINNER RUSH'], ['19:30', 900000, 'DINNER RUSH'], ['20:30', 360000, ''], ['21:30', 140000, '']],
                'kategori' => [['Makanan Utama', 2813000], ['Minuman Segar', 1358000], ['Camilan & Side Dish', 679000]]],
            'minggu' => ['label' => '7 Hari Terakhir', 'omzet' => 32400000, 'banding' => 29100000, 'bandingLabel' => '7 hari sebelumnya', 'targetLabel' => 'Target 7 Hari', 'target' => 45500000,
                'trx' => 262, 'okupansi' => [17, 24], 'kanal' => $kanal([20900000, 170], [7000000, 58], [4500000, 34]),
                'bars' => [['Sen', 4200000, ''], ['Sel', 4000000, ''], ['Rab', 4400000, ''], ['Kam', 4600000, ''], ['Jum', 5300000, 'AKHIR PEKAN'], ['Sab', 5900000, 'AKHIR PEKAN'], ['Min', 4000000, '']],
                'kategori' => [['Makanan Utama', 18800000], ['Minuman Segar', 9100000], ['Camilan & Side Dish', 4500000]]],
            'bulan' => ['label' => 'Bulan Ini', 'omzet' => 128600000, 'banding' => 119200000, 'bandingLabel' => 'bulan lalu', 'targetLabel' => 'Target Bulanan', 'target' => 195000000,
                'trx' => 1038, 'okupansi' => [18, 24], 'kanal' => $kanal([83600000, 690], [26000000, 215], [19000000, 133]),
                'bars' => [['Mgg 1', 30100000, ''], ['Mgg 2', 31500000, ''], ['Mgg 3', 33200000, ''], ['Mgg 4', 33800000, '']],
                'kategori' => [['Makanan Utama', 74600000], ['Minuman Segar', 36000000], ['Camilan & Side Dish', 18000000]]],
        ];
    }
}
