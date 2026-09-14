<?php
namespace App\Models;
use App\Core\Model;

class Entrada extends Model
{
    protected string $table = 'entradainventario';
    protected string $pk = 'entrada_id';

    public function listar(): array
    {
        return $this->db->query("
        SELECT e.*, p.nombre AS producto, p.foto_id,
        img.ruta AS img_ruta
        FROM entradainventario e
        JOIN inventario p ON p.producto_id = e.producto_id
        LEFT JOIN imagen img ON img.imagen_id = p.foto_id
        ORDER BY e.fecha DESC
        ")->fetchAll();
    }

    public function crear(array $d): int
    {
        $stmt = $this->db->prepare("
        INSERT INTO entradainventario
        (producto_id, foto_id, cantidad, costo, precio, costod, preciod, tipo, motivo_ajuste, tasa_id, fecha)
        VALUES (:p, :f, :c, :co, :pr, :cod, :prd, :t, :mo, :ta, NOW())
        ");
        $stmt->execute([
            ':p'  => $d['producto_id'],
            ':f'  => $d['foto_id'] ?? null,
            ':c'  => $d['cantidad'],
            ':co' => $d['costo'] ?? 0,
            ':pr' => $d['precio'] ?? 0,
            ':cod'=> $d['costod'] ?? 0,
            ':prd'=> $d['preciod'] ?? 0,
            ':t'  => $d['tipo'],
            ':mo' => $d['motivo_ajuste'] ?? null,
            ':ta' => $d['tasa_id'] ?? null,
        ]);
        return (int)$this->db->lastInsertId();
    }
}
