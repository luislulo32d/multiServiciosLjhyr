<h2 class="mb-4">Dashboard</h2>

<div class="row g-3 mb-4">
  <div class="col-md-3"><div class="card p-3"><div class="text-muted small">Productos activos</div><div class="fs-3"><?= $stats['total'] ?></div></div></div>
  <div class="col-md-3"><div class="card p-3"><div class="text-muted small">Sin stock</div><div class="fs-3 text-warning"><?= $stats['sin_stock'] ?></div></div></div>
  <div class="col-md-3"><div class="card p-3"><div class="text-muted small">Sin foto</div><div class="fs-3 text-info"><?= $stats['sin_foto'] ?></div></div></div>
  <div class="col-md-3"><div class="card p-3"><div class="text-muted small">Valor inventario (USD)</div><div class="fs-3">$<?= number_format($stats['valor_usd'],2,',','.') ?></div></div></div>
</div>

<div class="row g-3">
  <div class="col-md-7">
    <div class="card p-3">
      <h5>Últimas ventas</h5>
      <?php if (!$ultimasVentas): ?><p class="text-muted small">Sin registros aún.</p><?php else: ?>
      <table class="table table-sm mb-0">
        <thead><tr><th>Fecha</th><th>Producto</th><th>Cant.</th><th>Total Bs</th></tr></thead>
        <tbody>
          <?php foreach ($ultimasVentas as $v): ?>
            <tr>
              <td><?= date('d/m H:i', strtotime($v['fecha'])) ?></td>
              <td><?= htmlspecialchars($v['producto']) ?></td>
              <td><?= $v['cantidad'] ?></td>
              <td><?= number_format($v['precio']*$v['cantidad'],2,',','.') ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <?php endif; ?>
    </div>
  </div>
  <div class="col-md-5">
    <div class="card p-3">
      <h5>Bajo stock (≤ 2)</h5>
      <?php if (!$bajoStock): ?><p class="text-muted small">Todo bien 👌</p><?php else: ?>
      <ul class="list-group list-group-flush">
        <?php foreach ($bajoStock as $b): ?>
          <li class="list-group-item d-flex justify-content-between">
            <span><?= htmlspecialchars($b['nombre']) ?></span>
            <span class="badge bg-warning text-dark"><?= $b['cantidad'] ?></span>
          </li>
        <?php endforeach; ?>
      </ul>
      <?php endif; ?>
    </div>
  </div>
</div>
