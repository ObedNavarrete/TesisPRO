<?php
include 'modelos/roles.modelo.php';


Class ControladorRoles{
    /*==========================================
    Mostrar Roles de Usuario
    ==========================================*/
    static public function ctrMostrarRoles(){
        $tabla = "roles";
    
        $respuesta = ModeloRol::mdlMostrarRoles($tabla);
        return $respuesta;
    }
}