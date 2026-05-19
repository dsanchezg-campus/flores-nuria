<?php

class Oferta
{
    private $idOferta;
    private $nombre;
    private $descuento;
    private $fechaCreacion;
    private $fechaActualizacion;
    private $fechaFin;
    private $idProducto;

    public function __construct($idOferta, $nombre, $descuento, $fechaCreacion, $fechaActualizacion, $fechaFin, $idProducto)
    {
        $this->idOferta = $idOferta;
        $this->nombre = $nombre;
        $this->descuento = $descuento;
        $this->fechaCreacion = $fechaCreacion;
        $this->fechaActualizacion = $fechaActualizacion;
        $this->fechaFin = $fechaFin;
        $this->idProducto = $idProducto;
    }

    /*********************************  GETTERS y SETTERS *******************************/
    /************************************************************************************/

    public function getIdOferta(){
        return $this->idOferta;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getDescuento(){
        return $this->descuento;
    }
    public function getFechaCreacion(){
        return $this->fechaCreacion;
    }
    public function getFechaActualizacion(){
        return $this->fechaActualizacion;
    }
    public function getFechaFin(){
        return $this->fechaFin;
    }
    public function getIdProducto(){
        return $this->idProducto;
    }

    /********************************** METODOS *****************************************/
    /************************************************************************************/

    public static function getOfertaByIdProducto($idProducto): array{
        $conn = BD::FloresNuria();
        $stmt = $conn->prepare("SELECT * FROM oferta WHERE idProducto = ?");
        $stmt->execute([$idProducto]);
        $ofertas = array();
        while ($row = $stmt->fetch()) {
            $ofertas[] = new Oferta(
                $row->id_oferta,
                $row->nombre,
                $row->descuento,
                $row->fecha_creacion,
                $row->fecha_actualizacion,
                $row->fechaFin,
                $row->id_producto
            );
        }
        return $ofertas;
    }
}