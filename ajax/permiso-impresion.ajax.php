<?php
require_once "../controladores/permiso-impresion.controlador.php";
require_once "../modelos/permiso-impresion.modelo.php";

class AjaxPermisos
{

    /*ACTIVANDO NUMERO */
    public $user;
    public $estado;
    public function ajaxPermiteImprimir()
    {
        $valor1 = $this->user;
        $valor2 = $this->estado;

        $respuesta = ModeloPermisoImpresion::mdlActualizarPermiso($valor1,$valor2);
    }
}

if (isset($_POST["user"])) {

    $imprime = new AjaxPermisos();
    $imprime->user = $_POST["user"];
    $imprime->estado = $_POST["estado"];
    $imprime->ajaxPermiteImprimir();
}
