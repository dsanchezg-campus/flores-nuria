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

    public function getProveedores($idProveedor): array {
        $conn = BD::FloresNuria();
        $conn = $conn->query("SELECT * FROM proveedor");
        $proveedores = array();
        while ($fila = $conn->fetch(PDO::FETCH_OBJ)) {
            $proveedores[] = new Proveedor(
                $fila["idProveedor"],
                $fila["nombre"],
                $fila["direccion"],
                $fila["telefono"],
                $fila["correo"]
            );
        }
        return $proveedores;
    }
}
