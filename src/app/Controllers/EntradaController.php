<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\{Entrada, Producto};
use App\Helpers\{TasaCheck, Money};

class EntradaController extends Controller
{
    public function index(): void
    {
        $this->view('entradas/index', ['entradas' => (new Entrada())->listar()]);
    }

    public function crear(): void
    {
        $tasa = TasaCheck::tasaHoy();
        if (!$tasa) {
            $this->flash('error', 'Registra la tasa de hoy antes de cargar entradas.');
            $this->redirect('/tasas/crear');
        }
        $this->view('entradas/form', [
            'productos' => (new Producto())->listar(),
                    'tasa'      => $tasa,
        ]);
    }

    public function guardar(): void
    {
        $tasa = TasaCheck::tasaHoy();
        if (!$tasa) {
            $this->flash('error', 'No hay tasa de hoy');
            $this->redirect('/entradas');
        }

        $prod = new Producto();
        $productoId = (int)$_POST['producto_id'];
        $producto   = $prod->find($productoId);
        $oficial    = (float)$tasa['oficial'];

        $cantidad = (int)$_POST['cantidad'];
        $costod   = (float)($_POST['costod'] ?? 0);
        $preciod  = (float)($_POST['preciod'] ?? 0);
        $tipo     = $_POST['tipo'] === 'ajuste' ? 'ajuste' : 'compra';

        $data = [
            'producto_id'   => $productoId,
            'foto_id'       => $producto['foto_id'] ?? null,
            'cantidad'      => $cantidad,
            'costod'        => $costod,
            'preciod'       => $preciod,
            'costo'         => Money::bsDesdeUsd($costod, $oficial),
            'precio'        => Money::bsDesdeUsd($preciod, $oficial),
            'tipo'          => $tipo,
            'motivo_ajuste' => $tipo === 'ajuste' ? ($_POST['motivo_ajuste'] ?? null) : null,
            'tasa_id'       => (int)$tasa['tasa_id'],
        ];

        (new Entrada())->crear($data);
        $prod->ajustarStock($productoId, $cantidad);
        if ($tipo === 'compra') $prod->setUltimaCompra($productoId, date('Y-m-d'));

        $this->flash('ok', 'Entrada registrada');
        $this->redirect('/entradas');
    }
}
