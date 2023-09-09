<?php

class ControladorVentas
{

    static public function ctrMostrarRecibo($item, $valor)
    {
        $tabla1 = 'ventas';
        $tabla2 = 'numeros';
        $tabla3 = 'usuarios';

        $respuesta = ModeloVentas::mdlMostrarRecibos($tabla1, $tabla2, $tabla3, $item, $valor);

        return json_encode($respuesta);
    }

    /*En el formulario de inicio para los vendedores saber cuanto han vendido del n'umero que eligen*/
    static public function ctrMostrarVentasAlVender($item, $valor)
    {
        $tabla1 = 'ventas';
        $tabla2 = 'numeros';
        $tabla3 = 'sorteos';

        $respuesta = ModeloVentas::mdlMostrarVentasAlVender($tabla1, $tabla2, $tabla3, $item, $valor);

        return $respuesta; //Para devolver la informacion de nuevo a tablaUsuarios.ajax
    }

    static public function ctrMostrarVentasVendedor($item, $valor)
    {
        $tabla1 = 'ventas';
        $tabla2 = 'numeros';
        $tabla3 = 'sorteos';

        $respuesta = ModeloVentas::mdlMostrarVentasVendedor($tabla1, $tabla2, $tabla3, $item, $valor);

        return $respuesta; //Para devolver la informacion de nuevo a tablaUsuarios.ajax
    }

    static public function ctrMostrarVentasVendedorNum($item, $valor)
    {
        $tabla1 = 'ventas';
        $tabla2 = 'numeros';
        $tabla3 = 'sorteos';

        $respuesta = ModeloVentas::mdlMostrarVentasVendedorNum($tabla1, $tabla2, $tabla3, $item, $valor);

        return $respuesta; //Para devolver la informacion de nuevo a tablaUsuarios.ajax
    }

    static public function ctrMostrarVentasSupervisor()
    {
        $tabla1 = 'ventas';
        $tabla2 = 'numeros';
        $tabla3 = 'sorteos';
        $tabla4 = 'usuarios';

        $respuesta = ModeloVentas::mdlMostrarVentasSupervisor($tabla1, $tabla2, $tabla3, $tabla4);

        return $respuesta; //Para devolver la informacion de nuevo a tablaUsuarios.ajax
    }

    static public function ctrMostrarVentasSupervisorNum()
    {
        $tabla1 = 'ventas';
        $tabla2 = 'numeros';
        $tabla3 = 'sorteos';
        $tabla4 = 'usuarios';

        $respuesta = ModeloVentas::mdlMostrarVentasSupervisorNum($tabla1, $tabla2, $tabla3, $tabla4);

        return $respuesta; //Para devolver la informacion de nuevo a tablaUsuarios.ajax
    }

    static public function ctrMostrarVentasAdministrador()
    {
        $tabla1 = 'ventas';
        $tabla2 = 'numeros';
        $tabla3 = 'sorteos';
        $tabla4 = 'usuarios';

        $respuesta = ModeloVentas::mdlMostrarVentasAdministrador($tabla1, $tabla2, $tabla3, $tabla4);

        return $respuesta; //Para devolver la informacion de nuevo a tablaUsuarios.ajax
    }

    static public function ctrMostrarVentasAdministradorNum()
    {
        $tabla1 = 'ventas';
        $tabla2 = 'numeros';
        $tabla3 = 'sorteos';
        $tabla4 = 'usuarios';

        $respuesta = ModeloVentas::mdlMostrarVentasAdministradorNum($tabla1, $tabla2, $tabla3, $tabla4);

        return $respuesta; //Para devolver la informacion de nuevo a tablaUsuarios.ajax
    }

