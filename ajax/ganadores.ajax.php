<?php
require_once "../controladores/ganadores.controlador.php";
require_once "../modelos/ganadores.modelo.php";

class TablaGanadores
{
    public function mostrarTabla()
    {
        $respuesta = ControladorGanadores::ctrMostrarGanadores(null, null);
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

            $acciones = "<div class='btn-group'><button class='btn btn-outline-info btn-sm btnResumen' data-toggle='modal' data-target='#verResumen' idnumero='" . $value["ganador"] . "' fecha='" . $value["fecha"] . "' idsorteo='" . $value["idsorteo"] . " '>Ver</button></div>";

            $premio = number_format($value["premio"], 0, '.', ',');
            $ventasTotales = number_format($value["venta_sorteo"], 0, '.', ',');
            $new_date = date_format(date_create($value["fecha"]), 'd/m/Y');

            $utilidad = "<a class='text-primary'>  " . 'C$ ' . number_format($value['utilidad'], 0, '.', ',') . "  </a>";
            if ($value['utilidad'] < 0) {
                $negativa = number_format($value['utilidad'], 0, '.', ',');
                $utilidad = "<a class='text-warning'>  " . 'C$ ' . $negativa . "  </a>";
            }

            if ($value['sorteo'] == 'Mañana') {
                $sorteo = "<button class='col-9 btn btn-sm btn-primary shadow-none'>  " . $value['sorteo'] . "  </button>";
            } else if ($value['sorteo'] == 'Tarde') {
                $sorteo = "<button class=' col-9 btn btn-sm btn-success shadow-none'>  " . $value['sorteo'] . "  </button>";
            } else if ($value['sorteo'] == 'Noche') {
                $sorteo = "<button class='col-9 btn btn-sm btn-danger shadow-none'>  " . $value['sorteo'] . "  </button>";
            }

            $datosJson .=
                '[
                            "' . $value["id"] . '",
                            "' . $new_date . '",
                            "' . $sorteo . '",
                            "' . 'C$ ' . $ventasTotales . '",
                            "' . $value["ganador"] . '",
                            "' . 'C$ ' . $premio . '",
                            "' .  $utilidad . '",
                            "' .  $acciones . '"
                            
                        ],';
        }

        $datosJson = substr($datosJson, 0, -1);

        $datosJson .= '
                ]
            }';

        echo $datosJson;
    }
}

$tabla = new TablaGanadores;
$tabla->mostrarTabla();
