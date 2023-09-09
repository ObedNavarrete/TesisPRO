<?php

class ControladorVentasLimite
{
    static public function ctrMostrarVentasLimite($item, $valor)
    {
        $tabla1 = 'vendedor_numero_limite';
        $tabla2 = 'numeros';
        $tabla3 = 'usuarios';
        $respuesta = ModeloAdminVentasLimite::mdlMostrarVentasLimite($tabla1, $tabla2, $tabla3, $item, $valor);

        return $respuesta; //Para devolver la informacion de nuevo a tablaUsuarios.ajax
    }

    static public function ctrMostrarVentasLimiteAlVender($item, $valor)
    {
        $tabla1 = 'vendedor_numero_limite';
        $tabla2 = 'numeros';
        $tabla3 = 'usuarios';
        $respuesta = ModeloAdminVentasLimite::mdlMostrarVentasLimiteAlVender($tabla1, $tabla2, $tabla3, $item, $valor);

        return $respuesta; //Para devolver la informacion de nuevo a tablaUsuarios.ajax
    }

        static public function ctrMostrarVentasLimiteAlVenderLoto()
    {
        $tabla1 = 'vendedor_numero_limite';
        $tabla2 = 'numeros';
        $tabla3 = 'usuarios';
        $respuesta = ModeloAdminVentasLimite::mdlMostrarVentasLimiteAlVenderLoto($tabla1, $tabla2, $tabla3);

        return $respuesta; //Para devolver la informacion de nuevo a tablaUsuarios.ajax
    }

    public function ctrRegistroVentaLimite()
    {
        if (isset($_POST["registroLimite"])) {
            # Validamos que no traiga el nombre caracteres especiales
            if (
                $_POST["registroLimite"] != ''
                and
                $_POST["registroLimite"] >= 0
            ) {

                $tabla = 'vendedor_numero_limite';
                //Vamos a almacenar los datos en un array para poder enviarlos al modelo
                $datos = array(
                    "idVendedor" => $_POST["registroUsuario"],
                    "idNumero" => $_POST["registroNumero"], //Como sale en el modelo
                    "limite" => $_POST["registroLimite"],
                );
                //Pedimos una respuesta de usuarios.modelo
                $respuesta = ModeloAdminVentasLimite::mdlRegistroVentaLimite($tabla, $datos);
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
                    };

                    

                    setTimeout('recargar()',1500);
                    
                    </script>
                    ";
                }
            } else {
                echo "
                    <script>
                        Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'ERROR: No use caracteres especiales y/o campos vacíos',
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

    public function ctrEditarVentaLimite()
    {
        if (isset($_POST["editarId"])) {
            # Validamos que no traiga el nombre caracteres especiales
            if ((preg_match('/^[0-9]+$/', $_POST["editarLimite"])
                    && $_POST["editarLimite"] >= 0)
                && $_POST["editarLimite"] != ''
            ) {

                $tabla = 'vendedor_numero_limite';

                //Vamos a almacenar los datos en un array para poder enviarlos al modelo
                $datos =  array(
                    "id" => $_POST["editarId"],
                    "limite" => $_POST["editarLimite"],
                );
                //Pedimos una respuesta de usuarios.modelo
                $respuesta = ModeloAdminVentasLimite::mdlEditarVentaLimite($tabla, $datos);
                // echo '<pre>'; print_r($respuesta); echo '</pre>';

                if ($respuesta == "ok") {

                    echo "
                    <script>
                        Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Modificación Exitosa!',
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
}
