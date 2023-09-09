<?php
include '/home/customer/www/rifadiaz.net/modelos/xRecibos.modelo.php';


class ControladorRecibosLoteria
{

    static public function ctrMostrarVentasVendedor($item, $valor)
    {
        $tabla1 = 'ventas_loteria';
        $tabla2 = 'usuarios';

        $respuesta = ModeloRecibosLoteria::mdlMostrarVentasVendedor($tabla1, $tabla2, $item, $valor);

        return $respuesta; //Para devolver la informacion de nuevo a tablaUsuarios.ajax
    }

    static public function ctrMostrarVentasSupervisor()
    {
        $tabla1 = 'ventas_loteria';
        $tabla2 = 'usuarios';

        $respuesta = ModeloRecibosLoteria::mdlMostrarVentasSupervisor($tabla1, $tabla2);

        return $respuesta; //Para devolver la informacion de nuevo a tablaUsuarios.ajax
    }

    static public function ctrMostrarVentasAdministrador()
    {
        $tabla1 = 'ventas_loteria';
        $tabla2 = 'usuarios';

        $respuesta = ModeloRecibosLoteria::mdlMostrarVentasAdministrador($tabla1, $tabla2);

        return $respuesta; //Para devolver la informacion de nuevo a tablaUsuarios.ajax
    }

    static public function ctrMostrarRECLoteria($valor)
    {

        $respuesta = ModeloRecibosLoteria::mdlMostrarRECLoteria($valor);

        return $respuesta; //Para devolver la informacion de nuevo a tablaUsuarios.ajax
    }
}
