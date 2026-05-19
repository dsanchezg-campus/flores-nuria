<?php
namespace Floristeria;
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

}
