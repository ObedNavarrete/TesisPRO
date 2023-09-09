<?php
require_once "../controladores/permiso-acceso.controlador.php";
require_once "../modelos/permiso-acceso.modelo.php";

class AjaxAcceso
{

    /*ACTIVANDO NUMERO */
    public $user;
    public $estado;
    public function ajaxPermiteAcceder()
    {
        $valor1 = $this->user;
        $valor2 = $this->estado;

        $respuesta = ModeloPermisoAcceso::mdlActualizarAcceso($valor1,$valor2);
    }
}

if (isset($_POST["user"])) {

    $imprime = new AjaxAcceso();
    $imprime->user = $_POST["user"];
    $imprime->estado = $_POST["estado"];
    $imprime->ajaxPermiteAcceder();
}
