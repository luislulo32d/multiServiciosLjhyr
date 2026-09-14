<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\{Imagen, Producto};
use App\Helpers\Upload;

class ImagenController extends Controller
{
    public function index(): void
    {
        $this->view('imagenes/index', ['items' => (new Imagen())->listarSinImagenPrimero()]);
    }

    public function subir(): void
    {
        $id = (int)($this->input('id') ?? 0);
        $this->view('imagenes/form', [
            'producto' => (new Producto())->conRelaciones($id),
        ]);
    }

    public function guardar(): void
    {
        $productoId = (int)$this->input('producto_id');
        $prod = new Producto();
        $img  = new Imagen();
        $actual = $img->porProducto($productoId);

        if (!empty($_FILES['foto']['name'])) {
            $up = Upload::guardar($_FILES['foto'], $productoId);
            if ($up) {
                if ($actual) {
                    Upload::eliminar($actual['ruta']);
                    $img->actualizar((int)$actual['imagen_id'], $up['nombre'], $up['ruta']);
                } else {
                    $imgId = $img->crear($productoId, $up['nombre'], $up['ruta']);
                    $prod->setFoto($productoId, $imgId);
                }
                $this->flash('ok', 'Imagen guardada');
            } else {
                $this->flash('error', 'No se pudo guardar la imagen (formato no permitido)');
            }
        }
        $this->redirect('/imagenes');
    }

    public function eliminar(): void
    {
        $productoId = (int)$this->input('producto_id');
        $img = new Imagen();
        $actual = $img->porProducto($productoId);
        if ($actual) {
            Upload::eliminar($actual['ruta']);
            $img->delete((int)$actual['imagen_id']);
            (new Producto())->setFoto($productoId, null);
            $this->flash('ok', 'Imagen eliminada');
        }
        $this->redirect('/imagenes');
    }
}
