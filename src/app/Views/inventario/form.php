<?php $esEdicion = (bool)$producto; ?>
<h2 class="mb-3"><?= $esEdicion ? 'Editar' : 'Nuevo' ?> producto</h2>

<form method="post" action="<?= $esEdicion ? '/inventario/editar' : '/inventario/crear' ?>" enctype="multipart/form-data" class="card p-4" style="max-width:800px">
  <?php if ($esEdicion): ?>
    <input type="hidden" name="id" value="<?= $producto['producto_id'] ?>">
  <?php endif; ?>

  <div class="row g-3">
    <div class="col-md-8">
      <label class="form-label">Nombre *</label>
      <input name="nombre" class="form-control" required value="<?= htmlspecialchars($producto['nombre'] ?? '') ?>">
    </div>
    <div class="col-md-4">
      <label class="form-label">Cantidad inicial</label>
      <input type="number" name="cantidad" class="form-control" value="<?= htmlspecialchars($producto['cantidad'] ?? 0) ?>" <?= $esEdicion?'disabled':'' ?>>
      <?php if ($esEdicion): ?><small class="text-muted">Usa entradas/salidas para mover stock.</small><?php endif; ?>
    </div>

    <div class="col-md-6">
      <label class="form-label">Categoría</label>
      <select name="categoria_id" class="form-select">
        <option value="">— Sin categoría —</option>
        <?php foreach ($categorias as $c): ?>
          <option value="<?= $c['categoria_id'] ?>" <?= ($producto['categoria_id']??'')==$c['categoria_id']?'selected':'' ?>>
            <?= htmlspecialchars($c['nombre']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-6">
      <label class="form-label">Marca</label>
      <select name="marca_id" class="form-select">
        <option value="">— Sin marca —</option>
        <?php foreach ($marcas as $m): ?>
          <option value="<?= $m['marca_id'] ?>" <?= ($producto['marca_id']??'')==$m['marca_id']?'selected':'' ?>>
            <?= htmlspecialchars($m['marca']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-6">
      <label class="form-label">Precio venta USD *</label>
      <input type="number" step="0.01" min="0" name="preciod" id="preciod" class="form-control" required
             value="<?= htmlspecialchars($producto['preciod'] ?? 0) ?>">
    </div>
    <div class="col-md-6">
      <label class="form-label">Precio venta Bs *</label>
      <input type="number" step="0.01" min="0" name="preciobs" id="preciobs" class="form-control" required
             value="<?= htmlspecialchars($producto['preciobs'] ?? 0) ?>">
      <small class="text-muted">Se puede actualizar masivamente desde Inventario.</small>
    </div>

    <div class="col-md-12">
      <label class="form-label">Foto (reemplaza la actual si existe)</label>
      <input type="file" name="foto" class="form-control" accept="image/*">
      <?php if (!empty($producto['img_ruta'])): ?>
        <div class="mt-2"><img src="/uploads/<?= htmlspecialchars($producto['img_ruta']) ?>" style="max-height:120px;border-radius:6px"></div>
      <?php endif; ?>
    </div>
  </div>

  <div class="mt-4">
    <button class="btn btn-primary">Guardar</button>
    <a href="/inventario" class="btn btn-outline-secondary">Cancelar</a>
  </div>
</form>
