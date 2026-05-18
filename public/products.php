<main class="main">
  <?php include __DIR__ . '/header.php'; ?>
  <section class="container">
    <section class="toolbar" style="margin-bottom:12px;display:flex;gap:8px">
      <button class="btn">Buscador Avanzado</button>
      <button class="btn secondary">Familias</button>
      <button class="btn" style="background:var(--accent-3);">Mostrar Todo</button>
      <button class="btn secondary">Nuevo producto</button>
    </section>

    <section class="table-wrap">
      <table class="table">
        <thead>
          <tr><th>ID</th><th>Referencia</th><th>ID Proveedor</th><th>Unidad Medida</th><th>Stock</th><th>Precio PVP</th><th></th></tr>
        </thead>
        <tbody>
          <tr>
            <td>5</td>
            <td>Flor morada llamada rosa</td>
            <td>3 - Novelier</td>
            <td>ud - Unidades</td>
            <td>0</td>
            <td>71,39 €</td>
            <td class="actions"><button class="btn-edit">✎</button><button class="btn-delete">🗑</button></td>
          </tr>
          <tr class="highlight">
            <td>3</td>
            <td>Flor roja llamada rosa</td>
            <td>3 - Novelier</td>
            <td>ud - Unidades</td>
            <td>5</td>
            <td>48,40 €</td>
            <td class="actions"><button class="btn-edit">✎</button><button class="btn-delete">🗑</button></td>
          </tr>
        </tbody>
      </table>
    </section>

    <h3 style="margin-top:18px">Editar producto (vista)</h3>
    <section class="form">
      <section class="row">
        <section style="flex:2">
          <label>Nombre referencia</label>
          <input type="text" value="Puntales de hierro">
        </section>
        <section style="flex:1">
          <label>Código de barras</label>
          <input type="text" value="45678923">
        </section>
        <section style="flex:1">
          <label>Unidad de medida</label>
          <select><option>ud - Unidades</option><option>h - Horas</option></select>
        </section>
      </section>

      <section class="row">
        <section>
          <label>Precio base de compra</label>
          <input type="text" value="39,00">
        </section>
        <section>
          <label>Impuesto de compra</label>
          <select><option>21.00 %</option></select>
        </section>
        <section>
          <label>Precio base de venta</label>
          <input type="text" value="59,00">
        </section>
      </section>

      <section class="row">
        <section style="flex:2">
          <label>Proveedor</label>
          <input type="text" value="Novelier">
        </section>
        <section style="flex:1">
          <label>Familia</label>
          <input type="text" value="Pala tractora">
        </section>
      </section>

      <section class="row">
        <section style="flex:1">
          <label>Activar Stock</label>
          <select><option>NO</option><option>SI</option></select>
        </section>
        <section style="flex:1">
          <label>Cantidad Stock</label>
          <input type="number" value="0">
        </section>
        <section style="flex:1">
          <label>Alerta Stock</label>
          <input type="number" value="0">
        </section>
        <section style="flex:1;align-self:end">
          <button class="btn">Subir imagen</button>
        </section>
      </section>

    </section>

    <footer class="footer">© 2026 Flores Nuria · Administración de productos</footer>
  </section>
</main>
