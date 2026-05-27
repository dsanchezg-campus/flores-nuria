<main class="main">
  <?php include __DIR__ . '/header.php'; ?>
  <section class="container">
    
    <?php
    $mensaje = $global_msg ?? '';
    ?>

    <section class="toolbar d-flex gap-2 mb-3">
      <a href="index.php?page=payments" class="btn secondary text-decoration-none d-flex align-center px-3">&laquo; Volver a Pagos</a>
    </section>

    <h3 class="mt-5 mb-3">Crear Nuevo Pago</h3>
    <?php echo $mensaje; ?>
    
    <?php
    $pedidos = Pedido::getPedidos();
    ?>

    <section class="form">
      <form method="POST" action="php/actions/payment_actions.php">
        <input type="hidden" name="action" value="create_payment">
        <section class="row">
          <section class="flex-2">
            <label>Pedido *</label>
            <select name="pedido_id" required>
              <option value="">-- Seleccionar Pedido --</option>
              <?php foreach($pedidos as $p): ?>
                <option value="<?= htmlspecialchars($p->getIdPedido(), ENT_QUOTES, 'UTF-8') ?>">#<?= htmlspecialchars($p->getIdPedido(), ENT_QUOTES, 'UTF-8') ?> - <?= htmlspecialchars($p->getFechaCreacion(), ENT_QUOTES, 'UTF-8') ?> - <?= number_format($p->getTotalPedido(), 2) ?>€</option>
              <?php endforeach; ?>
            </select>
          </section>
          <section class="flex-2">
            <label>Cliente</label>
            <input type="text" name="cliente" placeholder="Nombre del cliente">
          </section>
          <section class="flex-1">
            <label>Monto (€) *</label>
            <input type="number" step="0.01" name="monto" min="0.01" required>
          </section>
          <section class="flex-1">
            <label>Método de Pago *</label>
            <select name="metodo" required>
              <option value="">-- Seleccionar --</option>
              <option value="efectivo">Efectivo</option>
              <option value="tarjeta">Tarjeta</option>
              <option value="transferencia">Transferencia</option>
              <option value="otros">Otros</option>
            </select>
          </section>
        </section>

        <section class="row mt-4">
          <section class="flex-1">
            <label>Fecha</label>
            <input type="date" name="fecha" value="<?php echo date('Y-m-d'); ?>">
          </section>
        </section>

        <section class="row mt-4">
          <button type="submit" class="btn">Guardar Pago</button>
        </section>
      </form>
    </section>

    <footer class="footer">© 2026 Flores Nuria · Creación de pagos</footer>
  </section>
</main>
