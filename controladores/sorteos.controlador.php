<?php
include 'modelos/sorteos.modelo.php';


class ControladorSorteos
{
    static public function ctrMostrarSorteos()
    {
        $tabla = "sorteos";

        $respuesta = ModeloSorteos::mdlMostrarSorteos($tabla);
        return $respuesta;
    }

    static public function ctrMostrarSorteoActual()
    {
        $respuesta = ModeloSorteos::mdlMostrarSorteoActual();
        return $respuesta;
    }

}
