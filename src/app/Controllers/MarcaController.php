<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Marca;

class MarcaController extends Controller
{
    public function index(): void
    {
        $this->view('marcas/index', ['items' => (new Marca())->all('marca')]);
    }

    public function crear(): void { $this->view('marcas/form', ['item' => null]); }

    public function guardar(): void
    {
        (new Marca())->crear(trim($this->input('marca')));
        $this->flash('ok', 'Marca creada');
        $this->redirect('/marcas');
    }

    public function editar(): void
    {
        $this->view('marcas/form', ['item' => (new Marca())->find((int)$this->input('id'))]);
    }

    public function actualizar(): void
    {
        (new Marca())->actualizar((int)$this->input('id'), trim($this->input('marca')));
        $this->flash('ok', 'Marca actualizada');
        $this->redirect('/marcas');
    }

    public function eliminar(): void
    {
        (new Marca())->delete((int)$this->input('id'));
        $this->flash('ok', 'Marca eliminada');
        $this->redirect('/marcas');
    }
}
