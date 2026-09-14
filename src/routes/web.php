<?php
use App\Core\Router;
use App\Controllers\{
    DashboardController, InventarioController, EntradaController,
    SalidaController, ImagenController, CategoriaController,
    MarcaController, TasaController
};

$r = new Router();

$r->get('/',               [DashboardController::class, 'index']);
$r->get('/dashboard',      [DashboardController::class, 'index']);

$r->get('/inventario',                  [InventarioController::class, 'index']);
$r->get('/inventario/crear',            [InventarioController::class, 'crear']);
$r->post('/inventario/crear',           [InventarioController::class, 'guardar']);
$r->get('/inventario/editar',           [InventarioController::class, 'editar']);
$r->post('/inventario/editar',          [InventarioController::class, 'actualizar']);
$r->post('/inventario/toggle',          [InventarioController::class, 'toggle']);
$r->post('/inventario/actualizar-precios', [InventarioController::class, 'actualizarPrecios']);

$r->get('/entradas',        [EntradaController::class, 'index']);
$r->get('/entradas/crear',  [EntradaController::class, 'crear']);
$r->post('/entradas/crear', [EntradaController::class, 'guardar']);

$r->get('/salidas',         [SalidaController::class, 'index']);
$r->get('/salidas/crear',   [SalidaController::class, 'crear']);
$r->post('/salidas/crear',  [SalidaController::class, 'guardar']);

$r->get('/imagenes',          [ImagenController::class, 'index']);
$r->get('/imagenes/subir',    [ImagenController::class, 'subir']);
$r->post('/imagenes/subir',   [ImagenController::class, 'guardar']);
$r->post('/imagenes/eliminar',[ImagenController::class, 'eliminar']);

$r->get('/categorias',          [CategoriaController::class, 'index']);
$r->get('/categorias/crear',    [CategoriaController::class, 'crear']);
$r->post('/categorias/crear',   [CategoriaController::class, 'guardar']);
$r->get('/categorias/editar',   [CategoriaController::class, 'editar']);
$r->post('/categorias/editar',  [CategoriaController::class, 'actualizar']);
$r->post('/categorias/eliminar',[CategoriaController::class, 'eliminar']);

$r->get('/marcas',          [MarcaController::class, 'index']);
$r->get('/marcas/crear',    [MarcaController::class, 'crear']);
$r->post('/marcas/crear',   [MarcaController::class, 'guardar']);
$r->get('/marcas/editar',   [MarcaController::class, 'editar']);
$r->post('/marcas/editar',  [MarcaController::class, 'actualizar']);
$r->post('/marcas/eliminar',[MarcaController::class, 'eliminar']);

$r->get('/tasas',           [TasaController::class, 'index']);
$r->get('/tasas/crear',     [TasaController::class, 'crear']);
$r->post('/tasas/crear',    [TasaController::class, 'guardar']);
$r->get('/tasas/editar',    [TasaController::class, 'editar']);
$r->post('/tasas/editar',   [TasaController::class, 'actualizar']);
$r->post('/tasas/eliminar', [TasaController::class, 'eliminar']);

return $r;
