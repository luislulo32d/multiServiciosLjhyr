<h2 class="mb-3"><?= $item ? 'Editar' : 'Nueva' ?> marca</h2>
<form method="post" action="<?= $item ? '/marcas/editar' : '/marcas/crear' ?>" class="card p-4" style="max-width:500px">
  <?php if ($item): ?><input type="hidden" name="id" value="<?= $item['marca_id'] ?>"><?php endif; ?>
  <div class="mb-3">
    <label class="form-label">Nombre *</label>
    <input name="marca" class="form-control" required value="<?= htmlspecialchars($item['marca'] ?? '') ?>">
  </div>
  <div><button class="btn btn-primary">Guardar</button> <a href="/marcas" class="btn btn-outline-secondary">Cancelar</a></div>
</form>
