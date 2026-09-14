<div class="d-flex justify-content-between mb-3">
  <h2>Marcas</h2>
  <a href="/marcas/crear" class="btn btn-primary btn-sm">+ Nueva</a>
</div>
<div class="card" style="max-width:600px">
  <ul class="list-group list-group-flush">
    <?php foreach ($items as $m): ?>
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <?= htmlspecialchars($m['marca']) ?>
        <div>
          <a href="/marcas/editar?id=<?= $m['marca_id'] ?>" class="btn btn-sm btn-outline-secondary">Editar</a>
          <form method="post" action="/marcas/eliminar" class="d-inline" onsubmit="return confirm('¿Eliminar?')">
            <input type="hidden" name="id" value="<?= $m['marca_id'] ?>">
            <button class="btn btn-sm btn-outline-danger">Eliminar</button>
          </form>
        </div>
      </li>
    <?php endforeach; ?>
    <?php if (!$items): ?><li class="list-group-item text-muted">Sin marcas.</li><?php endif; ?>
  </ul>
</div>
