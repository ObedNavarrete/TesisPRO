<?php
require_once "../controladores/ganadores.controlador.php";
require_once "../modelos/ganadores.modelo.php";


class AjaxResumen
{
    public $idnumero;
    public $fecha;
    public $idsorteo;
    public function ajaxMostrarResumen()
    {
        $idnumero = $this->idnumero;
        $fecha = $this->fecha;
        $idsorteo = $this->idsorteo;

        //$respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
        $respuesta = ControladorGanadores::ctrMostrarResumen($idnumero, $fecha, $idsorteo);
        echo json_encode($respuesta);
    }
}

// Preguntando si se hace click con el valor idNumero
if (isset($_POST["idnumero"])) {
    $viendo = new AjaxResumen();
    $viendo->idnumero = $_POST["idnumero"];
    $viendo->fecha = $_POST["fecha"];
    $viendo->idsorteo = $_POST["idsorteo"];
    $viendo->ajaxMostrarResumen();
}
