<?php
require_once "../controladores/xGanadores.controlador.php";
require_once "../modelos/xGanadores.modelo.php";

class TablaGanadoresLoteria
{
    public function mostrarTabla()
    {
        $respuesta = ControladorGanadoresLoteria::ctrMostrarGanadores(null, null);
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

            $premio = number_format($value["premio"], 0, '.', ',');
            $ventasTotales = number_format($value["venta_sorteo"], 0, '.', ',');
            $new_date = date_format(date_create($value["fecha"]), 'd/m/Y');

            $utilidad = "<a class='text-primary'>  " . 'C$ ' . number_format($value['utilidad'], 0, '.', ',') . "  </a>";
            if ($value['utilidad'] < 0) {
                $negativa = number_format($value['utilidad'], 0, '.', ',');
                $utilidad = "<a class='text-warning'>  " . 'C$ ' . $negativa . "  </a>";
            }
            $datosJson .=
                '[
                            "' . $value["id"] . '",
                            "' . $new_date . '",
                            "' . 'C$ ' . $ventasTotales . '",
                            "' . $value["ganador"] . '",
                            "' . 'C$ ' . $value["inversion"] . '",
                            "' . 'C$ ' . $premio . '",
                            "' .  $utilidad . '"
                            
                        ],';
        }

        $datosJson = substr($datosJson, 0, -1);

        $datosJson .= '
                ]
            }';

        echo $datosJson;
    }
}

$tabla = new TablaGanadoresLoteria;
$tabla->mostrarTabla();
