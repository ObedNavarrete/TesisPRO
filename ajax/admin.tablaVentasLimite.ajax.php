<?php
require_once "../controladores/admin.ventas-limite.controlador.php";
require_once "../modelos/admin.ventas-limite.modelo.php";

class TablaAdminVentasLimite
{
    public function mostrarTabla()
    {
        $respuesta = ControladorVentasLimite::ctrMostrarVentasLimite(null, null);
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
            $acciones = "<div class='btn-group'><button class='btn btn-warning shadow-none btn-sm editarLimite text-white'data-toggle='modal' data-target='#editarLimite' idLimite='" . $value["id"] . "'>Editar</div>";
            // La clase .editarUsuario, me ayuda a obtener la informacion del usuario que quiero editar, esta clase la uso en usuarios.js
            $limite = number_format($value["limite"], 0, '.', ',');
            $numero = str_pad($value["numero"], 2, "0", STR_PAD_LEFT);

            $datosJson .=
                '[
                            
                            "' . $value["nombre"] . '",
                            "' . $value["ruta"] . '",
                            "' . $numero . '",
                            "' . 'C$ ' . $limite . '",
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

$tabla = new TablaAdminVentasLimite;
$tabla->mostrarTabla();
