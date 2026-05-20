<main class="main">
  <?php 
  include __DIR__ . '/header.php'; 
  $msg = $global_msg ?? '';
  ?>
  <section class="container">
    <?php echo $msg; ?>
    <section class="toolbar" style="margin-bottom:12px;display:flex;gap:8px">
      <form method="GET" action="index.php" style="display:flex;gap:8px;margin:0;">
        <input type="hidden" name="page" value="products">
        <input type="text" name="search" placeholder="Buscar producto..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>" style="padding:6px 12px; border:1px solid #ccc; border-radius:4px; outline:none;">
        <button type="submit" class="btn">Buscar</button>
      </form>
      <button class="btn secondary">Familias</button>
      <a href="index.php?page=products" class="btn" style="background:var(--accent-3); text-decoration:none; color:inherit; display:flex; align-items:center; padding: 0 16px;">Mostrar Todo</a>
      <a href="index.php?page=create_product" class="btn secondary" style="text-decoration:none; display:flex; align-items:center; padding: 0 16px;">Nuevo producto</a>
    </section>

    <section class="table-wrap">
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Precio Base</th>
            <th>IVA</th>
            <th>Precio Final</th>
            <th>Stock</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $busqueda = trim($_GET['search'] ?? '');
          if ($busqueda !== '') {
              $productos = Producto::buscarProductos($busqueda);
          } else {
              $productos = Producto::getProductos();
          }
          
          foreach ($productos as $producto) {
            $id = htmlspecialchars($producto->getIdProducto());
            $nombre = htmlspecialchars($producto->getNombre());
            $stock = htmlspecialchars($producto->getStock());
            $precio_raw = (float)$producto->getPrecio();
            $iva = (float)$producto->getIva();
            $precio_final = (float)$producto->getPrecioConIva();
            
            $ofertaInfo = '';
            $ofertasProd = $producto->getOferta();
            if (!empty($ofertasProd)) {
                $ofertaActiva = $ofertasProd[0];
                $fechaFin = $ofertaActiva->getFechaFin();
                if (empty($fechaFin) || strtotime($fechaFin) >= strtotime(date('Y-m-d'))) {
                    $ofertaInfo = '<br><span style="background:var(--accent-3); color:white; padding:2px 6px; border-radius:4px; font-size:0.8em; font-weight:bold;">Oferta: -' . $ofertaActiva->getDescuento() . '%</span>';
                }
            }
            
            $highlightClass = $stock > 0 ? ' class="highlight"' : '';
            
            // Pasamos los datos puros a JS, por eso usamos json_encode para escapar strings seguros
            $jsNombre = htmlspecialchars(json_encode($producto->getNombre()));
            
            echo "<tr{$highlightClass}>";
            echo "<td>{$id}</td>";
            echo "<td>{$nombre}{$ofertaInfo}</td>";
            echo "<td>" . number_format($precio_raw, 2) . " €</td>";
            echo "<td>" . number_format($iva, 2) . " %</td>";
            echo "<td>" . number_format($precio_final, 2) . " €</td>";
            echo "<td>{$stock}</td>";
            echo "<td>" . ($stock > 0 ? 'Disponible' : 'Agotado') . "</td>";
            echo "<td class=\"actions\">
                    <button type=\"button\" class=\"btn-edit\" onclick='editProduct({$id}, {$jsNombre}, {$precio_raw}, {$iva}, {$stock})'>✎</button>
                    <button type=\"button\" class=\"btn-delete\" onclick='deleteProduct({$id})'>🗑</button>
                  </td>";
            echo "</tr>";
          }
          
          if (empty($productos)) {
              echo "<tr><td colspan='8' style='text-align:center;'>No hay productos registrados.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </section>

    <h3 id="edit-title" style="margin-top:18px; display:none;">Editar producto</h3>
    <section class="form">
      <form id="form-edit-product" method="POST" action="php/actions/product_actions.php" style="display:none;">
        <input type="hidden" name="action" value="update_product">
        <input type="hidden" name="idProducto" id="edit-id">
        
        <section class="row">
          <section style="flex:2">
            <label>Nombre del Producto *</label>
            <input type="text" name="nombre" id="edit-nombre" required>
          </section>
          <section style="flex:1">
            <label>Precio Base (€) *</label>
            <input type="number" step="0.01" name="precio" id="edit-precio" required>
          </section>
          <section style="flex:1">
            <label>IVA (%) *</label>
            <input type="number" step="0.01" name="iva" id="edit-iva" required>
          </section>
          <section style="flex:1">
            <label>Cantidad Stock</label>
            <input type="number" name="stock" id="edit-stock">
          </section>
        </section>
        <section class="row" style="margin-top: 16px;">
          <section style="flex:1">
            <label>Desvincular Oferta</label>
            <div style="margin-top:8px;">
                <input type="checkbox" name="quitar_oferta" value="1" id="edit-quitar-oferta">
                <label for="edit-quitar-oferta" style="display:inline;font-weight:normal;">Quitar oferta actual del producto</label>
            </div>
          </section>
        </section>

        <section class="row" style="margin-top: 16px;">
          <button type="submit" class="btn" style="background:var(--accent-2);">Guardar cambios</button>
          <button type="button" class="btn secondary" onclick="closeEditForm()">Cancelar</button>
        </section>
      </form>
    </section>

    <footer class="footer">© 2026 Flores Nuria · Administración de productos</footer>
  </section>
</main>

<form id="form-delete-product" method="POST" action="php/actions/product_actions.php" style="display:none;">
    <input type="hidden" name="action" value="delete_product">
    <input type="hidden" name="idProducto" id="delete-id">
</form>
