<?php

class Accesorios extends Producto
{
    private $tamano;
    private $material;

    public function __construct($idProducto, $nombre, $precio, $stock, $oferta, $iva, $tamano, $material)
    {
        parent::__construct($idProducto, $nombre, $precio, $stock, $oferta, $iva);
        $this->tamano = $tamano;
        $this->material = $material;
    }
}