<?php
require_once "../controladores/listas.controlador.php";
require_once "../modelos/listas.modelo.php";


class AjaxListas
{
    public $vende;
    public $fecha;
    public $idsorteo;
    public function ajaxMostrarListas()
    {
        $vende = $this->vende;
        $fecha = $this->fecha;
        $idsorteo = $this->idsorteo;

        //$respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
        $respuesta = ControladorListas::ctrMostrarListasDetalle($vende, $fecha, $idsorteo);
        echo json_encode($respuesta);
    }
}

// Preguntando si se hace click con el valor idNumero
if (isset($_POST["vende"])) {
    $listas = new AjaxListas();
    $listas->vende = $_POST["vende"];
    $listas->fecha = $_POST["fecha"];
    $listas->idsorteo = $_POST["idsorteo"];
    $listas->ajaxMostrarListas();
}
