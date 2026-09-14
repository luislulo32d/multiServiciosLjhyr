<div class="d-flex justify-content-between mb-3">
  <h2>Inventario</h2>
  <div>
    <a href="/inventario?inactivos=<?= $verInactivos?'0':'1' ?>" class="btn btn-outline-secondary btn-sm">
      <?= $verInactivos ? 'Ver activos' : 'Ver inactivos' ?>
    </a>
    <form method="post" action="/inventario/actualizar-precios" class="d-inline"
          onsubmit="return confirm('¿Actualizar precios Bs de todos los productos activos según la tasa de hoy?')">
      <button class="btn btn-outline-primary btn-sm">Actualizar precios Bs</button>
    </form>
    <a href="/inventario/crear" class="btn btn-primary btn-sm">+ Nuevo producto</a>
  </div>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th></th><th>Producto</th><th>Categoría</th><th>Marca</th>
          <th class="text-end">USD</th><th class="text-end">Bs</th>
          <th class="text-center">Stock</th><th>Últ. venta</th><th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($productos as $p): ?>
        <tr class="<?= $p['activo'] ? '' : 'table-secondary opacity-75' ?>">
          <td style="width:50px">
            <?php if ($p['img_ruta']): ?>
              <img src="/uploads/<?= htmlspecialchars($p['img_ruta']) ?>" style="width:40px;height:40px;object-fit:cover;border-radius:4px">
            <?php else: ?>
              <div class="text-muted small text-center">—</div>
            <?php endif; ?>
          </td>
          <td><?= htmlspecialchars($p['nombre']) ?></td>
          <td><span class="badge bg-light text-dark"><?= htmlspecialchars($p['categoria'] ?? '—') ?></span></td>
          <td><?= htmlspecialchars($p['marca'] ?? '—') ?></td>
          <td class="text-end">$<?= number_format($p['preciod'],2,',','.') ?></td>
          <td class="text-end"><?= number_format($p['preciobs'],2,',','.') ?></td>
          <td class="text-center"><span class="badge bg-<?= $p['cantidad']<=0?'danger':($p['cantidad']<=2?'warning text-dark':'success') ?>"><?= $p['cantidad'] ?></span></td>
          <td class="small text-muted"><?= $p['ultimaventa'] ?? '—' ?></td>
          <td class="text-end">
            <a href="/inventario/editar?id=<?= $p['producto_id'] ?>" class="btn btn-sm btn-outline-secondary">Editar</a>
            <form method="post" action="/inventario/toggle" class="d-inline">
              <input type="hidden" name="id" value="<?= $p['producto_id'] ?>">
              <input type="hidden" name="volver" value="<?= $verInactivos?'1':'0' ?>">
              <button class="btn btn-sm btn-outline-<?= $p['activo']?'warning':'success' ?>">
                <?= $p['activo'] ? 'Desactivar' : 'Activar' ?>
              </button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if (!$productos): ?>
          <tr><td colspan="9" class="text-center text-muted py-4">Sin productos. Crea el primero.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
