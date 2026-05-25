<?php
require_once 'autoloader.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!Empleado::checkSession()) {
    include __DIR__ . '/public/login.php';
    exit;
}

$global_msg = '';
if (isset($_SESSION['msg'])) {
    $global_msg = $_SESSION['msg'];
    unset($_SESSION['msg']);
}

// Página principal: ensamblado visual. Sin lógica de negocio.
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Floristería - Panel</title>
  <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" href="img/logo_fondo_blanco.jpg">
  <script src="js/menu.js" defer></script>
</head>
<body>
  <main class="app">
    <?php
      $page = $_GET['page'] ?? 'dashboard';
      include __DIR__ . '/public/sidebar.php';
//      Paginas permitidas para evitar fallos
      $allowedPages = ['dashboard', 'products', 'employees', 'reports', 'payments', 'schedule', 'customers', 'suppliers', 'invoices', 'deliveries', 'budgets', 'create_product', 'create_supplier', 'orders', 'create_order', 'offers'];
      if(in_array($page, $allowedPages, true)){
        include __DIR__ . '/public/' . $page . '.php';
      } else {
        include __DIR__ . '/public/dashboard.php';
      }
    ?>
  </main>
</body>
</html>
