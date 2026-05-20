<main class="main">
  <?php include __DIR__ . '/header.php'; ?>
  <section class="container">
    
    <?php
    $mensaje = $global_msg ?? '';
    ?>

    <section class="toolbar" style="margin-bottom:12px;display:flex;gap:8px">
      <a href="index.php?page=products" class="btn secondary" style="text-decoration:none; display:flex; align-items:center; padding: 0 16px;">&laquo; Volver a Productos</a>
    </section>

    <h3 style="margin-top:18px; margin-bottom:12px;">Crear Nuevo Producto</h3>
    <?php echo $mensaje; ?>
    
    <section class="form">
      <form method="POST" action="php/actions/product_actions.php">
        <input type="hidden" name="action" value="create_product">
        <section class="row">
          <section style="flex:2">
            <label>Nombre del Producto *</label>
            <input type="text" name="nombre" placeholder="Ej: Rosa roja" required>
          </section>
          <section style="flex:1">
            <label>Precio Base (€) *</label>
            <input type="number" step="0.01" name="precio" required>
          </section>
          <section style="flex:1">
            <label>IVA (%)</label>
            <input type="number" step="0.01" name="iva" value="21.00" required>
          </section>
          <section style="flex:1">
            <label>Stock Inicial</label>
            <input type="number" name="stock" value="0">
          </section>
        </section>

        <section class="row" style="margin-top: 16px;">
          <button type="submit" class="btn">Guardar Producto</button>
        </section>
      </form>
    </section>

    <footer class="footer">© 2026 Flores Nuria · Creación de productos</footer>
  </section>
</main>
