<?php
require_once "../controladores/premios.controlador.php";
require_once "../modelos/premios.modelo.php";

class TablaPremios
{
    public function mostrarTabla()
    {

        $respuesta = ControladorPremios::ctrMostrarPremios(null, null);
        //echo '<pre>';print_r($respuesta);echo '</pre>'; //Imprime en consola la info de la base de datos

        if (count($respuesta) == 0) {
            //Por si aun no hay datos en la tabla 
            $datosJson = '{"data" : []}';
            echo $datosJson;
            return;
        }

        $datosJson = '{

                "data" : [';

        foreach ($respuesta as $key => $value) {
            $premio = number_format($value["premio"], 0, '.', ',');
            $acciones = "<div class='btn-group'><button class='btn btn-warning shadow-none btn-sm editarInversion'data-toggle='modal' data-target='#editarInversion' idInversion='" . $value["id"] . "'><i class='fas fa-pencil-alt shadow-none text-white'></i></button><button class='btn btn-danger btn-sm btnEliminar'id-inversion='" . $value["id"] . "'><i class='fas fa-trash-alt text-white'></i></button></div>";
            if ($value["tablaPremio"] == 1) {
                $texto = "400 x 5";
            }else{
                $texto = "350 x 5";
            }
            $datosJson .=
                '[
                            
                            "' . $value["inversion"] . '",
                            "' . $premio . '",
                            "' . $texto . '",
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

$tabla = new TablaPremios;
$tabla->mostrarTabla();
