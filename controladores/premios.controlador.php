<?php

class ControladorPremios
{
    static public function ctrMostrarPremios($item, $valor)
    {
        $tabla = 'inversiones';
        $respuesta = ModeloPremios::mdlMostrarPremios($tabla, $item, $valor);

        return $respuesta; //Para devolver la informacion de nuevo a tablaUsuarios.ajax
    }

    static public function ctrMostrarPremioEditar($item, $valor)
    {

        $tabla = 'inversiones';
        $respuesta = ModeloPremios::mdlMostrarPremioEditar($tabla, $item, $valor);

        return $respuesta; //Para devolver la informacion de nuevo a tablaUsuarios.ajax
    }

    public function ctrRegistroPremios()
    {
        if (isset($_POST["registroInversion"])) {
            # Validamos que no traiga el nombre caracteres especiales
            if ((preg_match('/^[0-9]+$/', $_POST["registroInversion"])
                && $_POST["registroInversion"] > 0
                && $_POST["registroInversion"] < 260)) {

                $tabla = 'inversiones';
                //Vamos a almacenar los datos en un array para poder enviarlos al modelo
                $datos = array(
                    "inversion" => $_POST["registroInversion"],
                    "premio" => $_POST["registroPremio"],
                    "tablaPremio" => $_POST["registroTabla"],
                );
                //Pedimos una respuesta de usuarios.modelo
                $respuesta = ModeloPremios::mdlRegistroPremios($tabla, $datos);
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
                        title: 'ERROR: Este campo solamente acepta números entre 0 y 260',
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

    public function ctrEditarPremios()
    {
        if (isset($_POST["editarId"])) {
            # Validamos que no traiga el nombre caracteres especiales
            if ((preg_match('/^[0-9]+$/', $_POST["editarInversion"])
                && $_POST["editarInversion"] > 0
                && $_POST["editarInversion"] < 260)) {

                $tabla = 'inversiones';

                //Vamos a almacenar los datos en un array para poder enviarlos al modelo
                $datos =  array(
                    "id" => $_POST["editarId"],
                    "inversion" => $_POST["editarInversion"],
                    "premio" => $_POST["editarPremio"],
                );
                //Pedimos una respuesta de usuarios.modelo
                $respuesta = ModeloPremios::mdlEditarPremios($tabla, $datos);
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
                        title: 'ERROR: Este campo solamente acepta números entre 0 y 260',
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

    static public function ctrEliminarPremios($id)
    {
        $tabla = "inversiones";
        $datos = array(
            "id" => $id
        );

        $respuesta = ModeloPremios::mdlEliminarPremios($tabla, $datos);

        return $respuesta;
    }

}
