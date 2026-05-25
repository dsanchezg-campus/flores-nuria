<?php

class Flor extends Producto
{
    private $color;
    private $especie;
    private $fecha_corte;

    public function __construct($idProducto, $nombre, $precio, $stock, $oferta, $iva, $color, $especie, $fecha_corte){
        parent::__construct($idProducto, $nombre, $precio, $stock, $oferta, $iva);
        $this->color = $color;
        $this->especie = $especie;
        $this->fecha_corte = $fecha_corte;
    }
}