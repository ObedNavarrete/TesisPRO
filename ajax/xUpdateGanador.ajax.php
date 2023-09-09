<?php
require_once "../controladores/xVender.controlador.php";
require_once "../modelos/xVender.modelo.php";


class AjaxGanador
{
    public $idNumero;
    public function ajaxMostrarVentasGanador()
    {
        $item = "idNumero";
        $valor = $this->idNumero;

        //$respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
        $respuesta = ControladorVentasLoteria::ctrMostrarVentasGanador("idNumero", $this->idNumero);
        echo json_encode($respuesta);
    }
}

// Preguntando si se hace click con el valor idNumero
if (isset($_POST["idNumero"])) {
    $mostrar = new AjaxGanador();
    $mostrar->idNumero = $_POST["idNumero"];
    $mostrar->ajaxMostrarVentasGanador();
}
