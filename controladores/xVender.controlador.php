<?php

class ControladorVentasLoteria
{

    static public function ctrMostrarRecibo($item, $valor)
    {
        $tabla1 = 'ventas_loteria';
        $tabla2 = 'numeros';
        $tabla3 = 'usuarios';

        $respuesta = ModeloVentasLoteria::mdlMostrarRecibos($tabla1, $tabla2, $tabla3, $item, $valor);

        return json_encode($respuesta);
    }

    /*En el formulario de inicio para los vendedores saber cuanto han vendido del n'umero que eligen*/
    static public function ctrMostrarVentasAlVender($item, $valor)
    {
        $tabla1 = 'ventas_loteria';
        $tabla2 = 'numeros';

        $respuesta = ModeloVentasLoteria::mdlMostrarVentasAlVender($tabla1, $tabla2, $item, $valor);

        return $respuesta; //Para devolver la informacion de nuevo a tablaUsuarios.ajax
    }

    static public function ctrMostrarVentasVendedor($item, $valor)
    {
        $tabla1 = 'ventas_loteria';
        $tabla2 = 'numeros';

        $respuesta = ModeloVentasLoteria::mdlMostrarVentasVendedor($tabla1, $tabla2, $item, $valor);

        return $respuesta; //Para devolver la informacion de nuevo a tablaUsuarios.ajax
    }

    static public function ctrMostrarVentasVendedorNum($item, $valor)
    {
        $tabla1 = 'ventas_loteria';
        $tabla2 = 'numeros';

        $respuesta = ModeloVentasLoteria::mdlMostrarVentasVendedorNum($tabla1, $tabla2, $item, $valor);

        return $respuesta; //Para devolver la informacion de nuevo a tablaUsuarios.ajax
    }

    static public function ctrMostrarVentasSupervisor()
    {
        $tabla1 = 'ventas_loteria';
        $tabla2 = 'numeros';
        $tabla4 = 'usuarios';

        $respuesta = ModeloVentasLoteria::mdlMostrarVentasSupervisor($tabla1, $tabla2, $tabla4);

        return $respuesta; //Para devolver la informacion de nuevo a tablaUsuarios.ajax
    }

    static public function ctrMostrarVentasSupervisorNum()
    {
        $tabla1 = 'ventas_loteria';
        $tabla2 = 'numeros';
        $tabla4 = 'usuarios';

        $respuesta = ModeloVentasLoteria::mdlMostrarVentasSupervisorNum($tabla1, $tabla2, $tabla4);

        return $respuesta; //Para devolver la informacion de nuevo a tablaUsuarios.ajax
    }

    static public function ctrMostrarVentasAdministrador()
    {
        $tabla1 = 'ventas_loteria';
        $tabla2 = 'numeros';
        $tabla4 = 'usuarios';

        $respuesta = ModeloVentasLoteria::mdlMostrarVentasAdministrador($tabla1, $tabla2, $tabla4);

        return $respuesta; //Para devolver la informacion de nuevo a tablaUsuarios.ajax
    }

    static public function ctrMostrarVentasAdministradorNum()
    {
        $tabla1 = 'ventas_loteria';
        $tabla2 = 'numeros';
        $tabla4 = 'usuarios';

        $respuesta = ModeloVentasLoteria::mdlMostrarVentasAdministradorNum($tabla1, $tabla2, $tabla4);

        return $respuesta; //Para devolver la informacion de nuevo a tablaUsuarios.ajax
    }

