<?php
namespace Floristeria;
class Ticket
{
    private $idTicket;
    private $empleado;
    private $cliente;
    private $fechaCreacion;
    private $totalVenta;
    private $BolsaCompra;
    public function __construct($idTicket, $empleado, $cliente, $fechaCreacion, $totalVenta, $BolsaCompra){
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

}