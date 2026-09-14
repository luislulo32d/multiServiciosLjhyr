<h2 class="mb-3"><?= $item ? 'Editar' : 'Nueva' ?> tasa</h2>
<form method="post" action="<?= $item ? '/tasas/editar' : '/tasas/crear' ?>" class="card p-4" style="max-width:500px">
  <?php if ($item): ?><input type="hidden" name="id" value="<?= $item['tasa_id'] ?>"><?php endif; ?>
  <div class="mb-3">
    <label class="form-label">Fecha *</label>
    <input type="date" name="fecha" class="form-control" required value="<?= htmlspecialchars($item['fecha'] ?? date('Y-m-d')) ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Tasa oficial BCV (Bs/USD) *</label>
    <input type="number" step="0.0001" min="0" name="oficial" class="form-control" required value="<?= htmlspecialchars($item['oficial'] ?? '') ?>">
  </div>
  <div><button class="btn btn-primary">Guardar</button> <a href="/tasas" class="btn btn-outline-secondary">Cancelar</a></div>
</form>
