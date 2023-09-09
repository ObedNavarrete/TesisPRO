<?php
require_once "../controladores/numeros.controlador.php";
require_once "../modelos/numeros.modelo.php";

class AjaxNumeros
{
    //EDITAR USUARIOS
    public $idCategoria;

    public function ajaxMostrarNumeros()
    {
        $item = "id";
        $valor = $this->idCategoria;

        //$respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
        $respuesta = ControladorNumeros::ctrMostrarNumeros("id", $this->idNumero);

        echo json_encode($respuesta);
    }

    public $idNumero;
    public function ajaxMostrarPasivo()
    {
        $item = "id";
        $valor = $this->idCategoria;

        //$respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
        $respuesta = ControladorNumeros::ctrMostrarNumeros("id", $this->idNumero);

        echo json_encode($respuesta);
    }

    public $idEliminar;

    public function ajaxEliminarNumeros()
    {

        $respuesta = ControladorNumeros::ctrEliminarNumeros($this->idEliminar);
        // Tambien podria ser $respuesta = ControladorUsuarios::ctrMostrarUsuarios("id, $this->idUsuario);

        echo $respuesta;
    }

    
    /*ACTIVANDO NUMERO */
	public $activarNumero;
	public $activarId;
	public function ajaxActivarNumero(){

		$tabla = "numeros";

		$item1 = "pasivo";
		$valor1 = $this->activarNumero;

		$item2 = "id";
		$valor2 = $this->activarId;

		$respuesta = ModeloNumeros::mdlActualizarNumero($tabla, $item1, $valor1, $item2, $valor2);

	}
}

// Preguntando si se hace click con el valor idUsuario
/* if (isset($_POST["idNumero"])) {
    # code...
    $editar = new AjaxNumeros();
    $editar->idNumero = $_POST["idNumero"];
    $editar->ajaxMostrarNumeros();
} */

if (isset($_POST["idNumero"])) {
    # code...
    $editar = new AjaxNumeros();
    $editar->idNumero = $_POST["idNumero"];
    $editar->ajaxMostrarPasivo();
}


// Preguntando si se hace click con el valor idEliminar
if (isset($_POST["idEliminar"])) {
    $eliminar = new AjaxNumeros();
    $eliminar->idEliminar = $_POST["idEliminar"];
    $eliminar->ajaxEliminarNumeros();
}

if(isset($_POST["activarNumero"])){

	$activarNumero = new AjaxNumeros();
	$activarNumero -> activarNumero = $_POST["activarNumero"];
	$activarNumero -> activarId = $_POST["activarId"];
	$activarNumero -> ajaxActivarNumero();

}