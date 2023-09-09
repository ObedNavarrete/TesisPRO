<?php

class ControladorGanadores
{
    static public function ctrMostrarGanadores($item, $valor)
    {
        $tabla1 = 'ganadores';
        $tabla2 = 'numeros';
        $tabla3 = 'sorteos';

        $respuesta = ModeloGanadores::mdlMostrarGanadores($tabla1, $tabla2, $tabla3, $item, $valor);

        return $respuesta;
    }

    public function ctrRegistroGanadores()
    {
        if (isset($_POST["registroGanador"])) {
            # Validamos que no traiga el nombre caracteres especiales
            if ((preg_match('/^[0-9]+$/', $_POST["registroGanador"]))
                && $_POST["registroSorteo"] != ""
                && $_POST["registroVentas"] != ""
                && $_POST["registroInversion"] != ""
                && $_POST["registroPremio"] != ""
                && ($_POST["registroGanador"] >= 0 && $_POST["registroGanador"] <= 99) ) {

                $gan = ControladorVentas::ctrMostrarVentasGanador("idNumero", $_POST["registroGanador"]);

                $tabla = 'ganadores';
                $utilidad = ($_POST["registroVentas"] - $gan["premio"]);
                //Vamos a almacenar los datos en un array para poder enviarlos al modelo

                $datos = array(
                    "idNumero" => $_POST["registroGanador"],
                    "inversion" => $gan["inversion"],
                    "premio" => $gan["premio"],
                    "idSorteo" => $_POST["registroSorteo"],
                    "utilidad" => $utilidad,
                    "venta_total" => $_POST["registroVentas"],
                );
                //Pedimos una respuesta de usuarios.modelo
                $respuesta = ModeloGanadores::mdlRegistroGanadores($tabla, $datos);
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
        $tabla1 = 'ventas';
        $tabla2 = 'sorteos';
        $tabla3 = 'numeros';
        $tabla4 = 'usuarios';
        $tabla5 = 'ganadores';

        $respuesta = ModeloGanadores::mdldetalleGanadores($tabla1, $tabla2, $tabla3, $tabla4, $tabla5, $item, $valor);

        return $respuesta;
    }

    static public function ctrGraficoUtilidades()
    {
        $tabla = 'ganadores';
        $tabla2 = 'ganadores_loteria';

        $respuesta = ModeloGanadores::mdlGraficoUtilidad($tabla, $tabla2);

        return $respuesta;
    }

    static public function ctrBtnGanador()
    {
        $tabla = 'ganadores';

        $respuesta = ModeloGanadores::mdlBtnGanador($tabla);

        return $respuesta;
    }

    static public function ctrValidaUnGanador()
    {
        $tabla1 = 'ganadores';
        $tabla2 = 'sorteos';

        $respuesta = ModeloGanadores::mdlValidaUnGanador($tabla1, $tabla2);

        return $respuesta;
    }

    static public function ctrResumenDiario()
    {
        $respuesta = ModeloGanadores::mdlResumenDiario();
        return $respuesta;
    }

        static public function ctrMostrarResumen($idnumero, $fecha, $idsorteo)
    {
        $respuesta = ModeloGanadores::mdlMostrarResumen($idnumero, $fecha, $idsorteo);
        return $respuesta;
    }
}