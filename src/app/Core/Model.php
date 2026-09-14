<?php
namespace App\Core;

use App\Config\Database;
use PDO;

abstract class Model
{
    protected PDO $db;
    protected string $table;
    protected string $pk = 'id';

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function all(string $orderBy = null): array
    {
        $orderBy = $orderBy ?? $this->pk;
        return $this->db->query("SELECT * FROM {$this->table} ORDER BY {$orderBy}")->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$this->pk} = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function delete(int $id): bool
    {
        return $this->db->prepare("DELETE FROM {$this->table} WHERE {$this->pk} = ?")->execute([$id]);
    }
}
