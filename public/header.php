<?php
$pageLabelMap = [
  'dashboard' => 'Dashboard',
  'products' => 'Productos',
  'employees' => 'Empleados',
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
