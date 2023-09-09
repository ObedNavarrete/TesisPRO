<?php
class ControladorVentasFecha
{
    static public function ctrMostrarVentaVendedores()
    {
        $tabla1 = 'ventas';
        $tabla2 = 'usuarios';
        $respuesta = ModeloVentasFecha::mdlMostrarVentaVendedores($tabla1, $tabla2);

        return $respuesta; //Para devolver la informacion de nuevo a tablaUsuarios.ajax
    }

    static public function ctrMostrarVentasTotalesVendedorFechaXXX($fechaInicial, $fechaFinal)
    {
        $tabla1 = 'ventas';
        $tabla2 = 'usuarios';
        //$respuesta = ModeloVentasFecha::mdlMostrarVentasTotalesVendedorFecha($tabla1, $tabla2, $fechaInicial, $fechaFinal);

        //return $respuesta; //Para devolver la informacion de nuevo a tablaUsuarios.ajax
    }

    static public function ctrMostrarVentasTotalesVendedorFecha($fechaInicial, $fechaFinal)
    {
        $respuesta = ModeloVentasFecha::mdlMostrarVentasTotalesVendedorFecha($fechaInicial, $fechaFinal);

        return $respuesta; //Para devolver la informacion de nuevo a tablaUsuarios.ajax
    }

}
