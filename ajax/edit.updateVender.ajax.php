<?php
require_once "../controladores/vender.controlador.php";
require_once "../modelos/vender.modelo.php";

class AjaxL
{
    public $idNume;
    public function ajaxVerPremioGanador()
    {
        $respuesta = ControladorVentas::ctrMostrarVentasGanador("idNumero", $this->idNume);
        echo json_decode($respuesta);
    }

    public $idNumero;
    public function ajaxMostrarVentasAlVender()
    {
        $item = "idNumero";
        $valor = $this->idNumero;

        //$respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
        $respuesta = ControladorVentas::ctrMostrarVentasAlVender("idNumero", $valor);
        echo json_encode($respuesta);
    }

    public $idEliminar;
    public function ajaxEliminarVenta()
    {
        $respuesta = ControladorVentas::ctrEliminarVentas($this->idEliminar);
        // Tambien podria ser $respuesta = ControladorUsuarios::ctrMostrarUsuarios("id, $this->idUsuario);
        echo $respuesta;
    }

    public $idVer;
    public function ajaxVerRecibo()
    {
        $respuesta = ControladorVentas::ctrMostrarRecibo("codigo", $this->idVer);
        echo $respuesta;
    }

    public $idNoVenta;
    public function ajaxVerNoVenta()
    {
        $respuesta = ControladorVentas::ctrMostrarVentasNoDetalle("idNumero", $this->idNoVenta);
        echo json_encode($respuesta);
    }
}

// Preguntando si se hace click con el valor idGanador
if (isset($_POST["idNume"])) {
    $idNume = new AjaxL();
    $idNume->idNume = $_POST["idNume"];
    $idNume->ajaxVerPremioGanador();
}

// Preguntando si se hace click con el valor idNumero
if (isset($_POST["idNumero"])) {
    $mostrar = new AjaxL();
    $mostrar->idNumero = $_POST["idNumero"];
    $mostrar->ajaxMostrarVentasAlVender();
}

// Preguntando si se hace click con el valor idEliminar
if (isset($_POST["idEliminar"])) {
    $eliminar = new AjaxL();
    $eliminar->idEliminar = $_POST["idEliminar"];
    $eliminar->ajaxEliminarVenta();
}

// Preguntando si se hace click con el valor idVer
if (isset($_POST["idVer"])) {
    $ver = new AjaxL();
    $ver->idVer = $_POST["idVer"];
    $ver->ajaxVerRecibo();
}

// Preguntando si se hace click con el valor idVer
if (isset($_POST["idNoVenta"])) {
    $ver = new AjaxL();
    $ver->idNoVenta = $_POST["idNoVenta"];
    $ver->ajaxVerNoVenta();
}