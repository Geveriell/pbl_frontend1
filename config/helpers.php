<?php
declare(strict_types=1);

function rp(int $n): string
{
    return 'Rp ' . number_format($n, 0, ',', '.');
}

function e(?string $s): string
{
    return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8');
}

function base_url(): string
{
    if (APP_BASE_URL !== '') {
        return rtrim(APP_BASE_URL, '/') . '/';
    }
    $dir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/'));
    $dir = preg_replace('#/api$#', '', $dir);
    return rtrim((string) $dir, '/') . '/';
}

function asset(string $path): string
{
    return base_url() . ltrim($path, '/');
}

function url(string $page = 'menu', array $query = []): string
{
    return base_url() . 'index.php?' . http_build_query(['page' => $page] + $query);
}

function redirect(string $page, array $query = []): never
{
    header('Location: ' . url($page, $query));
    exit;
}

function partial(string $name, array $vars = []): void
{
    extract($vars, EXTR_SKIP);
    include VIEW_PATH . '/' . $name . '.php';
}

function render(string $view, array $vars = []): void
{
    $vars += ['layout' => 'customer', 'title' => '', 'bodyClass' => '', 'css' => [], 'js' => [], 'active' => '', 'crumb' => null];
    extract($vars, EXTR_SKIP);
    require VIEW_PATH . '/layout/header.php';
    require VIEW_PATH . '/' . $view . '.php';
    require VIEW_PATH . '/layout/footer.php';
}

function meja(): string
{
    if (isset($_GET['meja']) && preg_match('/^\d{1,3}$/', (string) $_GET['meja'])) {
        $_SESSION['meja'] = str_pad((string) $_GET['meja'], 2, '0', STR_PAD_LEFT);
    }
    return $_SESSION['meja'] ?? MEJA_DEFAULT;
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['csrf'];
}
