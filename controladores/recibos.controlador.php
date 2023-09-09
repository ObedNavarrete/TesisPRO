<?php
include '/public_html/modelos/recibos.modelo.php';


Class ControladorRecibos{

    static public function ctrMostrarVentasVendedor($item, $valor)
    {
        $tabla1 = 'ventas';
        $tabla2 = 'usuarios';
        $tabla3 = 'sorteos';

        $respuesta = ModeloRecibos::mdlMostrarVentasVendedor($tabla1, $tabla2, $tabla3, $item, $valor);

        return $respuesta; //Para devolver la informacion de nuevo a tablaUsuarios.ajax
    }

    static public function ctrMostrarVentasSupervisor()
    {
        $tabla1 = 'ventas';
        $tabla2 = 'usuarios';
        $tabla3 = 'sorteos';

        $respuesta = ModeloRecibos::mdlMostrarVentasSupervisor($tabla1, $tabla2, $tabla3);

        return $respuesta; //Para devolver la informacion de nuevo a tablaUsuarios.ajax
    }

    static public function ctrMostrarVentasAdministrador()
    {
        $tabla1 = 'ventas';
        $tabla2 = 'usuarios';
        $tabla3 = 'sorteos';

        $respuesta = ModeloRecibos::mdlMostrarVentasAdministrador($tabla1, $tabla2, $tabla3);

        return $respuesta; //Para devolver la informacion de nuevo a tablaUsuarios.ajax
    }

    static public function ctrMostrarVentasSorteoAnterior($item, $valor)
    {
        $tabla1 = 'ventas';
        $tabla2 = 'ganadores';
        $tabla3 = 'usuarios';

        $respuesta = ModeloRecibos::mdlMostrarVentasSorteoAnterior($tabla1, $tabla2, $tabla3, $item, $valor);

        return $respuesta; //Para devolver la informacion de nuevo a tablaUsuarios.ajax
    }

    static public function ctrMostrarREC($valor)
    {

        $respuesta = ModeloRecibos::mdlMostrarREC($valor);

        return $respuesta; //Para devolver la informacion de nuevo a tablaUsuarios.ajax
    }

}