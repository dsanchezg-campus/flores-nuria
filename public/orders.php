<main class="main">
  <?php 
  include __DIR__ . '/header.php'; 
  $msg = $global_msg ?? '';
  ?>
  <section class="container">
    <?php echo $msg; ?>
    <section class="toolbar" style="margin-bottom:12px;display:flex;gap:8px">
      <form method="GET" action="index.php" style="display:flex;gap:8px;margin:0;">
        <input type="hidden" name="page" value="orders">
        <input type="text" name="search" placeholder="Buscar por estado o proveedor..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>" style="padding:6px 12px; border:1px solid #ccc; border-radius:4px; outline:none;">
        <button type="submit" class="btn">Buscar</button>
      </form>
      <a href="index.php?page=orders" class="btn" style="background:var(--accent-3); text-decoration:none; color:inherit; display:flex; align-items:center; padding: 0 16px;">Mostrar Todo</a>
      <a href="index.php?page=create_order" class="btn secondary" style="text-decoration:none; display:flex; align-items:center; padding: 0 16px;">Realizar pedido</a>
    </section>

    <section class="table-wrap">
      <table class="table">
        <thead>
          <tr>
              <th>ID</th>
              <th>Proveedor (ID)</th>
              <th>Fecha</th>
              <th>Estado</th>
              <th>Productos</th>
              <th>Acciones Rápidas</th>
              <th></th>
          </tr>
        </thead>
        <tbody>
          <?php
          $busqueda = trim($_GET['search'] ?? '');
          if ($busqueda !== '') {
              $pedidos = Pedido::buscarPedidos($busqueda);
          } else {
              $pedidos = Pedido::getPedidos();
          }
          
          // Crear mapa de productos para mostrar nombres en lugar de IDs
          $allProducts = Producto::getProductos();
          $prodMap = [];
          foreach($allProducts as $p) {
              $prodMap[$p->getIdProducto()] = $p->getNombre();
          }
          
          foreach ($pedidos as $pedido) {
            $id = htmlspecialchars($pedido->getIdPedido());
            $proveedorId = htmlspecialchars($pedido->getIdProveedor());
            $fecha = htmlspecialchars($pedido->getFechaCreacion());
            $estado = htmlspecialchars($pedido->getEstado());
            
            $bolsa = $pedido->getBolsaCompra();
            $prodsArr = $bolsa ? $bolsa->getProductos() : [];
            $numProds = count($prodsArr);
            
            $orderItems = [];
            foreach($prodsArr as $item) {
                $pId = $item[0];
                $pQty = $item[1];
                $pName = $prodMap[$pId] ?? 'Producto Desconocido';
                $orderItems[] = ['nombre' => $pName, 'cantidad' => $pQty];
            }
            
            $jsOrderItems = htmlspecialchars(json_encode($orderItems));
            $jsFecha = htmlspecialchars(json_encode($pedido->getFechaCreacion()));
            $jsEstado = htmlspecialchars(json_encode($pedido->getEstado()));
            
            // Colores por estado
            $estadoStr = $estado;
            if (strtolower($estado) === 'recibido') $estadoStr = "<span style='color:green;font-weight:bold;'>$estado</span>";
            if (strtolower($estado) === 'cancelado') $estadoStr = "<span style='color:red;font-weight:bold;'>$estado</span>";
            if (strtolower($estado) === 'pendiente') $estadoStr = "<span style='color:orange;font-weight:bold;'>$estado</span>";
            
            echo "<tr>";
            echo "<td>#{$id}</td>";
            echo "<td>{$proveedorId}</td>";
            echo "<td>{$fecha}</td>";
            echo "<td>{$estadoStr}</td>";
            echo "<td>{$numProds} tipos</td>";
            echo "<td style='display:flex;gap:4px;'>
                    <button type=\"button\" class=\"btn secondary\" style='padding:2px 8px;font-size:12px;' onclick='changeStatus({$id}, \"Pendiente\")'>Pendiente</button>
                    <button type=\"button\" class=\"btn\" style='padding:2px 8px;font-size:12px;background:green;' onclick='changeStatus({$id}, \"Recibido\")'>Recibido</button>
                    <button type=\"button\" class=\"btn\" style='padding:2px 8px;font-size:12px;background:red;' onclick='changeStatus({$id}, \"Cancelado\")'>Cancelado</button>
                  </td>";
            echo "<td class=\"actions\">
                    <button type=\"button\" class=\"btn-view\" style='background:none;border:none;cursor:pointer;font-size:18px;' onclick='viewOrder({$id}, {$jsOrderItems})'>👁</button>
                    <button type=\"button\" class=\"btn-edit\" onclick='editOrder({$id}, {$proveedorId}, {$jsFecha}, {$jsEstado})'>✎</button>
                    <button type=\"button\" class=\"btn-delete\" onclick='deleteOrder({$id})'>🗑</button>
                  </td>";
            echo "</tr>";
          }
          
          if (empty($pedidos)) {
              echo "<tr><td colspan='7' style='text-align:center;'>No hay pedidos registrados.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </section>

    <h3 id="view-title" style="margin-top:18px; display:none;">Detalles del Pedido #<span id="view-id"></span></h3>
    <section id="view-panel" class="form" style="display:none; background:#f9f9f9; padding: 16px; border-radius: 8px;">
        <h4 style="margin-top:0; border-bottom:1px solid #ccc; padding-bottom:8px;">Productos incluidos</h4>
        <ul id="view-items-list" style="list-style:none; padding:0; margin:0;">
        </ul>
        <button type="button" class="btn secondary" onclick="closeViewPanel()" style="margin-top:16px;">Cerrar detalles</button>
    </section>

    <h3 id="edit-title" style="margin-top:18px; display:none;">Editar Pedido</h3>
    <section class="form">
      <form id="form-edit-order" method="POST" action="php/actions/order_actions.php" style="display:none;">
        <input type="hidden" name="action" value="update_order">
        <input type="hidden" name="idPedido" id="edit-id">
        
        <section class="row">
          <section style="flex:1">
            <label>ID Proveedor *</label>
            <input type="number" name="id_proveedor" id="edit-proveedor" required>
          </section>
          <section style="flex:1">
            <label>Fecha</label>
            <input type="date" name="fecha" id="edit-fecha">
          </section>
          <section style="flex:1">
            <label>Estado</label>
            <select name="estado" id="edit-estado">
              <option value="Pendiente">Pendiente</option>
              <option value="Recibido">Recibido</option>
              <option value="Cancelado">Cancelado</option>
            </select>
          </section>
        </section>

        <section class="row" style="margin-top: 16px;">
          <button type="submit" class="btn" style="background:var(--accent-2);">Guardar cambios</button>
          <button type="button" class="btn secondary" onclick="closeEditForm()">Cancelar</button>
        </section>
      </form>
    </section>

    <footer class="footer">© 2026 Flores Nuria · Administración de pedidos</footer>
  </section>
</main>

<form id="form-delete-order" method="POST" action="php/actions/order_actions.php" style="display:none;">
    <input type="hidden" name="action" value="delete_order">
    <input type="hidden" name="idPedido" id="delete-id">
</form>

<form id="form-status-order" method="POST" action="php/actions/order_actions.php" style="display:none;">
    <input type="hidden" name="action" value="change_status">
    <input type="hidden" name="idPedido" id="status-id">
    <input type="hidden" name="estado" id="status-val">
</form>
