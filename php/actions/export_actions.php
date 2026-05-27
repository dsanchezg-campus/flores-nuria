<?php

declare(strict_types=1);

class ExportActions
{
    /**
     * Exporta todos los tickets en formato JSON
     */
    public static function exportTicketsJson(): string
    {
        try {
            return Ticket::api_getAllTickets();
        } catch (Exception $e) {
            http_response_code(500);
            return json_encode([
                'error' => true,
                'message' => 'Error al generar JSON: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Maneja las solicitudes AJAX para exportar
     */
    public static function handle(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            return;
        }

        if (!isset($_POST['action'])) {
            http_response_code(400);
            return;
        }

        header('Content-Type: application/json');

        switch ($_POST['action']) {
            case 'export_json':
                echo self::exportTicketsJson();
                break;
            default:
                http_response_code(400);
                echo json_encode(['error' => 'Acción no válida']);
        }

        exit;
    }
}
