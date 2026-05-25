<?php

class Planta extends Producto
{
    private $frecuencia_riego;
    private $es_exterior;
    private $sustrato;

    public function __construct($idProducto, $nombre, $precio, $stock, $oferta, $iva, $frecuencia_riego, $es_exterior, $sustrato){
        parent::__construct($idProducto, $nombre, $precio, $stock, $oferta, $iva);
        $this->frecuencia_riego = $frecuencia_riego;
        $this->es_exterior = $es_exterior;
        $this->sustrato = $sustrato;
    }
}