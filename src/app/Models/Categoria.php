<?php
namespace App\Models;
use App\Core\Model;

class Categoria extends Model
{
    protected string $table = 'categoria';
    protected string $pk = 'categoria_id';

    public function crear(string $nombre): int
    {
        $this->db->prepare("INSERT INTO categoria (nombre) VALUES (?)")->execute([$nombre]);
        return (int)$this->db->lastInsertId();
    }

    public function actualizar(int $id, string $nombre): void
    {
        $this->db->prepare("UPDATE categoria SET nombre = ? WHERE categoria_id = ?")->execute([$nombre, $id]);
    }
}
