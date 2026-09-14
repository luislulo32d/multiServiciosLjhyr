<div class="d-flex justify-content-between mb-3">
  <h2>Tasas BCV</h2>
  <a href="/tasas/crear" class="btn btn-primary btn-sm">+ Nueva tasa</a>
</div>
<div class="card" style="max-width:800px">
  <table class="table table-hover mb-0">
    <thead class="table-light"><tr><th>Fecha</th><th class="text-end">Oficial (Bs/USD)</th><th>Moneda</th><th>Creada</th><th></th></tr></thead>
    <tbody>
      <?php foreach ($items as $t): ?>
      <tr class="<?= $t['fecha']===date('Y-m-d')?'table-success':'' ?>">
        <td><?= $t['fecha'] ?> <?= $t['fecha']===date('Y-m-d')?'<span class="badge bg-success">HOY</span>':'' ?></td>
        <td class="text-end"><?= number_format($t['oficial'],4,',','.') ?></td>
        <td><?= htmlspecialchars($t['moneda']) ?></td>
        <td class="small text-muted"><?= $t['creada_en'] ?></td>
        <td class="text-end">
          <a href="/tasas/editar?id=<?= $t['tasa_id'] ?>" class="btn btn-sm btn-outline-secondary">Editar</a>
          <form method="post" action="/tasas/eliminar" class="d-inline" onsubmit="return confirm('¿Eliminar tasa?')">
            <input type="hidden" name="id" value="<?= $t['tasa_id'] ?>">
            <button class="btn btn-sm btn-outline-danger">Eliminar</button>
          </form>
        </td>
      </tr>
      <?php endforeach; ?>
      <?php if (!$items): ?><tr><td colspan="5" class="text-muted text-center py-4">Sin tasas registradas.</td></tr><?php endif; ?>
    </tbody>
  </table>
</div>
