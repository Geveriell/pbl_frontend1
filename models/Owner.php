<?php
declare(strict_types=1);

class Owner
{
    public static function user(): array
    {
        return ['nama' => 'Darmawan Santoso / Hendra Wijaya', 'peran' => 'Executive Owner & Board', 'inisial' => 'DH'];
    }

    public static function tabs(): array
    {
        return [
            ['dapur', 'Dapur / Kitchen', 'pot'],
            ['kasir', 'Kasir', 'register'],
            ['waiters', 'Waiters', 'user'],
            ['customer', 'Customer', 'qr'],
            ['admin', 'Admin Resto', 'lock'],
        ];
    }

    public static function ringkasRole(): array
    {
        return [
            'kasir'    => ['Kasir', 'Antrean pembayaran & ringkasan shift', 'kasir', count(Kasir::antrean()) . ' tagihan menunggu'],
            'waiters'  => ['Waiters', 'Denah meja, ambil pesanan, antar pesanan', 'pelayan', count(Pelayan::meja()) . ' meja terpantau'],
            'customer' => ['Customer', 'Pesan dari meja (menu, keranjang, pembayaran)', 'menu', 'Meja ' . MEJA_DEFAULT . ' · simulasi pelanggan'],
            'admin'    => ['Admin Resto', 'Data menu, analisis penjualan, promo', 'admin-menu', count(Admin::dataMenu()) . ' menu terdaftar'],
        ];
    }

    public static function laporan(): array
    {
        return [
            'hari'  => ['omzet' => 142850000, 'naik' => '+14.2%', 'trx' => 1120, 'rata' => 'Rerata 93 pesanan / jam', 'bars' => [20.8, 24.1, 22.0, 27.5, 31.9, 32.0, 36.5], 'label' => ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min']],
            'minggu' => ['omzet' => 986400000, 'naik' => '+9.6%', 'trx' => 7840, 'rata' => 'Rerata 47 pesanan / jam', 'bars' => [20.8, 24.1, 22.0, 27.5, 31.9, 32.0, 36.5], 'label' => ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min']],
            'bulan' => ['omzet' => 4120500000, 'naik' => '+6.3%', 'trx' => 33410, 'rata' => 'Rerata 46 pesanan / jam', 'bars' => [880, 940, 1010, 1290], 'label' => ['Mg 1', 'Mg 2', 'Mg 3', 'Mg 4']],
            'tahun' => ['omzet' => 48760000000, 'naik' => '+18.9%', 'trx' => 402300, 'rata' => 'Rerata 46 pesanan / jam', 'bars' => [3.6, 3.4, 3.9, 4.0, 4.1, 4.3, 4.2, 4.5, 4.1, 4.4, 4.6, 5.1], 'label' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']],
        ];
    }

    public static function transaksi(): array
    {
        return [
            ['#SD-240508-01', '14:22 WIB', 'Meja 12 (VIP)', 'QRIS Dinamis', 348000],
            ['#SD-240508-02', '14:18 WIB', 'Meja 04', 'BCA Debit', 185000],
            ['#SD-240508-03', '14:15 WIB', 'Meja 09', 'Tunai Kasir', 92500],
            ['#SD-240508-04', '14:02 WIB', 'Meja 02', 'QRIS Dinamis', 210000],
            ['#SD-240508-05', '13:50 WIB', 'Meja 17', 'Mandiri Kartu', 144000],
        ];
    }

    public static function staf(): array
    {
        return [
            ['nama' => 'Hendra Wijaya', 'kode' => 'STF-001', 'peran' => 'admin', 'label' => 'Admin Operasional', 'tugas' => 'Akses penuh seluruh cabang & override otorisasi kasir', 'online' => true],
            ['nama' => 'Budi Setiadi', 'kode' => 'STF-014', 'peran' => 'admin', 'label' => 'Admin Operasional', 'tugas' => 'Supervisi operasional harian & kelola stok bahan', 'online' => true],
            ['nama' => 'Sarah Pratiwi', 'kode' => 'KSR-088', 'peran' => 'kasir', 'label' => 'Kasir (Shift A)', 'tugas' => 'Kasir aktif transaksi meja 01–20 & cetak tagihan', 'online' => true],
            ['nama' => 'Budi Santoso', 'kode' => 'KSR-092', 'peran' => 'kasir', 'label' => 'Kasir (Shift B)', 'tugas' => 'Kasir pengganti shift sore, persiapan serah terima laci', 'online' => true],
            ['nama' => 'Rudi Hartono', 'kode' => 'KDN-004', 'peran' => 'dapur', 'label' => 'Kepala Dapur', 'tugas' => 'Otoritas tiket masak KDS & ketersediaan stok menu', 'online' => true],
            ['nama' => 'Dimas Anggara', 'kode' => 'FLR-023', 'peran' => 'waiters', 'label' => 'Waiters / Captain', 'tugas' => 'Cuti tahunan, akses sistem ditangguhkan sementara', 'online' => false, 'nonaktif' => true],
        ];
    }

    public static function peran(): array
    {
        return ['admin' => 'Admin Operasional', 'kasir' => 'Kasir', 'dapur' => 'Dapur', 'waiters' => 'Waiters'];
    }

    public static function kendali(): array
    {
        return [
            ['akun' => '24 Akun', 'akunKet' => '12 Outlet tersinkronisasi', 'override' => '7 Aksi', 'overrideKet' => '4 Void, 3 Diskon khusus', 'integritas' => '100% OK', 'integritasKet' => '2FA & PIN Enkripsi Aktif'],
        ][0];
    }

    public static function matriksKolom(): array
    {
        return ['Owner / Super', 'Admin Ops', 'Kasir', 'Dapur', 'Waiters'];
    }

    public static function matriks(): array
    {
        return [
            ['Audit Finansial & Laporan', 'home', [1, 1, 0, 0, 0]],
            ['Override Diskon & Void Struk', 'basket', [1, 1, 0, 0, 0]],
            ['Kelola Menu & Resep HPP', 'book', [1, 1, 0, 1, 0]],
            ['Kasir & Tutup Shift Harian', 'register', [1, 1, 1, 0, 0]],
            ['KDS Dapur & Status Antrean Masak', 'pot', [1, 1, 0, 1, 1]],
        ];
    }
}
