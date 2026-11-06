<?php
declare(strict_types=1);

class Menu
{

    public static function all(): array
    {
        return array_map([Pricing::class, 'apply'], self::raw());
    }

    public static function raw(): array
    {
        if (DB_ENABLED) {
            try {
                return db()->query(
                    'SELECT id, nama, deskripsi, harga, harga_coret, favorit, foto, opsi, ikon_opsi
                       FROM menu WHERE tersedia = 1 ORDER BY urutan, id'
                )->fetchAll();
            } catch (PDOException $ex) {
                error_log('Menu::all — ' . $ex->getMessage());
            }
        }
        return self::sample();
    }

    public static function find(int $id): ?array
    {
        foreach (self::all() as $m) {
            if ((int) $m['id'] === $id) {
                return $m;
            }
        }
        return null;
    }

    public static function options(int $id): array
    {
        $t = [
            1 => ['Level Gula', 'Pilih 1 level kemanisan', [['Normal (100%)', 'Manis seimbang', 0], ['Less Sugar (50%)', 'Lebih ringan di lidah', 0], ['Tanpa Gula', 'Hanya manis alami susu', 0]],
                  [['Oat Milk', 'Ganti susu sapi', 5000], ['Extra Shot', 'Tambah satu shot espresso', 6000]]],
            2 => ['Tingkat Kepedasan', 'Pilih 1 tingkat pedas sesuai selera', [['Tidak Pedas', 'Bumbu rempah saja', 0], ['Sedang', 'Pedas nikmat berempah', 0], ['Pedas', 'Cabai rawit segar', 0]],
                  [['Telur Mata Sapi Ekstra', 'Setengah matang', 6000], ['Kerupuk', 'Kerupuk udang renyah', 3000], ['Sambal Ekstra', 'Sambal terasi', 3000]]],
            3 => ['Ukuran Porsi', 'Pilih 1 porsi', [['Isi 8 pcs', 'Porsi berbagi', 0], ['Isi 12 pcs', 'Untuk 3–4 orang', 8000]],
                  [['Sambal Rujak Ekstra', 'Satu mangkuk kecil', 3000], ['Saus Keju', 'Cocolan keju', 4000]]],
            4 => ['Jumlah Es', 'Pilih 1 jumlah es', [['Es Batu Normal', 'Dingin segar', 0], ['Less Ice', 'Es lebih sedikit', 0], ['Tanpa Es', 'Disajikan dingin', 0]],
                  [['Bulir Jeruk Ekstra', 'Jeruk lokal segar', 4000], ['Extra Shot', 'Tambah shot espresso', 6000]]],
            5 => ['Penyajian', 'Pilih 1 cara penyajian', [['Hangat', 'Dipanggang ulang', 0], ['Suhu Ruang', 'Tanpa dipanaskan', 0]],
                  [['Madu', 'Satu sendok madu', 4000], ['Selai Strawberry', 'Selai rumahan', 3000], ['Butter Ekstra', 'Satu pat butter', 3000]]],
        ];
        $d = $t[$id] ?? ['Penyajian', 'Pilih 1', [['Standar', 'Sesuai resep', 0]], []];
        return [
            'rating' => '4.9 (140+ ulasan)', 'waktu' => '10–15 mnt',
            'tags'   => ['Khas Malang', 'Disajikan Segar', 'Dine-In Favorit'],
            'req'    => ['title' => $d[0], 'sub' => $d[1], 'items' => $d[2]],
            'add'    => $d[3],
        ];
    }

    private static function sample(): array
    {
        return [
            ['id' => 1, 'nama' => 'Kopi Susu Surya Gula Aren',  'deskripsi' => 'Signature espresso gilingan segar, susu murni pasteurisasi, dan sirup aren organik',               'harga' => 22000, 'harga_coret' => 25000, 'favorit' => 1, 'foto' => '', 'opsi' => 'Opsi: Less Sugar (50%) • Oat Milk (+5k) • Extra Shot',      'ikon_opsi' => 'sliders'],
            ['id' => 2, 'nama' => 'Nasi Goreng Bromo Rempah',   'deskripsi' => 'Nasi goreng gurih dengan bumbu rempah khas lereng Bromo, telur mata sapi renyah,',                   'harga' => 34000, 'harga_coret' => null,  'favorit' => 0, 'foto' => '', 'opsi' => 'Tingkat Pedas: Sedang • Telur Setengah Matang',           'ikon_opsi' => 'utensils'],
            ['id' => 3, 'nama' => 'Cireng Krispi Sambal Rujak', 'deskripsi' => 'Snack renyah di luar kenyal di dalam khas Jawa Timur dengan racikan bumbu rujak...',                 'harga' => 18000, 'harga_coret' => null,  'favorit' => 0, 'foto' => '', 'opsi' => 'Porsi Berbagi: Isi 8 pcs • Sambal Rujak Ekstra',         'ikon_opsi' => 'flame'],
            ['id' => 4, 'nama' => 'Surya Citrus Cold Brew',     'deskripsi' => 'Cold brew 16 jam biji arabika dampit dengan perasan jeruk lokal Malang yang...',                    'harga' => 26000, 'harga_coret' => null,  'favorit' => 0, 'foto' => '', 'opsi' => 'Es Batu Normal • Bulir Jeruk Segar Asli',                'ikon_opsi' => 'snow'],
            ['id' => 5, 'nama' => 'Croissant Butter Warm',      'deskripsi' => 'Flaky golden butter croissant dipanggang ulang hangat, beraroma harum mentega...',                  'harga' => 24000, 'harga_coret' => null,  'favorit' => 0, 'foto' => '', 'opsi' => '',                                                          'ikon_opsi' => ''],
        ];
    }
}
