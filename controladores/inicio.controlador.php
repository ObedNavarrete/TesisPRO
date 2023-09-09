<?php
include 'modelos/inicio.modelo.php';


class ControladorInicio
{
    static public function ctrMostrarTotalVentasInicio($item, $valor)
    {
        $tabla1 = "ventas";
        $tabla2 = "sorteos";
        $tabla3 = "usuarios";

        $respuesta = ModeloInicio::mdlMostrarTotalVentasInicio($tabla1, $tabla2, $tabla3, $item, $valor);
        return $respuesta;
    }

    static public function ctrMostrarMaximoVendedor($item, $valor)
    {
        $tabla1 = "recibos";
        $tabla2 = "usuarios";
        $tabla3 = "sorteos";

        $respuesta = ModeloInicio::mdlMostrarMaximoVendedor($tabla1, $tabla2, $tabla3, $item, $valor);
        return $respuesta;
    }

    static public function ctrMostrarConteoUsuario($item, $valor)
    {
        $tabla = "usuarios";

        $respuesta = ModeloInicio::mdlMostrarConteoUsuarios($tabla, $item, $valor);
        return $respuesta;
    }
}
