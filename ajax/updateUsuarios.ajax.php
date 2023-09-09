<?php
require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class AjaxUsuarios{
    //EDITAR USUARIOS
    public $idUsuario;

    public function ajaxMostrarUsuario(){
        $item = "id";
        $valor = $this->idUsuario;

        //$respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
        $respuesta = ControladorUsuarios::ctrMostrarUsuarios("id", $this->idUsuario);

        echo json_encode($respuesta);
    }

    public $idEliminar;

    public function ajaxEliminarUsuario(){

        $respuesta = ControladorUsuarios::ctrEliminarUsuarios($this->idEliminar);
        // Tambien podria ser $respuesta = ControladorUsuarios::ctrMostrarUsuarios("id, $this->idUsuario);

        echo $respuesta;
    }

}

// Preguntando si se hace click con el valor idUsuario
if (isset($_POST["idUsuario"])) {
    # code...
    $editar = new AjaxUsuarios();
    $editar -> idUsuario = $_POST["idUsuario"];
    $editar -> ajaxMostrarUsuario();
}


// Preguntando si se hace click con el valor idEliminar
if(isset($_POST["idEliminar"])){
    $eliminar = new AjaxUsuarios();
    $eliminar -> idEliminar = $_POST["idEliminar"];
    $eliminar -> ajaxEliminarUsuario();
}