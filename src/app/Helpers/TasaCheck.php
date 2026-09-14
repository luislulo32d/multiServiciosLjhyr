<?php
namespace App\Helpers;

use App\Config\Database;

class TasaCheck
{
    public static function hayTasaHoy(): bool
    {
        $db = Database::getConnection();
        return (bool) $db->query("SELECT 1 FROM tasa WHERE fecha = CURDATE() LIMIT 1")->fetchColumn();
    }

    public static function tasaHoy(): ?array
    {
        $db = Database::getConnection();
        $r = $db->query("SELECT * FROM tasa WHERE fecha = CURDATE() LIMIT 1")->fetch();
        return $r ?: null;
    }

    public static function ultimaTasa(): ?array
    {
        $db = Database::getConnection();
        $r = $db->query("SELECT * FROM tasa ORDER BY fecha DESC LIMIT 1")->fetch();
        return $r ?: null;
    }
}
