<div class="d-flex justify-content-between mb-3">
  <h2>Entradas de inventario</h2>
  <a href="/entradas/crear" class="btn btn-primary btn-sm">+ Nueva entrada</a>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light">
        <tr><th>Fecha</th><th>Producto</th><th>Tipo</th><th>Motivo</th>
            <th class="text-center">Cant.</th><th class="text-end">Costo USD</th>
            <th class="text-end">Precio USD</th><th class="text-end">Precio Bs</th></tr>
      </thead>
      <tbody>
        <?php foreach ($entradas as $e): ?>
        <tr>
          <td class="small"><?= date('d/m/Y H:i', strtotime($e['fecha'])) ?></td>
          <td><?= htmlspecialchars($e['producto']) ?></td>
          <td><span class="badge bg-<?= $e['tipo']==='compra'?'primary':'info' ?>"><?= $e['tipo'] ?></span></td>
          <td class="small text-muted"><?= htmlspecialchars($e['motivo_ajuste'] ?? '—') ?></td>
          <td class="text-center">+<?= $e['cantidad'] ?></td>
          <td class="text-end">$<?= number_format($e['costod'],2,',','.') ?></td>
          <td class="text-end">$<?= number_format($e['preciod'],2,',','.') ?></td>
          <td class="text-end"><?= number_format($e['precio'],2,',','.') ?></td>
        </tr>
        <?php endforeach; ?>
        <?php if (!$entradas): ?><tr><td colspan="8" class="text-center text-muted py-4">Sin entradas.</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
