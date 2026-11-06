<?php
declare(strict_types=1);

class Kasir
{

    public static function antrean(): array
    {
        return [
            ['id' => 'A-1042', 'meja' => '07', 'tipe' => 'Makan di tempat', 'pelanggan' => 'Budi Santoso', 'status' => 'siap', 'tone' => 'yellow', 'dibayar' => 0, 'diskon' => 0, 'split' => null, 'items' => [
                [2, 'Ayam Geprek Sambal Matah', 28000, 'Pedas level 3, tanpa timun'],
                [1, 'Kopi Susu Gula Aren', 22000, ''],
                [1, 'Cireng Krispi Sambal Rujak', 18000, ''],
            ]],
            ['id' => 'A-1038', 'meja' => '12', 'tipe' => 'Makan di tempat', 'pelanggan' => 'Rani Putri', 'status' => 'masak', 'tone' => 'orange', 'dibayar' => 0, 'diskon' => 0, 'split' => null, 'items' => [
                [1, 'Ayam Geprek Sambal Matah', 28000, 'Tanpa telur'],
                [1, 'Nasi Goreng Rempah', 27000, ''],
                [1, 'Kopi Susu Gula Aren', 22000, ''],
            ]],
            ['id' => 'A-1036', 'meja' => '05', 'tipe' => 'Makan di tempat', 'pelanggan' => 'Dimas Pratama', 'status' => 'siap', 'tone' => 'mint', 'dibayar' => 0, 'diskon' => 0, 'split' => null, 'items' => [
                [2, 'Croissant Cokelat', 30000, ''],
                [2, 'Soya Choa Cold Brew', 30000, ''],
            ]],
            ['id' => 'A-1035', 'meja' => '01', 'tipe' => 'Makan di tempat', 'pelanggan' => 'Keluarga Hartono', 'status' => 'sebagian', 'tone' => 'red', 'dibayar' => 48400, 'diskon' => 0, 'split' => ['k' => 2, 'n' => 4], 'items' => [
                [2, 'Gurame Bakar Madu', 44000, ''],
            ]],
        ];
    }

    public static function shift(): array
    {
        return ['Tunai' => 1120000, 'QRIS' => 1030000, 'Kartu' => 300000];
    }

    public static function lunas(): int
    {
        return 12;
    }
}
