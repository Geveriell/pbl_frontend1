<?php
declare(strict_types=1);

class Pricing
{
    private static ?array $cache = null;

    private static function file(): string
    {
        return __DIR__ . '/../data/pricing.json';
    }

    public static function load(): array
    {
        if (self::$cache !== null) {
            return self::$cache;
        }
        $d = ['diskon_aktif' => false, 'diskon_persen' => 0, 'harga' => [], 'tanpa_diskon' => []];
        if (is_file(self::file())) {
            $j = json_decode((string) file_get_contents(self::file()), true);
            if (is_array($j)) {
                $d = array_merge($d, $j);
            }
        }
        $d['diskon_persen'] = max(0, min(90, (int) $d['diskon_persen']));
        $d['harga']         = array_map('intval', is_array($d['harga']) ? $d['harga'] : []);
        $d['tanpa_diskon']  = array_map('intval', is_array($d['tanpa_diskon']) ? $d['tanpa_diskon'] : []);
        return self::$cache = $d;
    }

    public static function save(array $d): bool
    {
        $dir = dirname(self::file());
        if (!is_dir($dir) && !mkdir($dir, 0775, true)) {
            return false;
        }
        $ok = file_put_contents(self::file(), json_encode($d, JSON_PRETTY_PRINT), LOCK_EX) !== false;
        self::$cache = null;
        return $ok;
    }

    public static function persen(): int
    {
        $s = self::load();
        return $s['diskon_aktif'] ? (int) $s['diskon_persen'] : 0;
    }

    public static function potong(int $harga, int $persen): int
    {
        return max(0, (int) (round($harga * (100 - $persen) / 100 / 100) * 100));
    }

    public static function apply(array $m): array
    {
        $s    = self::load();
        $id   = (int) $m['id'];
        $has  = isset($s['harga'][$id]);
        $base = $has ? (int) $s['harga'][$id] : (int) $m['harga'];
        $pct  = self::persen();
        $ikut = !in_array($id, $s['tanpa_diskon'], true);

        $m['harga_dasar'] = $base;
        if ($pct > 0 && $ikut) {
            $m['harga_coret']    = $base;
            $m['harga']          = self::potong($base, $pct);
            $m['diskon_persen']  = $pct;
        } else {
            $m['harga'] = $base;
            if ($has) {
                $m['harga_coret'] = null;
            }
            $m['diskon_persen'] = 0;
        }
        return $m;
    }
}
