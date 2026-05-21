<?php
$pageLabelMap = [
  'dashboard' => 'Dashboard',
  'products' => 'Productos',
  'employees' => 'Empleados',
  'reports' => 'Informes',
  'payments' => 'Cobros/Pagos',
  'schedule' => 'Agenda',
  'customers' => 'Clientes',
  'suppliers' => 'Proveedores',
  'invoices' => 'Facturas emitidas',
  'deliveries' => 'Albaranes emitidos',
  'budgets' => 'Presupuestos emitidos',
  'login' => 'Acceder',
  'register' => 'Registrarse',
  'create-employee' => 'Crear Empleado',
  'create-product' => 'Crear Producto',
  'create-customer' => 'Crear Cliente',
  'create-supplier' => 'Crear Proveedor',
  'create-invoice' => 'Crear Factura',
  'create-delivery' => 'Crear Albaran',
  'create-budget' => 'Crear Presupuesto',
];
$currentPage = $page ?? ($_GET['page'] ?? 'dashboard');
$currentPageLabel = $pageLabelMap[$currentPage] ?? 'Dashboard';
$breadcrumbItems = ['Dashboard'];
if($currentPage !== 'dashboard'){
  $breadcrumbItems[] = $currentPageLabel;
}
?>
<header class="header">
  <section class="left">
    <section class="logo">
      <button class="menu-toggle" type="button">☰</button>
    </section>
    <nav class="breadcrumbs" aria-label="breadcrumb">
      <ol>
        <?php foreach($breadcrumbItems as $item): ?>
          <li><?= htmlspecialchars($item, ENT_QUOTES, 'UTF-8') ?></li>
        <?php endforeach; ?>
      </ol>
    </nav>
  </section>
  <section class="right">
    <span class="user-circle">D</span>
  </section>
</header>
