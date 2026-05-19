<?php
namespace Floristeria;
class Cliente
{
    private $idCliente;
    private $nombre;
    private $telefono;
    private $correo;
    public function __construct($idCliente, $nombre, $telefono, $correo){
        $this->idCliente = $idCliente;
        $this->nombre = $nombre;
        $this->telefono = $telefono;
        $this->correo = $correo;
    }

    /*********************************  GETTERS y SETTERS *******************************/
    /************************************************************************************/

    public function getIdCliente(){
        return $this->idCliente;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getTelefono(){
        return $this->telefono;
    }
    public function getCorreo(){
        return $this->correo;
    }
}