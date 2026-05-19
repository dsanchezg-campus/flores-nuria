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

    /*********************************  METODOS *****************************************/
    /************************************************************************************/

    public static function getProductos(){
        $conn = BD::FloresNuria();
        $stmt = $conn->prepare("SELECT * FROM producto");
        $stmt->execute();
        $productos = array();
        while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
            $oferta = Oferta::getOfertaByIdProducto($row->id_producto);
            $productos = new Producto(
                $row->idProducto,
                $row->nombre,
                $row->precio,
                $row->stock,
                $oferta
            );
        }
        return $productos;
    }

    public static function getProductoById($idProducto){
        $conn = BD::FloresNuria();
        $stmt = $conn->prepare("SELECT * FROM producto WHERE id_producto = ?");
        $stmt->execute(array($idProducto));
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        $oferta = Oferta::getOfertaByIdProducto($row->id_producto);
        return new Producto(
            $row->idProducto,
            $row->nombre,
            $row->precio,
            $row->stock,
            $oferta
        );
    }

    public function ActualizarProducto(): bool{
        $conn = BD::FloresNuria();
        $stmt = $conn->prepare("UPDATE producto SET nombre = :nombre, precioBase = :precio, stock = :stock WHERE idProducto = :idProducto");
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":precio", $this->precio);
        $stmt->bindParam(":stock", $this->stock);
        $stmt->bindParam(":idProducto", $this->idProducto);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function IngresarProducto(): bool{
        $conn = BD::FloresNuria();
        $stmt = $conn->prepare("INSERT INTO producto(nombre, precioBase, stock) VALUES (:nombre, :precio, :stock)");
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":precio", $this->precio);
        $stmt->bindParam(":stock", $this->stock);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function EliminarProducto(): bool{
        $conn = BD::FloresNuria();
        $stmt = $conn->prepare("DELETE FROM producto WHERE idProducto = :idProducto");
        $stmt->bindParam(":idProducto", $this->idProducto);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

}