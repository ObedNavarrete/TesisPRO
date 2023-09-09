<?php

class ControladorNumeros
{
    static public function ctrMostrarNumeros($item, $valor)
    {
        $tabla = 'numeros';
        $respuesta = ModeloNumeros::mdlMostrarNumeros($tabla, $item, $valor);

        return $respuesta; //Para devolver la informacion de nuevo a tablaUsuarios.ajax
    }

    static public function ctrMostrarNumerosVenta($item, $valor)
    {
        $tabla = 'numeros';
        $respuesta = ModeloNumeros::mdlMostrarNumerosVenta($tabla, $item, $valor);

        return $respuesta; //Para devolver la informacion de nuevo a tablaUsuarios.ajax
    }

    public function ctrRegistroNumeros()
    {
        if (isset($_POST["registroNumero"])) {
            # Validamos que no traiga el nombre caracteres especiales
            if ((preg_match('/^[0-9]+$/', $_POST["registroNumero"])
                && $_POST["registroNumero"] >= 0
                && $_POST["registroNumero"] < 100)) {

                $tabla = 'numeros';
                //Vamos a almacenar los datos en un array para poder enviarlos al modelo
                $datos = array(
                    "numero" => $_POST["registroNumero"],
                );
                //Pedimos una respuesta de usuarios.modelo
                $respuesta = ModeloNumeros::mdlRegistroNumeros($tabla, $datos);
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

    public function ctrEditarNumeros()
    {
        if (isset($_POST["editarId"])) {
            # Validamos que no traiga el nombre caracteres especiales
            if ((preg_match('/^[0-9]+$/', $_POST["editarNumero"])
                && $_POST["editarNumero"] >= 0
                && $_POST["editarNumero"] < 100)) {

                $tabla = 'numeros';

                //Vamos a almacenar los datos en un array para poder enviarlos al modelo
                $datos =  array(
                    "id" => $_POST["editarId"],
                    "numero" => $_POST["editarNumero"],
                );
                //Pedimos una respuesta de usuarios.modelo
                $respuesta = ModeloNumeros::mdlEditarNumeros($tabla, $datos);
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

    static public function ctrEliminarNumeros($id)
    {
        $tabla = "numeros";
        $datos = array(
            "id" => $id
        );

        $respuesta = ModeloNumeros::mdlEliminarNumeros($tabla, $datos);

        return $respuesta;
    }
}
