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

    public static function getickets(): array
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
}