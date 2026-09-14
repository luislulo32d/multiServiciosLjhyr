<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Config\Database;
use App\Helpers\TasaCheck;

class DashboardController extends Controller
{
    public function index(): void
    {
        $db = Database::getConnection();
        $stats = [
            'total'      => (int)$db->query("SELECT COUNT(*) FROM inventario WHERE activo = 1")->fetchColumn(),
            'inactivos'  => (int)$db->query("SELECT COUNT(*) FROM inventario WHERE activo = 0")->fetchColumn(),
            'sin_stock'  => (int)$db->query("SELECT COUNT(*) FROM inventario WHERE activo=1 AND cantidad<=0")->fetchColumn(),
            'sin_foto'   => (int)$db->query("SELECT COUNT(*) FROM inventario WHERE activo=1 AND foto_id IS NULL")->fetchColumn(),
            'valor_usd'  => (float)$db->query("SELECT COALESCE(SUM(preciod*cantidad),0) FROM inventario WHERE activo=1")->fetchColumn(),
        ];
        $ultimasVentas = $db->query("
        SELECT s.*, p.nombre AS producto
        FROM salidainventario s
        JOIN inventario p ON p.producto_id = s.producto_id
        WHERE s.tipo='venta'
        ORDER BY s.fecha DESC LIMIT 8
        ")->fetchAll();
        $bajoStock = $db->query("
        SELECT producto_id, nombre, cantidad
        FROM inventario WHERE activo=1 AND cantidad <= 2
        ORDER BY cantidad ASC LIMIT 8
        ")->fetchAll();

        $this->view('dashboard/index', [
            'stats'         => $stats,
            'ultimasVentas' => $ultimasVentas,
            'bajoStock'     => $bajoStock,
            'tasaHoy'       => TasaCheck::tasaHoy(),
        ]);
    }
}
