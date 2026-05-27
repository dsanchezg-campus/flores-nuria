<?php
/**
 * Solicitud AJAX para exportar tickets en JSON
 * 
 * Este archivo maneja las solicitudes POST del botón de exportación
 * Se incluye en index.php pero también responde a peticiones AJAX
 */

require_once '../autoloader.php';

// Si viene una petición AJAX para generar JSON
if (['REQUEST_METHOD'] === 'POST' && isset(['action'])) {
    header('Content-Type: application/json');
    ExportActions::handle();
    exit;
}
?>

<!-- Exportador de Tickets en JSON -->
<div class="export-container">
    <h1 class="export-title">📋 Exportar Tickets</h1>
    
    <div class="export-button-wrapper">
        <button id="exportBtn">
            <span>GENERAR JSON</span>
            <div class="spinner"></div>
        </button>
    </div>

    <div class="export-info">
        <strong>Haz clic en el botón para descargar todos los tickets en formato JSON</strong><br>
        Se incluirán todos los detalles de venta y productos asociados.
    </div>
</div>
