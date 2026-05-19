<?php

class BolsaCompra
{
    private $productos;
    public function __construct(){
        $this->productos = array();
    }

    /*********************************  GETTERS y SETTERS *******************************/
    /************************************************************************************/

    public function getProductos(){
        return $this->productos;
    }

    /*********************************  METODOS *****************************************/
    /************************************************************************************/

    public static function getBolsaCompraByIdTicket($idTicket): BolsaCompra{
        $conn = BD::FloresNuria();
        $stmt = $conn->prepare("SELECT * FROM venta_producto WHERE id_venta = ?");
        $stmt->execute([$idTicket]);
        $bolsa_compra = new BolsaCompra();
        while ($row = $stmt->fetch(PDO::FETCH_OBJ)){
            $bolsa_compra->addProducto($row->id_producto, $row->cantidad);
        }
        return $bolsa_compra;
    }

    public function addProducto($id_producto, $cantidad){
        if(($key = array_search($id_producto, $this->productos)) !== false){
            $this->productos[$key][1] += $cantidad;
        } else {
            $this->productos[] = [$id_producto, $cantidad];
        }

    }

    public function eliminarProducto($producto){
        if (($key = array_search($producto->getIdProducto(), $this->productos)) !== false) {
            unset($this->productos[$key]);
        }
    }
}