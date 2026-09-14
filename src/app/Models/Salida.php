<?php
namespace App\Models;
use App\Core\Model;

class Salida extends Model
{
    protected string $table = 'salidainventario';
    protected string $pk = 'salida_id';

    public function listar(): array
    {
        return $this->db->query("
        SELECT s.*, p.nombre AS producto, img.ruta AS img_ruta
        FROM salidainventario s
        JOIN inventario p ON p.producto_id = s.producto_id
        LEFT JOIN imagen img ON img.imagen_id = p.foto_id
        ORDER BY s.fecha DESC
        ")->fetchAll();
    }

    public function crear(array $d): int
    {
        $stmt = $this->db->prepare("
        INSERT INTO salidainventario
        (producto_id, foto_id, tipo, motivo_ajuste, cantidad,
                                   fechaventa, precio, preciod, compra, comprad, tasa, fecha)
        VALUES (:p, :f, :t, :mo, :c, NOW(), :pr, :prd, :co, :cod, :ta, NOW())
        ");
        $stmt->execute([
            ':p'  => $d['producto_id'],
            ':f'  => $d['foto_id'] ?? null,
            ':t'  => $d['tipo'],
            ':mo' => $d['motivo_ajuste'] ?? null,
            ':c'  => $d['cantidad'],
            ':pr' => $d['precio'] ?? 0,
            ':prd'=> $d['preciod'] ?? 0,
            ':co' => $d['compra'] ?? 0,
            ':cod'=> $d['comprad'] ?? 0,
            ':ta' => $d['tasa'] ?? 0,
        ]);
        return (int)$this->db->lastInsertId();
    }
}
