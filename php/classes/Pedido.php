<?php

class Pedido
{
    private $idPedido;
    private $estado;
    private $fechaCreacion;
    private $productos;
    private $totalPedido;
    private $idProveedor;
    public function __construct($idPedido,$estado,$fechaCreacion,$totalPedido,$idProveedor){
        $this->idPedido = $idPedido;
        $this->estado = $estado;
        $this->fechaCreacion = $fechaCreacion;
        $this->totalPedido = $totalPedido;
        $this->idProveedor = $idProveedor;
    }

    /*********************************  GETTERS y SETTERS *******************************/
    /************************************************************************************/

    public function getIdPedido(){
        return $this->idPedido;
    }
    public function getEstado(){
        return $this->estado;
    }
    public function getFechaCreacion(){
        return $this->fechaCreacion;
    }
    public function getProductos(){
        return $this->productos;
    }
    public function getTotalPedido(){
        return $this->totalPedido;
    }
    public function getIdProveedor(){
        return $this->idProveedor;
    }


}