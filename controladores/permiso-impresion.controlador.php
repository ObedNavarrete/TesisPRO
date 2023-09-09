<?php

class ControladorPermisoImpresion
{
    static public function ctrMostrarUsuariosImprimen()
    {
        $respuesta = ModeloPermisoImpresion::mdlMostrarUsuariosImprimen();

        return $respuesta; //Para devolver la informacion de nuevo a tablaUsuarios.ajax
    }
}
