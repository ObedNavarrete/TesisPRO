<?php
require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class TablaUsuarios
{
    public function mostrarTabla()
    {
        $respuesta = ControladorUsuarios::ctrMostrarUsuarios(null, null);
        //echo '<pre>'; print_r($respuesta); echo'</pre>'; //Imprime en consola la info de la base de datos

        if (count($respuesta) == 0) {
            //Por si aun no hay datos en la tabla 
            $datosJson = '{"data" : []}';
            echo $datosJson;
            return;
        }

        $datosJson = '{

                "data" : [';

        foreach ($respuesta as $key => $value) {
            //El boton de editar se le agrega una clase que se llama editarUsuario, datatoogle='modal' y data-target'#editarUsuario'
            //$value["id"] me ayuda a obtener el id del usuario que quiero editar
            //El atributo idUsuario lo uso en updataUsuarios.ajax.php, me sirve para editar
            $acciones = "<div class='btn-group'><button class='btn btn-primary shadow-none btn-sm editarUsuario'data-bs-toggle='modal' data-bs-target='#editarUsuario' idUsuario='" . $value["id"] . "'><i class='fas fa-pencil-alt shadow-none text-white'></i></button><button class='btn btn-dark btn-sm btnEliminar'id-usuario='" . $value["id"] . "'><i class='fas fa-trash-alt text-white'></i></button></div>";
            // La clase .editarUsuario, me ayuda a obtener la informacion del usuario que quiero editar, esta clase la uso en usuarios.js

            $datosJson .=
                '[
                            
                            "' . $value["nombre"] . '",
                            "' . $value["usuario"] . '",
                            "' . $value["ruta"] . '",
                            "' . $value["rol"] . '",
                            "' . $acciones . '"
                            
                        ],';
        } /* Cerrando el Foreach */

        $datosJson = substr($datosJson, 0, -1);

        $datosJson .= '
                ]
            }';

        echo $datosJson;
    }
}

$tabla = new TablaUsuarios;
$tabla->mostrarTabla();
