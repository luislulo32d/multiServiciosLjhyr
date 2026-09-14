<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\{Producto, Categoria, Marca, Imagen};
use App\Helpers\{TasaCheck, Upload, Money};

class InventarioController extends Controller
{
    public function index(): void
    {
        $prod = new Producto();
        $verInactivos = ($_GET['inactivos'] ?? '') === '1';
        $lista = $prod->listar(!$verInactivos);
        $this->view('inventario/index', [
            'productos'    => $lista,
            'verInactivos' => $verInactivos,
        ]);
    }

    public function crear(): void
    {
        $this->view('inventario/form', [
            'producto'    => null,
            'categorias'  => (new Categoria())->all('nombre'),
                    'marcas'      => (new Marca())->all('marca'),
        ]);
    }

    public function guardar(): void
    {
        $prod = new Producto();
        $id = $prod->crear($_POST);
        if (!empty($_FILES['foto']['name'])) {
            $up = Upload::guardar($_FILES['foto'], $id);
            if ($up) {
                $img = new Imagen();
                $imgId = $img->crear($id, $up['nombre'], $up['ruta']);
                $prod->setFoto($id, $imgId);
            }
        }
        $this->flash('ok', 'Producto creado');
        $this->redirect('/inventario');
    }

    public function editar(): void
    {
        $id = (int)$this->input('id');
        $prod = new Producto();
        $this->view('inventario/form', [
            'producto'   => $prod->conRelaciones($id),
                    'categorias' => (new Categoria())->all('nombre'),
                    'marcas'     => (new Marca())->all('marca'),
        ]);
    }

    public function actualizar(): void
    {
        $id = (int)$this->input('id');
        $prod = new Producto();
        $prod->actualizar($id, $_POST);

        if (!empty($_FILES['foto']['name'])) {
            $img = new Imagen();
            $actual = $img->porProducto($id);
            if ($actual) Upload::eliminar($actual['ruta']);

            $up = Upload::guardar($_FILES['foto'], $id);
            if ($up) {
                if ($actual) {
                    $img->actualizar((int)$actual['imagen_id'], $up['nombre'], $up['ruta']);
                } else {
                    $imgId = $img->crear($id, $up['nombre'], $up['ruta']);
                    $prod->setFoto($id, $imgId);
                }
            }
        }
        $this->flash('ok', 'Producto actualizado');
        $this->redirect('/inventario');
    }

    public function toggle(): void
    {
        (new Producto())->toggleActivo((int)$this->input('id'));
        $this->flash('ok', 'Estado actualizado');
        $this->redirect('/inventario?inactivos=' . ($this->input('volver') ?? '0'));
    }

    public function actualizarPrecios(): void
    {
        $tasa = TasaCheck::tasaHoy();
        if (!$tasa) {
            $this->flash('error', 'No hay tasa de hoy. Registra la tasa primero.');
            $this->redirect('/inventario');
        }
        $n = (new Producto())->actualizarPreciosMasivo((float)$tasa['oficial']);
        $this->flash('ok', "Precios en Bs actualizados para {$n} productos.");
        $this->redirect('/inventario');
    }
}
