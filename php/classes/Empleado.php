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

    /*********************************  METODOS *****************************************/
    /************************************************************************************/

    public static function InicioSesion($correo, $password){
        $db = BD::FloresNuria();
        $stmt = $db->prepare("SELECT * FROM empleado WHERE correo = ?");
        $stmt->execute([$correo]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$usuario) {
            return null; // Usuario no encontrado
        }
        // Verificar contraseña hasheada
        if (password_verify($password, $usuario['password'])) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['empleado_id'] = $usuario['id_empleado'];
            $_SESSION['empleado_nombre'] = $usuario['nombre'];
            $_SESSION['empleado_correo'] = $usuario['correo'];
            $_SESSION['empleado_puesto'] = $usuario['puesto'];

            // Crear sesión con objeto Usuario
            return new Empleado(
                $usuario['id_empleado'],
                $usuario['nombre'],
                $usuario['puesto'],
                $usuario['telefono'],
                $usuario['correo']
            );
        } else {
            return null; // Contraseña incorrecta
        }
    }

    public static function checkSession(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['empleado_id']);
    }

    public static function logout(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        unset($_SESSION['empleado_id']);
        unset($_SESSION['empleado_nombre']);
        unset($_SESSION['empleado_correo']);
        unset($_SESSION['empleado_puesto']);
        session_destroy();
    }
}