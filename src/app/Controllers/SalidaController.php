<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\{Salida, Producto};
use App\Helpers\{TasaCheck, Money};

class SalidaController extends Controller
{
    public function index(): void
    {
        $this->view('salidas/index', ['salidas' => (new Salida())->listar()]);
    }

    public function crear(): void
    {
        $tasa = TasaCheck::tasaHoy();
        if (!$tasa) {
            $this->flash('error', 'Registra la tasa de hoy antes de cargar salidas.');
            $this->redirect('/tasas/crear');
        }
        $this->view('salidas/form', [
            'productos' => (new Producto())->listar(),
                    'tasa'      => $tasa,
        ]);
    }

    public function guardar(): void
    {
        $tasa = TasaCheck::tasaHoy();
        if (!$tasa) {
            $this->flash('error', 'No hay tasa de hoy');
            $this->redirect('/salidas');
        }

        $prod = new Producto();
        $productoId = (int)$_POST['producto_id'];
        $producto   = $prod->find($productoId);
        $oficial    = (float)$tasa['oficial'];
        $cantidad   = (int)$_POST['cantidad'];
        $tipo       = $_POST['tipo'] === 'ajuste' ? 'ajuste' : 'venta';

        if ($cantidad > (int)$producto['cantidad']) {
            $this->flash('error', 'Stock insuficiente. Disponible: ' . $producto['cantidad']);
            $this->redirect('/salidas/crear');
        }

        $preciod = $tipo === 'venta'
        ? (float)($_POST['preciod'] ?? $producto['preciod'])
        : (float)$producto['preciod'];
        $comprad = (float)$producto['preciod'];

        $data = [
            'producto_id'   => $productoId,
            'foto_id'       => $producto['foto_id'] ?? null,
            'cantidad'      => $cantidad,
            'tipo'          => $tipo,
            'motivo_ajuste' => $tipo === 'ajuste' ? ($_POST['motivo_ajuste'] ?? null) : null,
            'preciod'       => $preciod,
            'precio'        => Money::bsDesdeUsd($preciod, $oficial),
            'comprad'       => $comprad,
            'compra'        => Money::bsDesdeUsd($comprad, $oficial),
            'tasa'          => $oficial,
        ];

        (new Salida())->crear($data);
        $prod->ajustarStock($productoId, -$cantidad);
        if ($tipo === 'venta') $prod->setUltimaVenta($productoId, date('Y-m-d'));

        $this->flash('ok', 'Salida registrada');
        $this->redirect('/salidas');
    }
}
