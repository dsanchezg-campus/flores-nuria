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
            $bolsa_compra->addProducto($row->id_producto);
        }
        return $bolsa_compra;
    }

    public function addProducto($id_producto){
        $this->productos[] = $id_producto;
    }
}