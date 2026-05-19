<?php

class Pedido
{
    private $idPedido;
    private $estado;
    private $fecha;
    private $bolsaCompra;
    private $totalPedido;
    private $idProveedor;

    /**
     * @param $idPedido int
     * @param $estado string
     * @param $productos array 0-> id del producto, 1-> cantidad del producto
     * @param $fecha string Fecha del pedido
     * @param $totalPedido float Coste total del pedido, 2 decimales
     * @param $idProveedor int
     */
    public function __construct($idPedido, $estado, $bolsa_compra, $fecha,$totalPedido,$idProveedor){
        $this->idPedido = $idPedido;
        $this->estado = $estado;
        $this->bolsaCompra = $bolsa_compra;
        $this->fecha = $fecha;
        $this->totalPedido = $totalPedido;
        $this->idProveedor = $idProveedor;
    }

    /*********************************  GETTERS y SETTERS *******************************/
    /************************************************************************************/

    public function getIdPedido(){
        return $this->idPedido;
    }
    public function getEstado(){
        return $this->estado;
    }
    public function getFechaCreacion(){
        return $this->fechaCreacion;
    }
    public function getBolsaCompra(){
        return $this->bolsaCompra;
    }
    public function getTotalPedido(){
        return $this->totalPedido;
    }
    public function getIdProveedor(){
        return $this->idProveedor;
    }

    /*********************************  METODOS *****************************************/
    /************************************************************************************/

    public static function getPedidos(){
        $conn = BD::FloresNuria();
        $stmt = $conn->prepare("SELECT p.*, pp.id_producto, pp.cantidad 
            FROM pedidos p 
            INNER JOIN pedido_producto pp ON p.id_pedido = pp.id_pedido");
        $stmt->execute();
        $pedidos = array();
        while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
            $bolsa_compra = BolsaCompra::getBolsaCompraByIdPedido($row->id_pedido);
            $pedidos[] = new Pedido(
                $row->id_pedido,
                $row->estado,
                $bolsa_compra,
                $row->fechaPedido,
                $row->total_pedido,
                $row->id_proveedor
            );
        }
        return $pedidos;
    }

    public function IngresarPedido(){
        $conn = BD::FloresNuria();
        $stmt  = $conn->prepare("INSERT INTO pedidos (fecha, estado, id_proveedor) VALUES (:fecha, :estado, :id_proveedor)");
        $stmt->bindParam(":estado", $this->estado);
        $stmt->bindParam(":fecha", $this->fecha);
        $stmt->bindParam(":id_proveedor", $this->idProveedor);
        $stmt->execute();
        $pedido = $conn->lastInsertId();
        $this->bolsaCompra->IngresarPedidoProductos($this);
        return $stmt->rowCount() > 0;
    }

    public function EliminarPedido(){
        $conn = BD::FloresNuria();
        $stmt = $conn->prepare("DELETE FROM pedidos AND pedido_productos WHERE id_pedido = :id_pedido");
        $stmt->bindParam(":id_pedido", $this->idPedido);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function ModificarEstado(){
        $conn = BD::FloresNuria();
        $stmt = $conn->prepare("UPDATE pedidos SET estado = :estado WHERE id_pedido = :id");
        $stmt->bindParam(":estado", $this->estado);
        $stmt->bindParam(":id", $this->idPedido);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function ActualizarPedido(){
        $conn = BD::FloresNuria();
        $stmt = $conn->prepare("UPDATE pedidos SET fecha = :fecha, estado = :estado, id_proveedor = :id_proveedor WHERE id_pedido = :id");
        $stmt->bindParam(":estado", $this->estado);
        $stmt->bindParam(":fecha", $this->fecha);
        $stmt->bindParam(":id_proveedor", $this->idProveedor);
        $stmt->bindParam(":id", $this->idPedido);
        $stmt->execute();
        $this->bolsaCompra->IngresarPedidoProductos($this);
        return $stmt->rowCount() > 0;
    }

}