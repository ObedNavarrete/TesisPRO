<?php
require_once "../controladores/admin.ventas-limite.controlador.php";
require_once "../modelos/admin.ventas-limite.modelo.php";

class AjaxLimiteLoteria
{
    public $idNumero;
    public function ajaxMostrarLimiteAlVender()
    {

        $item = "idNumero";
        $valor = $this->idNumero;

        //$respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
        $respuesta = ControladorVentasLimite::ctrMostrarVentasLimiteAlVenderLoto();

        echo json_encode($respuesta);
    }
}

// Preguntando si se hace click con el valor idUsuario
if (isset($_POST["idNumero"])) {
    # code...
    $mostrar = new AjaxLimiteLoteria();
    $mostrar->idNumero = $_POST["idNumero"];
    $mostrar->ajaxMostrarLimiteAlVender();
}