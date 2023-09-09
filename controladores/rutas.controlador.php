<?php
include 'modelos/rutas.modelo.php';


class ControladorRutas
{
    /*==========================================
    Mostrar Roles de Usuario
    ==========================================*/
    static public function ctrMostrarRutas()
    {
        $tabla = "rutas";

        $respuesta = ModeloRutas::mdlMostrarRutas($tabla);
        return $respuesta;
    }
}
