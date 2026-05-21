<?php
$currentPage = $page ?? ($_GET['page'] ?? 'dashboard');
function sidebarActive(string $slug, string $current): string {
  return $slug === $current ? 'active' : '';
}
?>
<aside class="sidebar">
  <section class="logo">
    <span class="brand"><img src="img/logo.png"></span>
  </section>
  <nav class="nav" aria-label="navegación principal">
    <h4>Navegación</h4>
    <ul>
      <li class="<?= sidebarActive('dashboard', $currentPage) ?>"><a href="?page=dashboard"><span class="icon">🏠</span>Dashboard</a></li>
      <li class="<?= sidebarActive('reports', $currentPage) ?>"><a href="?page=reports"><span class="icon">📊</span>Informes</a></li>
      <li class="<?= sidebarActive('payments', $currentPage) ?>"><a href="?page=payments"><span class="icon">💳</span>Cobros/Pagos</a></li>
      <li class="<?= sidebarActive('schedule', $currentPage) ?>"><a href="?page=schedule"><span class="icon">📅</span>Agenda</a></li>
      <li class="<?= sidebarActive('products', $currentPage) ?>"><a href="?page=products"><span class="icon">📦</span>Productos</a></li>
      <li class="<?= sidebarActive('offers', $currentPage) ?>"><a href="?page=offers"><span class="icon">🏷️</span>Ofertas</a></li>
      <li class="<?= sidebarActive('orders', $currentPage) ?>"><a href="?page=orders"><span class="icon">📋</span>Pedidos</a></li>
      <li class="<?= sidebarActive('customers', $currentPage) ?>"><a href="?page=customers"><span class="icon">👥</span>Clientes</a></li>
      <li class="<?= sidebarActive('suppliers', $currentPage) ?>"><a href="?page=suppliers"><span class="icon">🏷️</span>Proveedores</a></li>
      <li class="<?= sidebarActive('employees', $currentPage) ?>"><a href="?page=employees"><span class="icon">🧑‍💼</span>Empleados</a></li>
    </ul>
    <h4>Ventas</h4>
    <ul>
      <li class="<?= sidebarActive('invoices', $currentPage) ?>"><a href="?page=invoices"><span class="icon">🧾</span>Facturas emitidas</a></li>
      <li class="<?= sidebarActive('deliveries', $currentPage) ?>"><a href="?page=deliveries"><span class="icon">📄</span>Albaranes emitidos</a></li>
      <li class="<?= sidebarActive('budgets', $currentPage) ?>"><a href="?page=budgets"><span class="icon">📑</span>Presupuestos emitidos</a></li>
    </ul>
    <h4>Usuario</h4>
    <ul>
      <li><a href="php/actions/auth_actions.php?action=logout"><span class="icon">🚪</span>Cerrar Sesión</a></li>
    </ul>
  </nav>
</aside>
