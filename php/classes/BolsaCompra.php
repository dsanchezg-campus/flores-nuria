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

    public static function getBolsaCompraByIdPedido($idPedido): BolsaCompra{
        $conn = BD::FloresNuria();
        $stmt = $conn->prepare("SELECT * FROM pedido_producto WHERE id_pedido = ?");
        $stmt->execute([$idPedido]);
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

    public function IngresarPedidoProductos($pedido){
        $conn = BD::FloresNuria();
        foreach ($this->productos as $producto){
            $stmt = $conn->prepare("SELECT id_producto FROM pedido_producto WHERE id_producto = :id_producto AND id_pedido = :id_pedido");
            $stmt->bindParam(":id_producto", $producto[0]);
            $stmt->bindParam(":id_pedido", $pedido->getIdPedido());
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $stmt = $conn->prepare("UPDATE pedido_producto SET cantidad = :cantidad WHERE id_producto = :id_producto AND id_pedido = :id_pedido");
                $stmt->bindParam(":id_producto", $producto->getIdProducto());
                $stmt->bindParam(":cantidad", $producto->getCantidad());
                $stmt->bindParam(":id_pedido", $pedido->getIdPedido());
                $stmt->execute();
            } else{
                $stmt = $conn->prepare("INSERT INTO pedido_producto(id_producto, id_pedido, cantidad) VALUES(:id_pedido, :id_producto, :cantidad)");
                $stmt->bindParam(":id_pedido", $pedido->getIdPedido());
                $stmt->bindParam(":id_producto", $producto->getIdProducto());
                $stmt->bindParam(":cantidad", $producto->getCantidad());
                $stmt->execute();
            }
        }
        return $stmt->rowCount() > 0;
    }

    public function IngresarVentaProductos($venta){
        $conn = BD::FloresNuria();
        foreach ($this->productos as $producto) {
            $stmt = $conn->prepare("SELECT id_producto FROM venta_producto WHERE id_producto = :id_producto AND id_pedido = :id_venta");
            $stmt->bindParam(":id_producto", $producto[0]);
            $stmt->bindParam(":id_pedido", $venta->getIdVenta());
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $stmt = $conn->prepare("UPDATE venta_producto SET cantidad = :cantidad WHERE id_venta = :id_venta
                AND id_producto = :id_producto");
                $stmt->bindParam(":id_venta", $venta->getIdVenta());
                $stmt->bindParam(":id_producto", $producto[0]);
                $stmt->bindParam(":cantidad", $producto[1]);
                $stmt->execute();
            } else{
                $stmt = $conn->prepare("INSERT INTO venta_producto(id_venta, id_producto, cantidad) VALUES (:id_venta, :id_producto, :cantidad)");
                $stmt->bindParam(":id_venta", $venta->getIdVenta());
                $stmt->bindParam(":id_producto", $producto[0]);
                $stmt->bindParam(":cantidad", $producto[1]);
                $stmt->execute();
            }
        }


    }
}