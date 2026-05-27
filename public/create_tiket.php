
<?php
// Manejar descarga de JSON
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo Ticket::api_getAllTickets();
    exit;
}
?>

<form method="POST" style="display:inline;">
    <button type="submit" class="btn">Descargar Tickets (JSON)</button>
</form>
