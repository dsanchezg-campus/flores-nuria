<?php
require_once '../../autoloader.php';
session_start();

$action = $_REQUEST['action'] ?? '';

if ($action === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (!empty($correo) && !empty($password)) {
        $empleado = Empleado::InicioSesion($correo, $password);
        if ($empleado) {
            header("Location: ../../index.php");
            exit;
        } else {
            $_SESSION['login_error'] = 'Correo o contraseña incorrectos.';
        }
    } else {
        $_SESSION['login_error'] = 'Por favor, rellene todos los campos.';
    }
    header("Location: ../../index.php");
    exit;
}

if ($action === 'logout') {
    Empleado::logout();
    header("Location: ../../index.php");
    exit;
}

header("Location: ../../index.php");
exit;
