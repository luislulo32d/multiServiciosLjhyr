<div class="d-flex justify-content-between mb-3">
  <h2>Categorías</h2>
  <a href="/categorias/crear" class="btn btn-primary btn-sm">+ Nueva</a>
</div>
<div class="card" style="max-width:600px">
  <ul class="list-group list-group-flush">
    <?php foreach ($items as $c): ?>
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <?= htmlspecialchars($c['nombre']) ?>
        <div>
          <a href="/categorias/editar?id=<?= $c['categoria_id'] ?>" class="btn btn-sm btn-outline-secondary">Editar</a>
          <form method="post" action="/categorias/eliminar" class="d-inline" onsubmit="return confirm('¿Eliminar?')">
            <input type="hidden" name="id" value="<?= $c['categoria_id'] ?>">
            <button class="btn btn-sm btn-outline-danger">Eliminar</button>
          </form>
        </div>
      </li>
    <?php endforeach; ?>
    <?php if (!$items): ?><li class="list-group-item text-muted">Sin categorías.</li><?php endif; ?>
  </ul>
</div>
