<?php

class Proveedor
{
    private $idProveedor;
    private $nombre;
    private $direccion;
    private $telefono;
    private $correo;
    public function __construct($idProveedor, $nombre, $direccion, $telefono, $correo){
        $this->idProveedor = $idProveedor;
        $this->nombre = $nombre;
        $this->direccion = $direccion;
        $this->telefono = $telefono;
        $this->correo = $correo;
    }

    /*********************************  GETTERS y SETTERS *******************************/
    /************************************************************************************/

    public function getIdProveedor(){
        return $this->idProveedor;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getDireccion(){
        return $this->direccion;
    }
    public function getTelefono(){
        return $this->telefono;
    }
    public function getCorreo(){
        return $this->correo;
    }

    /*********************************  METODOS *****************************************/
    /************************************************************************************/

    public static function getProveedores(): array {
        $conn = BD::FloresNuria();
        $conn = $conn->query("SELECT * FROM proveedor");
        $proveedores = array();
        while ($fila = $conn->fetch(PDO::FETCH_OBJ)) {
            $proveedores[] = new Proveedor(
                $fila->id_proveedor ?? 0,
                $fila->nombre ?? '',
                $fila->direccion ?? '',
                $fila->telefono ?? '',
                $fila->correo ?? ''
            );
        }
        return $proveedores;
    }

    public static function buscarProveedores($busqueda): array {
        $conn = BD::FloresNuria();
        $stmt = $conn->prepare("SELECT * FROM proveedor WHERE nombre ILIKE ?");
        $stmt->execute(["%" . $busqueda . "%"]);
        $proveedores = array();
        while ($fila = $stmt->fetch(PDO::FETCH_OBJ)) {
            $proveedores[] = new Proveedor(
                $fila->id_proveedor ?? 0,
                $fila->nombre ?? '',
                $fila->direccion ?? '',
                $fila->telefono ?? '',
                $fila->correo ?? ''
            );
        }
        return $proveedores;
    }

    public function IngresarProveedor(){
        $conn = BD::FloresNuria();
        $stmt = $conn->prepare("INSERT INTO proveedor(nombre, direccion, telefono, correo) VALUES (:nombre, :direccion, :telefono, :correo)");
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":direccion", $this->direccion);
        $stmt->bindParam(":telefono", $this->telefono);
        $stmt->bindParam(":correo", $this->correo);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function EliminarProveedor(){
        $conn = BD::FloresNuria();
        $stmt = $conn->prepare("DELETE FROM proveedor WHERE id_proveedor = :id_proveedor");
        $stmt->bindParam(":id_proveedor", $this->idProveedor);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function ActualizarProveedor(){
        $conn = BD::FloresNuria();
        $stmt = $conn->prepare("UPDATE proveedor SET nombre = :nombre, direccion = :direccion, telefono = :telefono, correo = :correo WHERE id_proveedor = :id_proveedor");
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":direccion", $this->direccion);
        $stmt->bindParam(":telefono", $this->telefono);
        $stmt->bindParam(":correo", $this->correo);
        $stmt->bindParam(":id_proveedor", $this->idProveedor);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}
