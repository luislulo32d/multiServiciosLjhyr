<h2 class="mb-3">Nueva entrada</h2>
<p class="text-muted small">Tasa de hoy: <strong><?= number_format($tasa['oficial'],2,',','.') ?> Bs/USD</strong></p>

<form method="post" action="/entradas/crear" class="card p-4" style="max-width:800px" id="formEntrada">
  <div class="row g-3">
    <div class="col-md-8">
      <label class="form-label">Producto *</label>
      <select name="producto_id" class="form-select" required>
        <option value="">— Seleccione —</option>
        <?php foreach ($productos as $p): ?>
          <option value="<?= $p['producto_id'] ?>"><?= htmlspecialchars($p['nombre']) ?> (stock: <?= $p['cantidad'] ?>)</option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-4">
      <label class="form-label">Tipo *</label>
      <select name="tipo" id="tipo" class="form-select" required>
        <option value="compra">Compra</option>
        <option value="ajuste">Ajuste (+)</option>
      </select>
    </div>

    <div class="col-md-4">
      <label class="form-label">Cantidad *</label>
      <input type="number" min="1" name="cantidad" class="form-control" required>
    </div>
    <div class="col-md-4">
      <label class="form-label">Costo USD</label>
      <input type="number" step="0.01" min="0" name="costod" id="costod" class="form-control" value="0">
    </div>
    <div class="col-md-4">
      <label class="form-label">Precio venta USD</label>
      <input type="number" step="0.01" min="0" name="preciod" id="preciod" class="form-control" value="0">
    </div>

    <div class="col-md-6">
      <label class="form-label">Costo Bs (auto)</label>
      <input type="text" id="costoBs" class="form-control" readonly>
    </div>
    <div class="col-md-6">
      <label class="form-label">Precio Bs (auto)</label>
      <input type="text" id="precioBs" class="form-control" readonly>
    </div>

    <div class="col-md-12" id="motivoWrap" style="display:none">
      <label class="form-label">Motivo del ajuste *</label>
      <input name="motivo_ajuste" class="form-control" placeholder="Ej: devolución, corrección de conteo">
    </div>
  </div>
  <div class="mt-4">
    <button class="btn btn-primary">Registrar</button>
    <a href="/entradas" class="btn btn-outline-secondary">Cancelar</a>
  </div>
</form>

<script>
const tasa = <?= (float)$tasa['oficial'] ?>;
const tipo = document.getElementById('tipo');
const motivoWrap = document.getElementById('motivoWrap');
const costod = document.getElementById('costod');
const preciod = document.getElementById('preciod');

function recalc(){
  document.getElementById('costoBs').value  = (parseFloat(costod.value||0) * tasa).toFixed(2);
  document.getElementById('precioBs').value = (parseFloat(preciod.value||0) * tasa).toFixed(2);
}
function toggleMotivo(){ motivoWrap.style.display = tipo.value==='ajuste'?'block':'none'; }
tipo.addEventListener('change', toggleMotivo);
costod.addEventListener('input', recalc);
preciod.addEventListener('input', recalc);
toggleMotivo(); recalc();
</script>
