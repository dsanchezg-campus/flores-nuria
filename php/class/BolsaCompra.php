<?php
namespace Floristeria;
class BolsaCompra
{
    private $productos;
    public function __construct($producto){
        $this->productos = array();
        $this->productos[] = $producto;
    }

    /*********************************  GETTERS y SETTERS *******************************/
    /************************************************************************************/

     public function getProductos(){
        return $this->productos;
    }
}