<?php

class Producto
{
    private $idProducto;
    private $nombre;
    private $precio;
    private $stock;
    private $oferta;
    public function __construct($idProducto, $nombre, $precio, $stock, $oferta){
        $this->idProducto = $idProducto;
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->stock = $stock;
        if ($oferta) {
            $this->oferta = $oferta;
        } else {
            $this->oferta = 0;
        }
    }

    /*********************************  GETTERS y SETTERS *******************************/
    /************************************************************************************/

    public function getIdProducto(){
        return $this->idProducto;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getPrecio(){
        return $this->precio;
    }
    public function getStock(){
        return $this->stock;
    }
    public function getOferta(){
        return $this->oferta;
    }


}