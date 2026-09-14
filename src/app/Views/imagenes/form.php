<h2 class="mb-3"><?= !empty($producto['img_ruta']) ? 'Reemplazar' : 'Subir' ?> imagen</h2>
<p>Producto: <strong><?= htmlspecialchars($producto['nombre'] ?? '') ?></strong></p>

<form method="post" action="/imagenes/subir" enctype="multipart/form-data" class="card p-4" style="max-width:600px">
  <input type="hidden" name="producto_id" value="<?= $producto['producto_id'] ?>">
  <?php if (!empty($producto['img_ruta'])): ?>
    <div class="mb-3"><img src="/uploads/<?= htmlspecialchars($producto['img_ruta']) ?>" style="max-height:180px;border-radius:6px"></div>
  <?php endif; ?>
  <div class="mb-3">
    <label class="form-label">Archivo de imagen *</label>
    <input type="file" name="foto" class="form-control" accept="image/*" required>
  </div>
  <div>
    <button class="btn btn-primary">Guardar</button>
    <a href="/imagenes" class="btn btn-outline-secondary">Cancelar</a>
  </div>
</form>
