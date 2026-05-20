<main class="main">
  <?php 
  include __DIR__ . '/header.php'; 
  $msg = $global_msg ?? '';
  ?>
  <section class="container">
    <?php echo $msg; ?>
    <section class="toolbar" style="margin-bottom:12px;display:flex;gap:8px">
      <a href="index.php?page=products" class="btn secondary" style="text-decoration:none; display:flex; align-items:center; padding: 0 16px;">Ir a Productos</a>
      <button class="btn" onclick="document.getElementById('form-create-offer').style.display='block'; document.getElementById('form-edit-offer').style.display='none';" style="background:var(--accent-3); display:flex; align-items:center; padding: 0 16px;">Nueva Oferta</button>
    </section>

    <!-- FORMULARIO CREAR OFERTA -->
    <section class="form" id="form-create-offer" style="display:none; margin-bottom:20px;">
      <h3 style="margin-bottom:12px;">Crear Nueva Oferta</h3>
      <form method="POST" action="php/actions/offer_actions.php">
        <input type="hidden" name="action" value="create_offer">
        <section class="row">
          <section style="flex:2">
            <label>Nombre de la Oferta *</label>
            <input type="text" name="nombre" placeholder="Ej: Black Friday" required>
          </section>
          <section style="flex:1">
            <label>Descuento (%) *</label>
            <input type="number" step="0.01" name="descuento" placeholder="Ej: 15" required>
          </section>
          <section style="flex:2">
            <label>Productos *</label>
            <div style="display:flex; gap:8px; margin-bottom:8px; align-items:center;">
                <input type="text" id="search-create-prod" placeholder="Buscar producto..." onkeyup="filterProducts('create')" style="flex:1; padding:6px; border:1px solid #ccc; border-radius:4px;">
                <select id="select-create-prod" style="flex:2; padding:6px; border:1px solid #ccc; border-radius:4px;">
                  <?php
                    $productos = Producto::getProductos();
                    foreach($productos as $p){
                        echo "<option value='{$p->getIdProducto()}'>{$p->getNombre()} (" . number_format($p->getPrecioConIva(), 2) . " €)</option>";
                    }
                  ?>
                </select>
                <button type="button" class="btn primary" onclick="addProductToOffer('create')" style="padding:6px 12px; font-weight:bold; border-radius:4px; margin:0;">+</button>
            </div>
            <div id="container-create-prod" style="border:1px solid #ddd; border-radius:4px; padding:8px; min-height:80px; max-height:150px; overflow-y:auto; background:#fafafa;">
                <!-- Elementos añadidos aparecerán aquí -->
                <p id="empty-create-prod" style="color:#888; font-size:0.9em; margin:0;">Añade productos usando el botón +</p>
            </div>
          </section>
          <section style="flex:1">
            <label>Fecha Fin (Opcional)</label>
            <input type="date" name="fechaFin">
          </section>
        </section>
        <section class="row" style="margin-top: 16px;">
          <button type="submit" class="btn" style="background:var(--accent-2);">Guardar Oferta</button>
          <button type="button" class="btn secondary" onclick="document.getElementById('form-create-offer').style.display='none'">Cancelar</button>
        </section>
      </form>
    </section>

    <!-- FORMULARIO EDITAR OFERTA -->
    <section class="form" id="form-edit-offer" style="display:none; margin-bottom:20px;">
      <h3 style="margin-bottom:12px;">Editar Oferta</h3>
      <form method="POST" action="php/actions/offer_actions.php">
        <input type="hidden" name="action" value="update_offer">
        <input type="hidden" name="idOferta" id="edit-id-oferta">
        <section class="row">
          <section style="flex:2">
            <label>Nombre de la Oferta *</label>
            <input type="text" name="nombre" id="edit-nombre-oferta" required>
          </section>
          <section style="flex:1">
            <label>Descuento (%) *</label>
            <input type="number" step="0.01" name="descuento" id="edit-descuento-oferta" required>
          </section>
          <section style="flex:2">
            <label>Productos *</label>
            <div style="display:flex; gap:8px; margin-bottom:8px; align-items:center;">
                <input type="text" id="search-edit-prod" placeholder="Buscar producto..." onkeyup="filterProducts('edit')" style="flex:1; padding:6px; border:1px solid #ccc; border-radius:4px;">
                <select id="select-edit-prod" style="flex:2; padding:6px; border:1px solid #ccc; border-radius:4px;">
                  <?php
                    foreach($productos as $p){
                        echo "<option value='{$p->getIdProducto()}'>{$p->getNombre()} (" . number_format($p->getPrecioConIva(), 2) . " €)</option>";
                    }
                  ?>
                </select>
                <button type="button" class="btn primary" onclick="addProductToOffer('edit')" style="padding:6px 12px; font-weight:bold; border-radius:4px; margin:0;">+</button>
            </div>
            <div id="container-edit-prod" style="border:1px solid #ddd; border-radius:4px; padding:8px; min-height:80px; max-height:150px; overflow-y:auto; background:#fafafa;">
                <!-- Elementos añadidos aparecerán aquí -->
                <p id="empty-edit-prod" style="color:#888; font-size:0.9em; margin:0;">Añade productos usando el botón +</p>
            </div>
          </section>
          <section style="flex:1">
            <label>Fecha Fin (Opcional)</label>
            <input type="date" name="fechaFin" id="edit-fechafin-oferta">
          </section>
        </section>
        <section class="row" style="margin-top: 16px;">
          <button type="submit" class="btn" style="background:var(--accent-2);">Guardar Cambios</button>
          <button type="button" class="btn secondary" onclick="document.getElementById('form-edit-offer').style.display='none'">Cancelar</button>
        </section>
      </form>
    </section>

    <!-- LISTA DE OFERTAS -->
    <section class="table-wrap">
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descuento</th>
            <th>Producto</th>
            <th>Fecha Fin</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $ofertas = Oferta::getOfertas();
          foreach ($ofertas as $oferta) {
            $id = $oferta->getIdOferta();
            $nombre = htmlspecialchars($oferta->getNombre());
            $descuento = number_format($oferta->getDescuento(), 2) . ' %';
            $producto = htmlspecialchars($oferta->producto_nombre);
            $fechaFin = $oferta->getFechaFin();
            
            $activa = true;
            if(!empty($fechaFin) && strtotime($fechaFin) < strtotime(date('Y-m-d'))){
                $activa = false;
            }
            
            $estadoStr = $activa ? '<span style="color:green;font-weight:bold;">Activa</span>' : '<span style="color:red;">Caducada</span>';
            $jsNombre = htmlspecialchars(json_encode($oferta->getNombre()));
            $jsFecha = htmlspecialchars(json_encode($fechaFin ?? ''));
            $jsProductosIds = htmlspecialchars(json_encode($oferta->getProductosIds()));
            
            echo "<tr>";
            echo "<td>{$id}</td>";
            echo "<td>{$nombre}</td>";
            echo "<td>{$descuento}</td>";
            echo "<td>{$producto}</td>";
            echo "<td>" . ($fechaFin ? date('d/m/Y', strtotime($fechaFin)) : 'Sin límite') . "</td>";
            echo "<td>{$estadoStr}</td>";
            echo "<td class=\"actions\">
                    <button type=\"button\" class=\"btn-edit\" onclick='editOffer({$id}, {$jsNombre}, {$oferta->getDescuento()}, {$jsProductosIds}, {$jsFecha})'>✎</button>
                    <button type=\"button\" class=\"btn-delete\" onclick='deleteOffer({$id})'>🗑</button>
                  </td>";
            echo "</tr>";
          }
          if (empty($ofertas)) {
              echo "<tr><td colspan='7' style='text-align:center;'>No hay ofertas registradas.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </section>

    <footer class="footer">© 2026 Flores Nuria · Administración de Ofertas</footer>
  </section>
</main>

<form id="form-delete-offer" method="POST" action="php/actions/offer_actions.php" style="display:none;">
    <input type="hidden" name="action" value="delete_offer">
    <input type="hidden" name="idOferta" id="delete-id-oferta">
</form>
