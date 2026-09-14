<?php
namespace App\Models;
use App\Core\Model;

class Marca extends Model
{
    protected string $table = 'marca';
    protected string $pk = 'marca_id';

    public function crear(string $nombre): int
    {
        $this->db->prepare("INSERT INTO marca (marca) VALUES (?)")->execute([$nombre]);
        return (int)$this->db->lastInsertId();
    }

    public function actualizar(int $id, string $nombre): void
    {
        $this->db->prepare("UPDATE marca SET marca = ? WHERE marca_id = ?")->execute([$nombre, $id]);
    }
}
