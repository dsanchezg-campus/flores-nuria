<?php

class Ticket
{
    private $idTicket;
    private $empleado;
    private $cliente;
    private $fechaCreacion;
    private $totalVenta;
    private $num_ticket;
    private $BolsaCompra;
    public function __construct($idTicket, $empleado, $cliente, $fechaCreacion, $totalVenta, $num_ticket, $BolsaCompra){
        $this->idTicket = $idTicket;
        $this->empleado = $empleado;
        $this->cliente = $cliente;
        $this->fechaCreacion = $fechaCreacion;
        $this->totalVenta = $totalVenta;
        $this->num_ticket = $num_ticket;
        $this->BolsaCompra = $BolsaCompra;
    }

    /*********************************  GETTERS y SETTERS *******************************/
    /************************************************************************************/

    public function getIdTicket(){
        return $this->idTicket;
    }
    public function getEmpleado(){
        return $this->empleado;
    }
    public function getCliente(){
        return $this->cliente;
    }
    public function getFechaCreacion(){
        return $this->fechaCreacion;
    }
    public function getTotalVenta(){
        return $this->totalVenta;
    }
    public function getBolsaCompra(){
        return $this->BolsaCompra;
    }

    /*********************************  METODOS *****************************************/
    /************************************************************************************/

    public static function getTickets(): array
    {
        $conn = BD::FloresNuria();
        $stmt = $conn->prepare("SELECT * FROM venta");
        $stmt->execute();
        $tickets = array();
        while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
            $bolsa_compra = BolsaCompra::getBolsaCompraByIdTicket($row->id_venta);
            $tickets[] = new Ticket(
                $row->id_venta,
                $row->id_empleado,
                $row->id_cliente,
                $row->fecha,
                $row->precio,
                $row->num_ticket,
                $bolsa_compra
            );
        }
        return $tickets;
    }

    public function IngresarTicket(){
        $conn = BD::FloresNuria();
        try {
            $stmt = $conn->prepare("INSERT INTO venta(precio, fecha, num_venta, id_cliente, id_empleado) VALUES (:precio, :fecha, :num_venta, :id_cliente, :id_empleado)");
            $stmt->bindParam(":precio", $this->totalVenta);
            $stmt->bindParam(":fecha", $this->fechaCreacion);
            $stmt->bindParam(":num_venta", $this->num_ticket);
            $stmt->bindParam(":id_cliente", $this->cliente);
            $stmt->bindParam(":id_empleado", $this->empleado);
            $stmt->execute();
            $this->BolsaCompra->IngresarVentaProductos($this);
            return $stmt->rowCount() > 0;
        }catch (Exception $e){
            throw new Exception($e);
        }
    }

    public function ActualizarTicket(): bool{
        $conn = BD::FloresNuria();
        try {
            if ($this->BolsaCompra->IngresarVentaProductos($this)) {
                $stmt = $conn->prepare("UPDATE venta SET precio = :precio, fecha = :fecha, num_venta = :num_venta, id_cliente = :id_cliente WHERE id_venta = :id_venta");
                $stmt->bindParam(":precio", $this->totalVenta);
                $stmt->bindParam(":fecha", $this->fechaCreacion);
                $stmt->bindParam(":num_venta", $this->num_ticket);
                $stmt->bindParam(":id_cliente", $this->cliente);
                $stmt->bindParam(":id_venta", $this->idTicket);
                $stmt->execute();
                return $stmt->rowCount() > 0;
            } else{
                return false;
            }
        } catch (Exception $e){
            throw new Exception($e);
        }
    }

    public function EliminarTicket(): bool{
        $conn = BD::FloresNuria();
        $stmt = $conn->prepare("DELETE FROM venta_producto WHERE id_venta = :id_venta");
        $stmt->bindParam(":id_venta", $this->idTicket);
        $stmt->execute();
        $stmt = $conn->prepare("DELETE FROM venta WHERE id_venta = :id_venta");
        $stmt->bindParam(":id_venta", $this->idTicket);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function api_info(): string{
        $std = new stdClass();
        $std->idTicket = $this->idTicket;
        $std->empleado = $this->empleado;
        $std->cliente = $this->cliente;
        $std->fechaCreacion = $this->fechaCreacion;
        $std->totalVenta = $this->totalVenta;
        $std->num_ticket = $this->num_ticket;
        $std->BolsaCompra = $this->BolsaCompra;
        return json_encode($std);

    }

    public static function api_getAllTickets(): string{
        $tickets = Ticket::getTickets();
        $json = array();
        foreach ($tickets as $ticket) {
            $json[] = $ticket->api_info();
        }
        return json_encode($json);
    }
}