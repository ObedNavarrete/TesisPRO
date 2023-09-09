<?php

class ControladorPermisoAcceso
{
    static public function ctrMostrarUsuariosAcceso()
    {
        $respuesta = ModeloPermisoAcceso::mdlMostrarUsuariosParaAcceso();

        return $respuesta; //Para devolver la informacion de nuevo a tablaUsuarios.ajax
    }
}
