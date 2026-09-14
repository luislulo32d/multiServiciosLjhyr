<?php
use App\Helpers\TasaCheck;
$config = $config ?? require __DIR__ . '/../../Config/config.php';
$path = $currentPath ?? '/';
$esTasas = str_starts_with($path, '/tasas');
$hayTasaHoy = $esTasas ? true : TasaCheck::hayTasaHoy();
$tasaActual = TasaCheck::ultimaTasa();
$flashes = $_SESSION['flash'] ?? [];
unset($_SESSION['flash']);
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title><?= htmlspecialchars($config['app_name']) ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<style>
  body { background:#f4f6f9; }
  .sidebar { min-height:100vh; background:#1f2937; }
  .sidebar a { color:#cbd5e1; text-decoration:none; display:block; padding:.65rem 1rem; border-radius:.375rem; }
  .sidebar a:hover, .sidebar a.active { background:#374151; color:#fff; }
  .brand { color:#fff; font-weight:600; padding:1rem; border-bottom:1px solid #374151; }
  .content { padding:1.5rem 2rem; }
  .card { box-shadow:0 1px 3px rgba(0,0,0,.08); border:none; }
</style>
</head>
<body>
<div class="d-flex">
  <aside class="sidebar" style="width:230px;">
    <div class="brand"><i class="bi bi-tools"></i> <?= htmlspecialchars($config['app_name']) ?></div>
    <nav class="p-2">
      <a href="/dashboard"  class="<?= $path==='/dashboard'||$path==='/'?'active':'' ?>"><i class="bi bi-speedometer2"></i> Dashboard</a>
      <a href="/inventario" class="<?= str_starts_with($path,'/inventario')?'active':'' ?>"><i class="bi bi-box-seam"></i> Inventario</a>
      <a href="/entradas"   class="<?= str_starts_with($path,'/entradas')?'active':'' ?>"><i class="bi bi-box-arrow-in-down"></i> Entradas</a>
      <a href="/salidas"    class="<?= str_starts_with($path,'/salidas')?'active':'' ?>"><i class="bi bi-box-arrow-up"></i> Salidas</a>
      <a href="/imagenes"   class="<?= str_starts_with($path,'/imagenes')?'active':'' ?>"><i class="bi bi-images"></i> Imágenes</a>
      <a href="/categorias" class="<?= str_starts_with($path,'/categorias')?'active':'' ?>"><i class="bi bi-tag"></i> Categorías</a>
      <a href="/marcas"     class="<?= str_starts_with($path,'/marcas')?'active':'' ?>"><i class="bi bi-bookmark"></i> Marcas</a>
      <a href="/tasas"      class="<?= str_starts_with($path,'/tasas')?'active':'' ?>"><i class="bi bi-currency-dollar"></i> Tasas</a>
    </nav>
  </aside>

  <main class="flex-fill">
    <div class="bg-white border-bottom px-4 py-2 d-flex justify-content-between align-items-center">
      <span class="text-muted small">Sistema de gestión</span>
      <span class="small">
        <?php if ($tasaActual): ?>
          Tasa vigente: <strong><?= number_format($tasaActual['oficial'], 2, ',', '.') ?> Bs/USD</strong>
          <span class="text-muted">(<?= $tasaActual['fecha'] ?>)</span>
        <?php else: ?>
          <span class="text-danger">Sin tasas registradas</span>
        <?php endif; ?>
      </span>
    </div>

    <?php if (!$hayTasaHoy): ?>
      <div class="alert alert-danger rounded-0 mb-0 d-flex justify-content-between align-items-center">
        <span><i class="bi bi-exclamation-triangle-fill"></i> No hay tasa BCV registrada para hoy. Regístrala antes de operar.</span>
        <a href="/tasas/crear" class="btn btn-sm btn-light">Registrar tasa</a>
      </div>
    <?php endif; ?>

    <?php foreach ($flashes as $f): ?>
      <div class="alert alert-<?= $f['tipo']==='error'?'danger':'success' ?> rounded-0 mb-0">
        <?= htmlspecialchars($f['mensaje']) ?>
      </div>
    <?php endforeach; ?>

    <div class="content">
