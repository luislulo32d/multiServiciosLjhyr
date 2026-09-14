<?php
namespace App\Models;
use App\Core\Model;

class Producto extends Model
{
    protected string $table = 'inventario';
    protected string $pk = 'producto_id';

    public function listar(bool $soloActivos = true): array
    {
        $where = $soloActivos ? 'WHERE i.activo = 1' : '';
        return $this->db->query("
        SELECT i.*, c.nombre AS categoria, m.marca, img.ruta AS img_ruta
        FROM inventario i
        LEFT JOIN categoria c ON c.categoria_id = i.categoria_id
        LEFT JOIN marca m ON m.marca_id = i.marca_id
        LEFT JOIN imagen img ON img.imagen_id = i.foto_id
        {$where}
        ORDER BY i.nombre
        ")->fetchAll();
    }

    public function conRelaciones(int $id): ?array
    {
        $stmt = $this->db->prepare("
        SELECT i.*, c.nombre AS categoria, m.marca, img.ruta AS img_ruta
        FROM inventario i
        LEFT JOIN categoria c ON c.categoria_id = i.categoria_id
        LEFT JOIN marca m ON m.marca_id = i.marca_id
        LEFT JOIN imagen img ON img.imagen_id = i.foto_id
        WHERE i.producto_id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function crear(array $d): int
    {
        $stmt = $this->db->prepare("
        INSERT INTO inventario (nombre, categoria_id, marca_id, preciod, preciobs, cantidad)
        VALUES (:n, :c, :m, :pd, :pb, :ca)
        ");
        $stmt->execute([
            ':n'  => $d['nombre'],
            ':c'  => $d['categoria_id'] ?: null,
            ':m'  => $d['marca_id'] ?: null,
            ':pd' => $d['preciod'] ?? 0,
            ':pb' => $d['preciobs'] ?? 0,
            ':ca' => $d['cantidad'] ?? 0,
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function actualizar(int $id, array $d): void
    {
        $stmt = $this->db->prepare("
        UPDATE inventario SET
        nombre=:n, categoria_id=:c, marca_id=:m,
        preciod=:pd, preciobs=:pb
        WHERE producto_id=:id
        ");
        $stmt->execute([
            ':n'  => $d['nombre'],
            ':c'  => $d['categoria_id'] ?: null,
            ':m'  => $d['marca_id'] ?: null,
            ':pd' => $d['preciod'] ?? 0,
            ':pb' => $d['preciobs'] ?? 0,
            ':id' => $id,
        ]);
    }

    public function toggleActivo(int $id): void
    {
        $this->db->prepare("UPDATE inventario SET activo = 1 - activo WHERE producto_id = ?")->execute([$id]);
    }

    public function actualizarPreciosMasivo(float $tasa): int
    {
        $stmt = $this->db->prepare("UPDATE inventario SET preciobs = ROUND(preciod * ?, 2) WHERE activo = 1");
        $stmt->execute([$tasa]);
        return $stmt->rowCount();
    }

    public function ajustarStock(int $id, int $delta): void
    {
        $this->db->prepare("UPDATE inventario SET cantidad = cantidad + ? WHERE producto_id = ?")->execute([$delta, $id]);
    }

    public function setFoto(int $id, ?int $fotoId): void
    {
        $this->db->prepare("UPDATE inventario SET foto_id = ? WHERE producto_id = ?")->execute([$fotoId, $id]);
    }

    public function setUltimaCompra(int $id, string $fecha): void
    {
        $this->db->prepare("UPDATE inventario SET ultimacompra = ? WHERE producto_id = ?")->execute([$fecha, $id]);
    }

    public function setUltimaVenta(int $id, string $fecha): void
    {
        $this->db->prepare("UPDATE inventario SET ultimaventa = ? WHERE producto_id = ?")->execute([$fecha, $id]);
    }
}
