<?php
require_once "../controladores/ventasFecha.controlador.php";
require_once "../modelos/ventasFecha.modelo.php";

class TablaVentaVendedoresSemana
{
    public function mostrarTabla()
    {
        $respuesta = ControladorVentasFecha::ctrMostrarVentaVendedores();
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

            $totalVendido = number_format($value["totalvendido"], 0, '.', ',');
            $salario = number_format($value["salariovendedor"], 2, '.', ',');



            $datosJson .=
                '[
                            "' . $value["nombre"] . '",
                            "' . $value["ruta"] . '",
                            "' . 'C$ ' . $totalVendido . '"
                            
                        ],';
        }

        $datosJson = substr($datosJson, 0, -1);

        $datosJson .= '
                ]
            }';

        echo $datosJson;
    }
}

$tabla = new TablaVentaVendedoresSemana;
$tabla->mostrarTabla();
