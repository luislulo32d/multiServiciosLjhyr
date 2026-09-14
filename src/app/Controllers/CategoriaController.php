<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function index(): void
    {
        $this->view('categorias/index', ['items' => (new Categoria())->all('nombre')]);
    }

    public function crear(): void { $this->view('categorias/form', ['item' => null]); }

    public function guardar(): void
    {
        (new Categoria())->crear(trim($this->input('nombre')));
        $this->flash('ok', 'Categoría creada');
        $this->redirect('/categorias');
    }

    public function editar(): void
    {
        $this->view('categorias/form', ['item' => (new Categoria())->find((int)$this->input('id'))]);
    }

    public function actualizar(): void
    {
        (new Categoria())->actualizar((int)$this->input('id'), trim($this->input('nombre')));
        $this->flash('ok', 'Categoría actualizada');
        $this->redirect('/categorias');
    }

    public function eliminar(): void
    {
        (new Categoria())->delete((int)$this->input('id'));
        $this->flash('ok', 'Categoría eliminada');
        $this->redirect('/categorias');
    }
}
