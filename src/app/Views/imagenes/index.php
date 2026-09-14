<h2 class="mb-3">Imágenes de productos</h2>
<p class="text-muted small">Se muestran primero los productos <strong>sin imagen</strong>.</p>

<div class="card">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light">
        <tr><th style="width:70px">Preview</th><th>Producto</th><th>Estado</th><th class="text-end">Acciones</th></tr>
      </thead>
      <tbody>
        <?php foreach ($items as $it): ?>
        <tr class="<?= $it['imagen_id'] ? '' : 'table-warning' ?>">
          <td>
            <?php if ($it['ruta']): ?>
              <img src="/uploads/<?= htmlspecialchars($it['ruta']) ?>" style="width:50px;height:50px;object-fit:cover;border-radius:4px">
            <?php else: ?><i class="bi bi-image text-muted fs-3"></i><?php endif; ?>
          </td>
          <td>
            <?= htmlspecialchars($it['producto']) ?>
            <?php if (!$it['activo']): ?><span class="badge bg-secondary">inactivo</span><?php endif; ?>
          </td>
          <td>
            <?php if ($it['imagen_id']): ?>
              <span class="badge bg-success">Con imagen</span>
            <?php else: ?>
              <span class="badge bg-warning text-dark">Sin imagen</span>
            <?php endif; ?>
          </td>
          <td class="text-end">
            <a href="/imagenes/subir?id=<?= $it['producto_id'] ?>" class="btn btn-sm btn-outline-primary">
              <?= $it['imagen_id'] ? 'Reemplazar' : 'Subir' ?>
            </a>
            <?php if ($it['imagen_id']): ?>
            <form method="post" action="/imagenes/eliminar" class="d-inline" onsubmit="return confirm('¿Eliminar imagen?')">
              <input type="hidden" name="producto_id" value="<?= $it['producto_id'] ?>">
              <button class="btn btn-sm btn-outline-danger">Eliminar</button>
            </form>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
