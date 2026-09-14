<div class="d-flex justify-content-between mb-3">
  <h2>Salidas de inventario</h2>
  <a href="/salidas/crear" class="btn btn-primary btn-sm">+ Nueva salida</a>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light">
        <tr><th>Fecha</th><th>Producto</th><th>Tipo</th><th>Motivo</th>
            <th class="text-center">Cant.</th><th class="text-end">Precio USD</th>
            <th class="text-end">Precio Bs</th><th class="text-end">Tasa</th></tr>
      </thead>
      <tbody>
        <?php foreach ($salidas as $s): ?>
        <tr>
          <td class="small"><?= date('d/m/Y H:i', strtotime($s['fecha'])) ?></td>
          <td><?= htmlspecialchars($s['producto']) ?></td>
          <td><span class="badge bg-<?= $s['tipo']==='venta'?'success':'warning text-dark' ?>"><?= $s['tipo'] ?></span></td>
          <td class="small text-muted"><?= htmlspecialchars($s['motivo_ajuste'] ?? '—') ?></td>
          <td class="text-center text-danger">−<?= $s['cantidad'] ?></td>
          <td class="text-end">$<?= number_format($s['preciod'],2,',','.') ?></td>
          <td class="text-end"><?= number_format($s['precio'],2,',','.') ?></td>
          <td class="text-end small"><?= number_format($s['tasa'],2,',','.') ?></td>
        </tr>
        <?php endforeach; ?>
        <?php if (!$salidas): ?><tr><td colspan="8" class="text-center text-muted py-4">Sin salidas.</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
