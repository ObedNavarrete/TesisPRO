<?php
include '/home/customer/www/rifadiaz.net/public_html/modelos/listas.modelo.php';

class ControladorListas
{
    /*==========================================
    Mostrar Roles de Usuario
    ==========================================*/
    static public function ctrMostrarListas()
    {
        $respuesta = ModeloListas::mdlMostrarListas();
        return $respuesta;
    }

    static public function ctrMostrarListasDetalle($vende, $fecha, $idsorteo)
    {
        $respuesta = ModeloListas::mdlMostrarListasDetalle($vende, $fecha, $idsorteo);
        return $respuesta;
    }
}