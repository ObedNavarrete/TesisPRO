<?php
require_once "../controladores/xVender.controlador.php";
require_once "../modelos/xVender.modelo.php";

class AjaxLoteria
{
    public $idNume;
    public function ajaxVerPremioGanador()
    {
        $respuesta = ControladorVentasLoteria::ctrMostrarVentasGanador("idNumero", $this->idNume);
        echo json_decode($respuesta);
    }

    public $idNumero;
    public function ajaxMostrarVentasAlVender()
    {
        $item = "idNumero";
        $valor = $this->idNumero;
        $respuesta = ControladorVentasLoteria::ctrMostrarVentasAlVender("v.idNumero", $valor);
        echo json_encode($respuesta);
    }

    public $idEliminar;
    public function ajaxEliminarVenta()
    {
        $respuesta = ControladorVentasLoteria::ctrEliminarVentas($this->idEliminar);
        echo $respuesta;
    }

    public $idVer;
    public function ajaxVerRecibo()
    {
        $respuesta = ControladorVentasLoteria::ctrMostrarRecibo("codigo", $this->idVer);
        echo $respuesta;
    }

    public $idNoVenta;
    public function ajaxVerNoVenta()
    {
        $respuesta = ControladorVentasLoteria::ctrMostrarVentasNoDetalle("idNumero", $this->idNoVenta);
        echo json_encode($respuesta);
    }
}

if (isset($_POST["idNume"])) {
    $idNume = new AjaxLoteria();
    $idNume->idNume = $_POST["idNume"];
    $idNume->ajaxVerPremioGanador();
}

if (isset($_POST["idNumero"])) {
    $mostrar = new AjaxLoteria();
    $mostrar->idNumero = $_POST["idNumero"];
    $mostrar->ajaxMostrarVentasAlVender();
}

if (isset($_POST["idEliminar"])) {
    $eliminar = new AjaxLoteria();
    $eliminar->idEliminar = $_POST["idEliminar"];
    $eliminar->ajaxEliminarVenta();
}

if (isset($_POST["idVer"])) {
    $ver = new AjaxLoteria();
    $ver->idVer = $_POST["idVer"];
    $ver->ajaxVerRecibo();
}

if (isset($_POST["idNoVenta"])) {
    $ver = new AjaxLoteria();
    $ver->idNoVenta = $_POST["idNoVenta"];
    $ver->ajaxVerNoVenta();
}
