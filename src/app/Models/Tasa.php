<?php
namespace App\Models;
use App\Core\Model;

class Tasa extends Model
{
    protected string $table = 'tasa';
    protected string $pk = 'tasa_id';

    public function todas(): array
    {
        return $this->db->query("SELECT * FROM tasa ORDER BY fecha DESC")->fetchAll();
    }

    public function crear(string $fecha, float $oficial): int
    {
        $stmt = $this->db->prepare("INSERT INTO tasa (fecha, oficial) VALUES (?, ?)");
        $stmt->execute([$fecha, $oficial]);
        return (int)$this->db->lastInsertId();
    }

    public function actualizar(int $id, string $fecha, float $oficial): void
    {
        $this->db->prepare("UPDATE tasa SET fecha = ?, oficial = ? WHERE tasa_id = ?")->execute([$fecha, $oficial, $id]);
    }
}
