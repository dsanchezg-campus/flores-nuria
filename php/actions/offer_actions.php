<?php
session_start();
require_once __DIR__ . '/../clases.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'create_offer') {
        $nombre = $_POST['nombre'] ?? '';
        $descuento = $_POST['descuento'] ?? '';
        $productosIds = $_POST['productos'] ?? [];
        $fechaFin = $_POST['fechaFin'] ?? null;
        if (empty($fechaFin)) $fechaFin = null;
        
        if (!empty($nombre) && is_numeric($descuento) && !empty($productosIds)) {
            $nuevaOferta = new Oferta(null, $nombre, $descuento, null, null, $fechaFin, $productosIds);
            if ($nuevaOferta->IngresarOferta()) {
                $_SESSION['msg'] = "<div class='color-green mb-3'>Oferta creada correctamente.</div>";
            } else {
                $_SESSION['msg'] = "<div class='color-red mb-3'>Error al crear la oferta.</div>";
            }
        } else {
            $_SESSION['msg'] = "<div class='color-red mb-3'>Datos inválidos. Verifica el formulario.</div>";
        }
        header("Location: ../../index.php?page=offers");
        exit;
    } 
    elseif ($action === 'update_offer') {
        $idEdit = $_POST['idOferta'] ?? '';
        $nombreEdit = $_POST['nombre'] ?? '';
        $descuentoEdit = $_POST['descuento'] ?? '';
        $productosIdsEdit = $_POST['productos'] ?? [];
        $fechaFinEdit = $_POST['fechaFin'] ?? null;
        if (empty($fechaFinEdit)) $fechaFinEdit = null;
        
        if (!empty($idEdit) && !empty($nombreEdit) && is_numeric($descuentoEdit) && !empty($productosIdsEdit)) {
            $ofertaActualizar = new Oferta($idEdit, $nombreEdit, $descuentoEdit, null, null, $fechaFinEdit, $productosIdsEdit);
            if ($ofertaActualizar->ActualizarOferta()) {
                $_SESSION['msg'] = "<div class='color-green mb-3'>Oferta actualizada correctamente.</div>";
            } else {
                $_SESSION['msg'] = "<div class='color-red mb-3'>No se realizaron cambios o hubo un error.</div>";
            }
        }
        header("Location: ../../index.php?page=offers");
        exit;
    } 
    elseif ($action === 'delete_offer') {
        $idDel = $_POST['idOferta'] ?? '';
        if (!empty($idDel)) {
            $ofertaEliminar = new Oferta($idDel, '', 0, null, null, null, 0);
            if ($ofertaEliminar->EliminarOferta()) {
                $_SESSION['msg'] = "<div class='color-green mb-3'>Oferta eliminada correctamente.</div>";
            } else {
                $_SESSION['msg'] = "<div class='color-red mb-3'>Error al eliminar la oferta.</div>";
            }
        }
        header("Location: ../../index.php?page=offers");
        exit;
    }
}
header("Location: ../../index.php");
exit;