    static public function ctrRegistroVenta()
    {
        if (isset($_POST["arrayParaVenderLoteria"])) {

            date_default_timezone_set('America/Managua');
            $Time = date('H:i:s', time());
            $hi1 = '18:00:00';

            if (($Time > $hi1)) {

                echo "
                            <script>
                                Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: 'Fuera de Horario!',
                                showConfirmButton: false,
                                timer: 1500
                            });
        
                            if (window.history.replaceState) { // verificamos disponibilidad
                                window.history.replaceState(null, null, window.location.href);
                            }
        
                            </script>
                            ";
            } else {

                if ($_POST["arrayParaVenderLoteria"] != null) {
                    $paraVender = json_decode($_POST["arrayParaVenderLoteria"], true);
                    //echo var_dump($paraVender);
                    $cantidadNumeros = count($paraVender);
                    $codigo = $paraVender[0]["recibo"];
                    $vende = $paraVender[0]["idUsuario"];
                    //$suma = $_POST["regSumaBoleto"];
                    $recibos = 'recibos_loteria';

                    $suma = 0;
                    foreach ($paraVender as $pv) {
                        $suma = $suma + $pv["inversion"];
                    }

                    $respuesta2 = ModeloVentasLoteria::mdlRegistroRecibos($recibos, $suma, $codigo, $cantidadNumeros, $vende);
                    if ($respuesta2 == "ok") {
                        foreach ($paraVender as $value) {

                            $res = ControladorPremios::ctrMostrarPremios("inversion", $value["inversion"]);
                            //echo json_encode($res);

                            $tabla = 'ventas_loteria';
                            $datos = array(
                                "idNumero" => $value["numero"],
                                "inversion" => $value["inversion"],
                                "premio" => $res["premio"],
                                "idVendidoPor" => $value["idUsuario"],
                                "codigo" => $value["recibo"],
                            );

                            $respuesta = ModeloVentasLoteria::mdlRegistroVentas($tabla, $datos);

                            if ($respuesta == "ok") {
                            }
                        }
                    }

                    $existeRecibo = ControladorRecibosLoteria::ctrMostrarRECLoteria($paraVender[0]["recibo"]);
                    $tam = count($existeRecibo);

                    if ($tam > 0) {

                        if ($_POST["registroImprime"] == 1) {
                            echo '
                            <script>
                            if (window.history.replaceState) { // verificamos disponibilidad
                                window.history.replaceState(null, null, window.location.href);
                                }

                                Swal.fire({
                                    title: "Exito",
                                    text: "Imprimir Recibo?!",
                                    icon: "success",
                                    showCancelButton: false,
                                    confirmButtonColor: "#3085d6",
                                    cancelButtonColor: "#d33",
                                    confirmButtonText: "Sí!",
                                    cancelButtonText: "No",
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "/fpdf/recibo-loteria.php?codigo=' . $paraVender[0]["recibo"] . '";
                            
                                    }
                                });

                            </script>
                            ';
                        } else {
                            echo "
                            <script>
                            Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Venta exitosa!',
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
                        title: 'No se guardó!',
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
                                title: 'No hay datos que guardar!',
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
    }


    static public function ctrEliminarVentas($codigo)
    {
        date_default_timezone_set('America/Managua');
        $Time = date('H:i:s', time());
        $hi1 = '18:00:00';

        if ($Time > $hi1) {
            echo "
                        <script>
                            Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'No hay datos que guardar!',
                            showConfirmButton: false,
                            timer: 1500
                        });
    
                        if (window.history.replaceState) { // verificamos disponibilidad
                            window.history.replaceState(null, null, window.location.href);
                        }
    
                        </script>
                        ";
        } else {
            $respuesta = ModeloVentasLoteria::mdlEliminarVentas($codigo);
            return $respuesta;
        }
    }

    static public function ctrMostrarListaVendedeoresSupervisor()
    {
        $tabla1 = "ventas_loteria";
        $tabla2 = "usuarios";

        $respuesta = ModeloVentasLoteria::mdlMostrarListaVendedeoresSupervisor($tabla1, $tabla2);

        return $respuesta;
    }

    static public function ctrMostrarListaVendedeoresAdministrador()
    {
        $tabla1 = "ventas_loteria";
        $tabla2 = "usuarios";

        $respuesta = ModeloVentasLoteria::mdlMostrarListaVendedeoresAdministrador($tabla1, $tabla2);

        return $respuesta;
    }


    /*En el formulario de inicio para los vendedores saber cuanto han vendido del n'umero que eligen*/
    static public function ctrMostrarVentasGanador($item, $valor)
    {
        $tabla1 = 'ventas_loteria';
        $tabla2 = 'numeros';

        $respuesta = ModeloVentasLoteria::mdlMostrarVentasGanador($tabla1, $tabla2, $item, $valor);

        return $respuesta; //Para devolver la informacion de nuevo a tablaUsuarios.ajax
    }

    static public function ctrMostrarVentasNoDetalle($item, $valor)
    {
        $tabla1 = 'ventas_loteria';
        $tabla2 = 'numeros';
        $tabla4 = 'usuarios';

        $respuesta = ModeloVentasLoteria::mdlMostrarVentasNoDetalle($tabla1, $tabla2, $tabla4, $item, $valor);

        return $respuesta; //Para devolver la informacion de nuevo a tablaUsuarios.ajax
    }
}
