<h2 class="mb-3"><?= $item ? 'Editar' : 'Nueva' ?> categoría</h2>
<form method="post" action="<?= $item ? '/categorias/editar' : '/categorias/crear' ?>" class="card p-4" style="max-width:500px">
  <?php if ($item): ?><input type="hidden" name="id" value="<?= $item['categoria_id'] ?>"><?php endif; ?>
  <div class="mb-3">
    <label class="form-label">Nombre *</label>
    <input name="nombre" class="form-control" required value="<?= htmlspecialchars($item['nombre'] ?? '') ?>">
  </div>
  <div><button class="btn btn-primary">Guardar</button> <a href="/categorias" class="btn btn-outline-secondary">Cancelar</a></div>
</form>
