<?php
declare(strict_types=1);

class Pelayan
{
    public static function profil(): array
    {
        return ['nama' => 'Andi', 'shift' => 'siang'];
    }

    public static function meja(): array
    {
        $m = fn(string $no, string $status, int $kursi, int $tamu = 0, int $detik = 0, string $nama = '') =>
            ['no' => $no, 'status' => $status, 'kursi' => $kursi, 'tamu' => $tamu, 'detik' => $detik, 'nama' => $nama, 'tipe' => 'Makan di tempat'];
        return [
            $m('01', 'antar', 4, 2, 34), $m('02', 'kosong', 4), $m('03', 'terisi', 4, 2),
            $m('04', 'kosong', 2), $m('05', 'antar', 4, 2, 70), $m('06', 'kosong', 4),
            $m('07', 'terisi', 6, 4, 0, 'Budi Santoso'), $m('08', 'kosong', 6), $m('09', 'makan', 4, 2),
            $m('10', 'kosong', 4), $m('11', 'bantuan', 4, 2, 130), $m('12', 'terlambat', 4, 3, 1120),
        ];
    }

    public static function menu(): array
    {
        return [
            [1, 'Ayam Geprek Sambal Matah', 'Makanan', 28000], [2, 'Nasi Goreng Rempah', 'Makanan', 27000], [3, 'Capcay Goreng Ayam Spesial', 'Makanan', 54800],
            [4, 'Kopi Susu Gula Aren', 'Minuman', 22000], [5, 'Soya Choa Cold Brew', 'Minuman', 28000], [6, 'Es Teh Leci', 'Minuman', 14000],
            [7, 'Cireng Krispi Sambal Rujak', 'Camilan', 18000], [8, 'Croissant Butter Warm', 'Camilan', 24000], [9, 'Dimsum Mentai Panggang', 'Camilan', 24000],
        ];
    }

    public static function pesananAktif(): array
    {
        return ['07' => ['items' => [1 => 2, 4 => 1, 7 => 1], 'note' => 'Pedas level 3, tanpa timun']];
    }

    public static function antar(): array
    {
        return [
            ['no' => '05', 'ref' => 'A-1036', 'detik' => 70, 'items' => [[2, 'Nasi Goreng Rempah'], [2, 'Kopi Susu Gula Aren']]],
            ['no' => '01', 'ref' => 'A-1035', 'detik' => 34, 'items' => [[1, 'Ayam Geprek Sambal Matah'], [1, 'Soya Choa Cold Brew']]],
        ];
    }

    public static function panggilan(): array
    {
        return [
            ['jenis' => 'bantuan', 'no' => '11', 'detik' => 130, 'ket' => 'Menunggu'],
            ['jenis' => 'bill', 'no' => '03', 'detik' => 0, 'ket' => 'Pesanan sudah lengkap diantar'],
        ];
    }

    public static function ringkasan(): array
    {
        return ['ditangani' => 8, 'dikirim' => 14, 'diantar' => 12, 'rataDetik' => 130, 'bantuan' => 3];
    }
}
