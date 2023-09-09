<?php
include 'modelos/historia.modelo.php';


Class ControladorHistoria{
    /*==========================================
    Mostrar Roles de Usuario
    ==========================================*/
    static public function ctrMostrarHistoria($item, $valor){
        $tabla1 = "ventas";
        $tabla2 = "usuarios";
        $tabla3 = "ventas_loteria";
    
        $respuesta = ModeloHistoria::mdlMostrarHistoria($tabla1, $tabla2, $tabla3, $item, $valor);
        return $respuesta;
    }
}