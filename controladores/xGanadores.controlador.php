<?php

class ControladorGanadoresLoteria
{
    static public function ctrMostrarGanadores($item, $valor)
    {
        $tabla1 = 'ganadores_loteria';
        $tabla2 = 'numeros';

        $respuesta = ModeloGanadoresLoteria::mdlMostrarGanadores($tabla1, $tabla2, $item, $valor);

        return $respuesta;
    }

    public function ctrRegistroGanadores()
    {
        if (isset($_POST["xRegistroGanadorLoteria"])) {
            # Validamos que no traiga el nombre caracteres especiales
            if ((preg_match('/^[0-9]+$/', $_POST["xRegistroGanadorLoteria"]))
                && $_POST["registroVentasLoteria"] != ""
                && $_POST["xRegistroInversionLoteria"] != ""
                && $_POST["xRegistroPremioLoteria"] != ""
                && ($_POST["xRegistroGanadorLoteria"] >= 0 && $_POST["xRegistroGanadorLoteria"] <= 99)
            ) {

                $tabla = 'ganadores_loteria';
                $utilidad = ($_POST["registroVentasLoteria"] - $_POST["xRegistroPremioLoteria"]);
                //Vamos a almacenar los datos en un array para poder enviarlos al modelo

                $datos = array(
                    "idNumero" => $_POST["xRegistroGanadorLoteria"],
                    "inversion" => $_POST["xRegistroInversionLoteria"],
                    "premio" => $_POST["xRegistroPremioLoteria"],
                    "utilidad" => $utilidad,
                    "venta_total" => $_POST["registroVentasLoteria"],
                );
                //Pedimos una respuesta de usuarios.modelo
                $respuesta = ModeloGanadoresLoteria::mdlRegistroGanadores($tabla, $datos);
                // echo '<pre>'; print_r($respuesta); echo '</pre>';

                if ($respuesta == "ok") {

                    echo "
                    <script>
                        Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Registro Exitoso!',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    if (window.history.replaceState) { // verificamos disponibilidad
                        window.history.replaceState(null, null, window.location.href);
                    }

                    </script>
                    ";
                }
            } else {
                echo "
                    <script>
                        Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'ERROR: Este campo solamente acepta números entre 0 y 99',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    if (window.history.replaceState) { // verificamos disponibilidad
                        window.history.replaceState(null, null, window.location.href);
                    }
                    </script>
                    ";
            }
        }
    }

    static public function ctrDetalleGanadores($item, $valor)
    {
        $tabla1 = 'ventas_loteria';
        $tabla3 = 'numeros';
        $tabla4 = 'usuarios';
        $tabla5 = 'ganadores_loteria';

        $respuesta = ModeloGanadoresLoteria::mdldetalleGanadores($tabla1, $tabla3, $tabla4, $tabla5, $item, $valor);

        return $respuesta;
    }

    /* static public function ctrGraficoUtilidades()
    {
        $tabla = 'ganadores';

        $respuesta = ModeloGanadoresLoteria::mdlGraficoUtilidad($tabla);

        return $respuesta;
    } */
}
