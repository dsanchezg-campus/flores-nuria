<?php

class Pedido
{
    private $idPedido;
    private $estado;
    private $fecha;
    private $productos;
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
    public function __construct($idPedido,$estado, $productos, $fecha,$totalPedido,$idProveedor){
        $this->idPedido = $idPedido;
        $this->estado = $estado;
        $this->productos = [$productos[0], $productos[1]];
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
    public function getProductos(){
        return $this->productos;
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
            $pedidos[] = new Pedido(
                $row->id_pedido,
                $row->estado,
                [$row->id_producto, $row->cantidad],
                $row->fechaPedido,
                $row->total_pedido,
                $row->id_proveedor
            );
        }
    }

}