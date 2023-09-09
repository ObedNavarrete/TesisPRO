<?php
require_once "../controladores/admin.ventas-limite.controlador.php";
require_once "../modelos/admin.ventas-limite.modelo.php";

class AjaxLimite
{
    //EDITAR USUARIOS
    public $idLimite;

    public function ajaxMostrarLimite()
    {
        $item = "id";
        $valor = $this->idLimite;

        //$respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
        $respuesta = ControladorVentasLimite::ctrMostrarVentasLimite("id", $valor);

        echo json_encode($respuesta);
    }


    public $idNumero;
    public function ajaxMostrarLimiteAlVender(){

        $item = "idNumero";
        $valor = $this->idNumero;

        //$respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
        $respuesta = ControladorVentasLimite::ctrMostrarVentasLimiteAlVender("idNumero", $valor);

        echo json_encode($respuesta);

    }

}

// Preguntando si se hace click con el valor idUsuario
if (isset($_POST["idLimite"])) {
    # code...
    $editar = new AjaxLimite();
    $editar->idLimite = $_POST["idLimite"];
    $editar->ajaxMostrarLimite();
}


// Preguntando si se hace click con el valor idUsuario
if (isset($_POST["idNumero"])) {
    # code...
    $mostrar = new AjaxLimite();
    $mostrar->idNumero = $_POST["idNumero"];
    $mostrar->ajaxMostrarLimiteAlVender();
}


