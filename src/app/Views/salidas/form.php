<h2 class="mb-3">Nueva salida</h2>
<p class="text-muted small">Tasa de hoy: <strong><?= number_format($tasa['oficial'],2,',','.') ?> Bs/USD</strong></p>

<form method="post" action="/salidas/crear" class="card p-4" style="max-width:800px" id="formSalida">
  <div class="row g-3">
    <div class="col-md-8">
      <label class="form-label">Producto *</label>
      <select name="producto_id" id="producto_id" class="form-select" required>
        <option value="">— Seleccione —</option>
        <?php foreach ($productos as $p): ?>
          <option value="<?= $p['producto_id'] ?>"
                  data-preciod="<?= $p['preciod'] ?>"
                  data-stock="<?= $p['cantidad'] ?>">
            <?= htmlspecialchars($p['nombre']) ?> (stock: <?= $p['cantidad'] ?>, $<?= number_format($p['preciod'],2,',','.') ?>)
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-4">
      <label class="form-label">Tipo *</label>
      <select name="tipo" id="tipo" class="form-select" required>
        <option value="venta">Venta</option>
        <option value="ajuste">Ajuste (−)</option>
      </select>
    </div>

    <div class="col-md-4">
      <label class="form-label">Cantidad *</label>
      <input type="number" min="1" name="cantidad" id="cantidad" class="form-control" required>
      <small class="text-muted" id="stockInfo"></small>
    </div>
    <div class="col-md-4">
      <label class="form-label">Precio venta USD</label>
      <input type="number" step="0.01" min="0" name="preciod" id="preciod" class="form-control" value="0">
    </div>
    <div class="col-md-4">
      <label class="form-label">Precio Bs (auto)</label>
      <input type="text" id="precioBs" class="form-control" readonly>
    </div>

    <div class="col-md-12" id="motivoWrap" style="display:none">
      <label class="form-label">Motivo del ajuste *</label>
      <input name="motivo_ajuste" class="form-control" placeholder="Ej: merma, robo, daño">
    </div>
  </div>
  <div class="mt-4">
    <button class="btn btn-primary">Registrar</button>
    <a href="/salidas" class="btn btn-outline-secondary">Cancelar</a>
  </div>
</form>

<script>
const tasa = <?= (float)$tasa['oficial'] ?>;
const tipo = document.getElementById('tipo');
const motivoWrap = document.getElementById('motivoWrap');
const prodSel = document.getElementById('producto_id');
const preciod = document.getElementById('preciod');
const cantidad = document.getElementById('cantidad');
const stockInfo = document.getElementById('stockInfo');

function recalc(){ document.getElementById('precioBs').value = (parseFloat(preciod.value||0) * tasa).toFixed(2); }
function toggleMotivo(){ motivoWrap.style.display = tipo.value==='ajuste'?'block':'none'; }
function cargarProducto(){
  const opt = prodSel.options[prodSel.selectedIndex];
  if (opt.dataset.preciod) {
    preciod.value = opt.dataset.preciod;
    stockInfo.textContent = 'Stock disponible: ' + opt.dataset.stock;
  } else { preciod.value = 0; stockInfo.textContent = ''; }
  recalc();
}
tipo.addEventListener('change', toggleMotivo);
preciod.addEventListener('input', recalc);
prodSel.addEventListener('change', cargarProducto);
toggleMotivo(); recalc();
</script>
