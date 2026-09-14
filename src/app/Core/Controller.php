<?php
namespace App\Core;

abstract class Controller
{
    protected function view(string $path, array $data = []): void
    {
        extract($data);
        $config = require __DIR__ . '/../Config/config.php';
        $viewFile = __DIR__ . '/../Views/' . $path . '.php';
        if (!file_exists($viewFile)) {
            http_response_code(500);
            die("Vista no encontrada: {$path}");
        }
        $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        require __DIR__ . '/../Views/layouts/header.php';
        require $viewFile;
        require __DIR__ . '/../Views/layouts/footer.php';
    }

    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }

    protected function input(string $key, $default = null)
    {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }

    protected function flash(string $tipo, string $mensaje): void
    {
        $_SESSION['flash'][] = ['tipo' => $tipo, 'mensaje' => $mensaje];
    }
}
