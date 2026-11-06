<?php
declare(strict_types=1);

class Dapur
{
    public static function antrean(): array
    {
        return [
            ['id' => 'A-1042', 'meja' => '07', 'tipe' => 'Makan di tempat', 'status' => 'baru', 'detik' => 1, 'catatan' => 'pedas level 3, tanpa timun', 'items' => [[2, 'Ayam Geprek Sambal Matah'], [1, 'Kopi Susu Gula Aren']]],
            ['id' => 'A-1043', 'meja' => '03', 'tipe' => 'Makan di tempat', 'status' => 'baru', 'detik' => 62, 'catatan' => '', 'items' => [[1, 'Nasi Goreng Rempah'], [2, 'Cireng Krispi Sambal']]],
            ['id' => 'A-1044', 'meja' => '15', 'tipe' => 'Makan di tempat', 'status' => 'baru', 'detik' => 21, 'catatan' => '', 'items' => [[3, 'Croissant Cokelat'], [3, 'Soya Choa Cold Brew']]],
            ['id' => 'A-1038', 'meja' => '12', 'tipe' => 'Makan di tempat', 'status' => 'masak', 'detik' => 1120, 'catatan' => 'tanpa telur', 'items' => [[2, 'Ayam Geprek Sambal Matah'], [2, 'Nasi Goreng Rempah']]],
            ['id' => 'A-1040', 'meja' => '07', 'tipe' => 'Makan di tempat', 'status' => 'masak', 'detik' => 390, 'catatan' => '', 'items' => [[1, 'Cireng Krispi Sambal'], [2, 'Kopi Susu Gula Aren']]],
            ['id' => 'A-1041', 'meja' => '09', 'tipe' => 'Makan di tempat', 'status' => 'masak', 'detik' => 245, 'catatan' => '', 'items' => [[1, 'Croissant Cokelat'], [1, 'Soya Choa Cold Brew']]],
            ['id' => 'A-1036', 'meja' => '05', 'tipe' => 'Makan di tempat', 'status' => 'siap', 'detik' => 70, 'catatan' => '', 'items' => [[2, 'Nasi Goreng Rempah'], [2, 'Kopi Susu Gula Aren']]],
            ['id' => 'A-1035', 'meja' => '01', 'tipe' => 'Makan di tempat', 'status' => 'siap', 'detik' => 34, 'catatan' => '', 'items' => [[1, 'Ayam Geprek Sambal Matah'], [1, 'Soya Choa Cold Brew']]],
        ];
    }

    public const BATAS_TERLAMBAT = 15 * 60;
    public const RATA_MENIT = 11;
}
