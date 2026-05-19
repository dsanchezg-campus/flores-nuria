<?php

class Empleado{
    private $idEmpleado;
    private $nombre;
    private $puesto;
    private $telefono;
    private $correo;
    public function __construct($idEmpleado, $nombre, $puesto, $telefono, $correo){
        $this->idEmpleado = $idEmpleado;
        $this->nombre = $nombre;
        $this->puesto = $puesto;
        $this->telefono = $telefono;
        $this->correo = $correo;
    }

    /*********************************  GETTERS y SETTERS *******************************/
    /************************************************************************************/

    public function getIdEmpleado(){
        return $this->idEmpleado;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getPuesto(){
        return $this->puesto;
    }
    public function getTelefono(){
        return $this->telefono;
    }
    public function getCorreo(){
        return $this->correo;
    }

}