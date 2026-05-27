
<?php
// Manejar descarga de JSON
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tickets = Ticket::api_getAllTickets();
    file_put_contents("json/tickets.json", $tickets);
    echo $tickets;
    exit;
}
?>
<form method="POST" style="display:inline;">
    <button type="submit" class="btn">Crear/Actualizar Tickets (JSON)</button>
</form>
