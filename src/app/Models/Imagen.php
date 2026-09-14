<?php
namespace App\Models;
use App\Core\Model;

class Imagen extends Model
{
    protected string $table = 'imagen';
    protected string $pk = 'imagen_id';

    public function listarSinImagenPrimero(): array
    {
        return $this->db->query("
        SELECT p.producto_id, p.nombre AS producto, p.activo,
        img.imagen_id, img.nombre AS img_nombre, img.ruta
        FROM inventario p
        LEFT JOIN imagen img ON img.producto_id = p.producto_id
        ORDER BY (img.imagen_id IS NOT NULL), p.nombre
        ")->fetchAll();
    }

    public function porProducto(int $productoId): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM imagen WHERE producto_id = ?");
        $stmt->execute([$productoId]);
        return $stmt->fetch() ?: null;
    }

    public function crear(int $productoId, string $nombre, string $ruta): int
    {
        $stmt = $this->db->prepare("INSERT INTO imagen (producto_id, nombre, ruta) VALUES (?, ?, ?)");
        $stmt->execute([$productoId, $nombre, $ruta]);
        return (int)$this->db->lastInsertId();
    }

    public function actualizar(int $id, string $nombre, string $ruta): void
    {
        $this->db->prepare("UPDATE imagen SET nombre = ?, ruta = ? WHERE imagen_id = ?")->execute([$nombre, $ruta, $id]);
    }
}
