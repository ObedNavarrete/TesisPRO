<?php
include 'modelos/xLoteria.modelo.php';


class ControladorLoteria
{
    static public function ctrMostrarTotalVentasInicio($item, $valor)
    {
        $tabla1 = "ventas_loteria";
        $tabla3 = "usuarios";

        $respuesta = ModeloLoteria::mdlMostrarTotalVentasInicio($tabla1, $tabla3, $item, $valor);
        return $respuesta;
    }
}