    static public function ctrRegistroVentas()
    {
      
      $Date = date('Y-m-d');
      $Time = date('H:i:s', time());

      $hi1 = '10:59:00';
      $hf1 = '11:30:00';
      /* $hi2 = '15:58:00'; */
      $hi2 = '14:59:00';
      $hf2 = '15:30:09';
      $hi3 = '20:59:00';

$sorteos = ControladorSorteos::ctrMostrarSorteos(null, null);

if ($Time > $sorteos[0]['inicio'] and $Time < $sorteos[0]['fin']) {
  $id = $sorteos[0]['id'];
  $valor = $sorteos[0]['sorteo'];
} else
        if ($Time > $sorteos[1]['inicio'] and $Time < $sorteos[1]['fin']) {
  $id = $sorteos[1]['id'];
  $valor = $sorteos[1]['sorteo'];
} else
        if ($Time > $sorteos[2]['inicio'] and $Time < $sorteos[2]['fin']) {
  $id = $sorteos[2]['id'];
  $valor = $sorteos[2]['sorteo'];
} else {
  $id = 0;
  $valor = 0;
}

        if (isset($_POST["registroInversion"])) {
            
            if ((($Time > $hi1) && ($Time < $hf1)) || (($Time > $hi2) && ($Time < $hf2)) || (($Time > $hi3))) {
              
              echo "
                    <script>
                        Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Fuera de Horario de Ventas!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    ";
            } else {
              if ((preg_match('/^[0-9]+$/', $_POST["registroInversion"])
                && (preg_match('/^[0-9]+$/', $_POST["registroPremio"]))
                && (preg_match('/^[0-9]+$/', $_POST["registroNumero"]))
                && $_POST["registroInversion"] != ''
                && $_POST["registroPremio"] != ''
                && $_POST["registroNumero"] != ''
                && $_POST["registroActualNum"] != ''
                && $_POST["registroMaximo"] != ''
                && (($_POST["registroActualNum"] + $_POST["registroPremio"]) <= $_POST["registroMaximo"]))) {

                $tabla = 'ventas';

                $datos = array(
                    "idNumero" => $_POST["registroNumero"],
                    "idSorteo" => $_POST["registroSorteo"],
                    "inversion" => $_POST["registroInversion"],
                    "premio" => $_POST["registroPremio"],
                    "idVendidoPor" => $_POST["registroUsuario"],
                );

                $respuesta = ModeloVentas::mdlRegistroVentas($tabla, $datos);

                if ($respuesta == "ok") {

                    echo "
                    <script>
                        Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Venta Exitosa!',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    if (window.history.replaceState) { // verificamos disponibilidad
                        window.history.replaceState(null, null, window.location.href);
                    }

                    window.location.reload();

                    </script>
                    ";
                }
            } else {

                echo "
                    <script>
                        Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'ERROR: El monto que tratas de vender sobrepasa el límite',
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


    static public function ctrRegistroVenta()
    {
        if (isset($_POST["arrayParaVender"])) {

            $Time = date('H:i:s', time());
            $hi1 = '10:59:00';
            $hf1 = '11:15:00';
            $hi2 = '14:59:00';
            $hf2 = '15:15:09';
            $hi3 = '20:59:00';

$sorteos = ControladorSorteos::ctrMostrarSorteos(null, null);
if ($Time > $sorteos[0]['inicio'] and $Time < $sorteos[0]['fin']) {
  $id = $sorteos[0]['id'];
} else if ($Time > $sorteos[1]['inicio'] and $Time < $sorteos[1]['fin']) {
  $id = $sorteos[1]['id'];
} else if ($Time > $sorteos[2]['inicio'] and $Time < $sorteos[2]['fin']) {
  $id = $sorteos[2]['id'];
}

            
            if ($_POST["arrayParaVender"] != null) {

                if ((($Time > $hi1) && ($Time < $hf1)) || (($Time > $hi2) && ($Time < $hf2)) || (($Time > $hi3))) {
                    echo "
                        <script>
                            Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'Fuera de Horario de Venta!',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        if (window.history.replaceState) { // verificamos disponibilidad
                            window.history.replaceState(null, null, window.location.href);
                        }

                        </script>
                        ";

                } else {
                    
                
                
                $sort = ControladorSorteos::ctrMostrarSorteoActual();
                $sa = $sort["id"];

                $paraVender = json_decode($_POST["arrayParaVender"], true);
                //echo var_dump($paraVender);
                $cantidadNumeros = count($paraVender);
                $codigo = $paraVender[0]["recibo"];
                $vende = $paraVender[0]["idUsuario"];
                //$suma = $_POST["regSumaBoleto"];
                $sorteo = $sa;
                $recibos = 'recibos';

                $suma = 0;
                foreach ($paraVender as $pv) {
                    $suma = $suma + $pv["inversion"];
                }

                $respuesta2 = ModeloVentas::mdlRegistroRecibos($recibos, $suma, $codigo, $cantidadNumeros, $vende, $sorteo);
                if ($respuesta2 == "ok") {
                    foreach ($paraVender as $value) {
                    /* if ($key < $cantidadNumeros) { */
                        $res = ControladorPremios::ctrMostrarPremios("inversion", $value["inversion"]);
                        //echo json_encode($res);
                        $cod = $value["recibo"] . $value["numero"];

                        $tabla = 'ventas';
                        $datos = array(
                            "idNumero" => $value["numero"],
                            "idSorteo" => $id,
                            "inversion" => $value["inversion"],
                            "premio" => $res["premio"],
                            "idVendidoPor" => $value["idUsuario"],
                            "codigo" => $value["recibo"],
                        );

                        $respuesta = ModeloVentas::mdlRegistroVentas($tabla, $datos);

                        if ($respuesta == "ok") {
                        }

                        $existeRecibo = ControladorRecibos::ctrMostrarREC($paraVender[0]["recibo"]);
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
                                            window.location.href = "/fpdf/recibo.php?codigo=' . $paraVender[0]["recibo"] . '";
                                
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
                }
            }
            
            }
            
        }else{
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


    static public function ctrEliminarVentas($codigo)
    {
        $Time = date('H:i:s', time());
        $hi1 = '10:58:00';
        $hf1 = '11:30:00';
        $hi2 = '14:58:00';
        $hf2 = '15:30:09';
        $hi3 = '20:58:00';

        if ((($Time > $hi1) && ($Time < $hf1)) || (($Time > $hi2) && ($Time < $hf2)) || (($Time > $hi3))) {
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
            $tabla = "ventas";
            $tabla2 = "recibos";

            $datos = array(
                "codigo" => $codigo
            );
            $respuesta = ModeloVentas::mdlEliminarVentas($tabla, $tabla2, $datos);
            return $respuesta;
        }
    }

    static public function ctrMostrarListaVendedeoresSupervisor()
    {
        $tabla1 = "ventas";
        $tabla2 = "usuarios";
        $tabla3 = "sorteos";

        $respuesta = ModeloVentas::mdlMostrarListaVendedeoresSupervisor($tabla1, $tabla2, $tabla3);

        return $respuesta;
    }

    static public function ctrMostrarListaVendedeoresAdministrador()
    {
        $tabla1 = "ventas";
        $tabla2 = "usuarios";
        $tabla3 = "sorteos";

        $respuesta = ModeloVentas::mdlMostrarListaVendedeoresAdministrador($tabla1, $tabla2, $tabla3);

        return $respuesta;
    }


     /*En el formulario de inicio para los vendedores saber cuanto han vendido del n'umero que eligen*/
     static public function ctrMostrarVentasGanador($item, $valor)
     {
         $tabla1 = 'ventas';
         $tabla2 = 'numeros';
         $tabla3 = 'sorteos';
 
         $respuesta = ModeloVentas::mdlMostrarVentasGanador($tabla1, $tabla2, $tabla3, $item, $valor);
 
         return $respuesta; //Para devolver la informacion de nuevo a tablaUsuarios.ajax
     }

     static public function ctrMostrarVentasNoDetalle($item, $valor)
    {
        $tabla1 = 'ventas';
        $tabla2 = 'numeros';
        $tabla3 = 'sorteos';
        $tabla4 = 'usuarios';

        $respuesta = ModeloVentas::mdlMostrarVentasNoDetalle($tabla1, $tabla2, $tabla3, $tabla4, $item, $valor);

        return $respuesta; //Para devolver la informacion de nuevo a tablaUsuarios.ajax
    }

}
