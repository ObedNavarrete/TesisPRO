<?php

class ControladorUsuarios
{
    public function ctrIngresoUsuario()
    {
        if (isset($_POST["ingUsuario"])) {
            if (
                preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingUsuario"]) ||
                preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingPassword"])
            ) {

                $encriptarPassword = crypt($_POST["ingPassword"], '$2a$07$usesomesillystringforsalt$');

                $tabla = 'usuarios';
                $tabla2 = 'roles';
                $tabla3 = 'rutas';
                $item = 'usuario';
                $valor = $_POST["ingUsuario"];
                $respuesta = ModeloUsuarios::mdlMostrarUsuarios($tabla, $tabla2, $tabla3, $item, $valor);

                if (($respuesta["usuario"] == $_POST["ingUsuario"] &&
                    $respuesta["password"] == $encriptarPassword)) {

                    $_SESSION["iniciarSesion"] = "ok";
                    $_SESSION["idSesion"] = $respuesta["id"];

                    echo "<script>
                                    window.location='inicio';
                                    if (window.history.replaceState) { // verificamos disponibilidad
                                        window.history.replaceState(null, null, window.location.href);
                                    };
                               </script>";
                } else {
                    echo "<script>
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'error',
                                        title: 'Acceso denegado!',
                                        showConfirmButton: false,
                                        timer: 1300
                                    });
                                    if (window.history.replaceState) { // verificamos disponibilidad
                                        window.history.replaceState(null, null, window.location.href);
                                    }
                               </script>";
                }
            }
        }
    }


    //MOSTRAR USUARIOS
    //Este metodo es para mostrar los usuarios en la tabla con ajax, se relaciona con ajax/tablaUsuarios.ajax
    static public function ctrMostrarUsuarios($item, $valor)
    {
        $tabla1 = 'usuarios';
        $tabla2 = 'roles';
        $tabla3 = 'rutas';
        $respuesta = ModeloUsuarios::mdlMostrarUsuarios($tabla1, $tabla2, $tabla3, $item, $valor);

        return $respuesta; //Para devolver la informacion de nuevo a tablaUsuarios.ajax
    }

    //Registro de Usuarios
    //Se ejecuta antes de cerrar el form del modal registro de usuarios
    public function ctrRegistroUsuario()
    {
        if (isset($_POST["registroNombre"])) {
            # Validamos que no traiga el nombre caracteres especiales
            if (
                preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $_POST["registroNombre"]) &&
                preg_match('/^[a-zA-Z0-9]+$/', $_POST["registroUsuario"]) &&
                preg_match('/^[a-zA-Z0-9]+$/', $_POST["registroPassword"])
            ) {

                if (isset($_POST["registroLimite"])) {
                    $lim = $_POST["registroLimite"];
                } else {
                    $lim = 0;
                }

                if (isset($_POST["registroTabla"])) {
                    $tab = $_POST["registroTabla"];
                } else {
                    $tab = 1;
                }

                $encriptarPassword = crypt($_POST["registroPassword"], '$2a$07$usesomesillystringforsalt$');

                $tabla = 'usuarios';
                $tabla2 = 'vendedor_numero_limite';
                //Vamos a almacenar los datos en un array para poder enviarlos al modelo
                $datos = array(
                    "nombre" => $_POST["registroNombre"],
                    "usuario" => $_POST["registroUsuario"],
                    "password" => $encriptarPassword,
                    "tablaPremio" => $tab,
                    "idRol" => $_POST["registroRol"], //Como sale en el modelo
                    "idRuta" => $_POST["registroRuta"],
                    "limite" => $lim,
                );
                //Pedimos una respuesta de usuarios.modelo
                $respuesta = ModeloUsuarios::mdlRegistroUsuarios($tabla, $tabla2, $datos);
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

                    function recargar(){
                        location.reload();
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

    public function ctrEditarUsuario()
    {
        if (isset($_POST["editarId"])) {
            # Validamos que no traiga el nombre caracteres especiales
            if (
                preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $_POST["editarNombre"]) &&
                preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarUsuario"]) &&
                preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarPassword"])
            ) {

                if (isset($_POST["editarLimite"])) {
                    $editarLimite = $_POST["editarLimite"];
                } else {
                    $editarLimite = -1;
                }

                $encriptarPassword = crypt($_POST["editarPassword"], '$2a$07$usesomesillystringforsalt$');

                $tabla = 'usuarios';
                $tabla2 = 'vendedor_numero_limite';
                $id = $_POST["editarId"];

                //Vamos a almacenar los datos en un array para poder enviarlos al modelo
                $datos =  array(
                    "id" => $_POST["editarId"],
                    "nombre" => $_POST["editarNombre"],
                    "usuario" => $_POST["editarUsuario"],
                    "password" => $encriptarPassword,
                    "tablaPremio" => $_POST["editarTabla"],
                    "idRol" => $_POST["editarRol"], //Como sale en el modelo
                    "idRuta" => $_POST["editarRuta"],
                );
                //Pedimos una respuesta de usuarios.modelo
                $respuesta = ModeloUsuarios::mdlEditarUsuario($tabla, $tabla2, $datos, $editarLimite, $id);
                // echo '<pre>'; print_r($respuesta); echo '</pre>';

                if ($respuesta == "ok") {

                    echo "
                    <script>
                        Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Modificado Exitosamente!',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    function recargar(){
                        location.reload();
                    };

                    setTimeout('recargar()',1500);
                    
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

    static public function ctrEliminarUsuarios($id)
    {
        $tabla = "usuarios";
        $datos = array(
            "id" => $id
        );

        $respuesta = ModeloUsuarios::mdlEliminarUsuarios($tabla, $datos);

        return $respuesta;
    }
}
