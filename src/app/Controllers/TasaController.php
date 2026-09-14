<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Tasa;

class TasaController extends Controller
{
    public function index(): void
    {
        $this->view('tasas/index', ['items' => (new Tasa())->todas()]);
    }

    public function crear(): void { $this->view('tasas/form', ['item' => null]); }

    public function guardar(): void
    {
        try {
            (new Tasa())->crear($this->input('fecha'), (float)$this->input('oficial'));
            $this->flash('ok', 'Tasa registrada');
        } catch (\Throwable $e) {
            $this->flash('error', 'Ya existe una tasa para esa fecha');
        }
        $this->redirect('/tasas');
    }

    public function editar(): void
    {
        $this->view('tasas/form', ['item' => (new Tasa())->find((int)$this->input('id'))]);
    }

    public function actualizar(): void
    {
        try {
            (new Tasa())->actualizar((int)$this->input('id'), $this->input('fecha'), (float)$this->input('oficial'));
            $this->flash('ok', 'Tasa actualizada');
        } catch (\Throwable $e) {
            $this->flash('error', 'Error al actualizar tasa');
        }
        $this->redirect('/tasas');
    }

    public function eliminar(): void
    {
        (new Tasa())->delete((int)$this->input('id'));
        $this->flash('ok', 'Tasa eliminada');
        $this->redirect('/tasas');
    }
}
