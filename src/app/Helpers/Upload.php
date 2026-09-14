<?php
namespace App\Helpers;

class Upload
{
    public static function guardar(array $file, int $productoId): ?array
    {
        if (!isset($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK) return null;

        $config = require __DIR__ . '/../Config/config.php';
        $dir = $config['uploads_dir'];
        if (!is_dir($dir)) mkdir($dir, 0775, true);

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg','jpeg','png','gif','webp'])) return null;

        $filename = 'prod_' . $productoId . '_' . time() . '.' . $ext;
        if (!move_uploaded_file($file['tmp_name'], $dir . '/' . $filename)) return null;

        return ['nombre' => $file['name'], 'ruta' => $filename];
    }

    public static function eliminar(string $ruta): void
    {
        $config = require __DIR__ . '/../Config/config.php';
        $path = $config['uploads_dir'] . '/' . $ruta;
        if (is_file($path)) unlink($path);
    }
}
