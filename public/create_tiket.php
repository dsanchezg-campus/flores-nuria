
<?php
// Manejar descarga de JSON
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo Ticket::api_getAllTickets();
    exit;
}
?>
<button class="btn" onclick="window.location.href='index.php?page=payments'">&laquo; Volver a Tickets</button>
<form method="POST" style="display:inline;">
    <button type="submit" class="btn">Descargar Tickets (JSON)</button>
</form>
