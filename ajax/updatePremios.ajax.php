<?php
require_once "../controladores/premios.controlador.php";
require_once "../modelos/premios.modelo.php";

class AjaxPremios
{
    public $idInversion;

    public function ajaxMostrarInversiones()
    {
        $item = "id";
        $valor = $this->idInversion;

        //$respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
        $respuesta = ControladorPremios::ctrMostrarPremios("inversion", $this->idInversion);

        echo json_encode($respuesta);
    }

    public $idEliminar;

    public function ajaxEliminarInversiones()
    {

        $respuesta = ControladorPremios::ctrEliminarPremios($this->idEliminar);
        // Tambien podria ser $respuesta = ControladorUsuarios::ctrMostrarUsuarios("id, $this->idUsuario);

        echo $respuesta;
    }

    public $idInve;
    public function ajaxMMM()
    {
        $item = "id";
        $valor = $this->idInversion;
        //$respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
        $respuesta = ControladorPremios::ctrMostrarPremioEditar("id", $this->idInve);
        echo json_encode($respuesta);
    }
}

// Preguntando si se hace click con el valor idUsuario
if (isset($_POST["idInversion"])) {
    # code...
    $editar = new AjaxPremios();
    $editar->idInversion = $_POST["idInversion"];
    $editar->ajaxMostrarInversiones();
}


// Preguntando si se hace click con el valor idEliminar
if (isset($_POST["idEliminar"])) {
    $eliminar = new AjaxPremios();
    $eliminar->idEliminar = $_POST["idEliminar"];
    $eliminar->ajaxEliminarInversiones();
}

if (isset($_POST["idInve"])) {
    $ed = new AjaxPremios();
    $ed->idInve = $_POST["idInve"];
    $ed->ajaxMMM();
}

