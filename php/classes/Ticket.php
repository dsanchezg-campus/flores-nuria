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
                $row->fechaCreacion,
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
            $id_venta = $conn->lastInsertId();
            foreach ($this->BolsaCompra as $bolsa) {
                $stmt = $conn->prepare("INSERT INTO venta_producto(id_venta, id_producto, cantidad) VALUES (:id_venta, :id_producto, :cantidad)");
                $stmt->bindParam(":id_venta", $id_venta);
                $stmt->bindParam(":id_producto", $bolsa[0]);
                $stmt->bindParam(":cantidad", $bolsa[1]);
                $stmt->execute();
            }
            return $stmt->rowCount() > 0;
        }catch (Exception $e){
            throw new Exception($e);
        }
    }

    public function ActualizarTicket(){
        $conn = BD::FloresNuria();
        $stmt = $conn->prepare("UPDATE venta");

    }
}