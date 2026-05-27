
<?php
// Manejar descarga de JSON
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tickets = Ticket::api_getAllTickets();
    file_put_contents("../json/tickets.json", $tickets);
    echo $tickets;
    exit;
}
?>
<button class="btn" onclick="window.location.href='index.php?page=payments'">&laquo; Volver a Tickets</button>
<form method="POST" style="display:inline;">
    <button type="submit" class="btn">Descargar Tickets (JSON)</button>
</form>
