<?php
// Página principal: ensamblado visual. Sin lógica de negocio.
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Floristería - Panel</title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <div class="app">
    <?php
      $page = $_GET['page'] ?? 'dashboard';
      include __DIR__ . '/public/sidebar.php';
      $allowedPages = ['dashboard', 'products', 'employees'];
      if(in_array($page, $allowedPages, true)){
        include __DIR__ . '/public/' . $page . '.php';
      } else {
        include __DIR__ . '/public/dashboard.php';
      }
    ?>
  </div>
</body>
</html>
