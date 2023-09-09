<?php
require_once "conexion.php";

class ModeloUsuarios
{
    /*MOSTRAR USUARIOS*/
    static public function mdlMostrarUsuarios($tabla1, $tabla2, $tabla3, $item, $valor)
    {
        //Me sirve para el logueo
        if ($item != null && $valor != null) {
            $stmt = Conexion::conectar()->prepare(
                "SELECT u.id AS id,
                u.tablaPremio AS idTabla,
                u.nombre AS nombre,
                u.usuario AS usuario,
                u.password AS password,
                u.imprime AS imprime,
                r.id AS idRol,
                r.nombre AS rol,
                ru.id as idRuta,
                ru.nombre as ruta
                FROM $tabla1 u
                INNER JOIN $tabla2 r
                ON u.idRol = r.id 
                INNER JOIN $tabla3 ru
                on u.idRuta = ru.id
                WHERE u.$item = :$item AND u.pasivo=0 and u.acceso = 0"
            );

            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

            // //Tambien podria hacerse de esta manera
            // $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla where $item = $valor");

            $stmt->execute();
            return $stmt->fetch();
        } else {
            //Para mostrar todos los datos de la tabla en la seccion de usuarios
            $stmt = Conexion::conectar()->prepare(
                "SELECT u.id AS id,
                u.nombre AS nombre,
                u.tablaPremio AS idTabla,
                u.usuario AS usuario, 
                u.password AS password,
                u.idRol as idRol,
                r.nombre AS rol,
                ru.id as idRuta,
                ru.nombre as ruta
                FROM $tabla1 u
                INNER JOIN $tabla2 r
                ON u.idRol = r.id
                INNER JOIN $tabla3 ru
                on u.idRuta = ru.id
                WHERE u.pasivo=0 ORDER BY u.id ASC"
            );

            $stmt->execute();

            return $stmt->fetchAll();
        }
    }

    //Para guardar un nuevo usuario
    static public function mdlRegistroUsuarios($tabla, $tabla2, $datos)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, usuario, password, tablaPremio, idRol, idRuta)
            VALUES (:nombre, :usuario, :password, :tablaPremio, :idRol, :idRuta)");

        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
        $stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
        $stmt->bindParam(':tablaPremio', $datos["tablaPremio"], PDO::PARAM_INT);
        $stmt->bindParam(':idRol', $datos["idRol"], PDO::PARAM_INT);
        $stmt->bindParam(':idRuta', $datos["idRuta"], PDO::PARAM_INT);
        //Igual a como sale en el controlador

        if ($stmt->execute()) {

            if ($datos["idRol"] == 2) {
                $obtenerIdRegistro = Conexion::conectar()->prepare(
                    "SELECT u.id from $tabla u order by u.id desc limit 1"
                );
                $obtenerIdRegistro->execute();

                $re = $obtenerIdRegistro->fetch();

                /*  echo var_dump($re[0]);
                $rr = json_encode($re);
                echo '<script>  ºº console.log( ' . htmlspecialchars(json_encode($re)) . ') </script>';
                */

                for ($i = 0; $i < 100; $i++) {
                    $query1 = Conexion::conectar()->prepare(
                        "INSERT INTO $tabla2 (idNumero,idVendedor,limite) 
                VALUES ('" . $i . "','" . ($re[0]) . "','" . $datos["limite"] . "')"
                    );
                    $query1->execute();
                }
            }

            return "ok";
        } else {
            /* echo "\nPDO::errorInfo():\n";
                print_r(Conexion::conectar()->errorInfo()); */

            echo "
                    <script>
                        Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'ERROR: No puede repetir el valor de << usuario >>',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    </script>
                    ";
        }
    }


    //Para editar un Usuario
    static public function mdlEditarUsuario($tabla, $tabla2, $datos, $editarLimite, $id)
    {
        if ($editarLimite > 0) {
            $stmt = Conexion::conectar()->prepare(
                "UPDATE $tabla SET nombre = :nombre, usuario = :usuario, 
                    password = :password, tablaPremio = :tablaPremio, idRol = :idRol, idRuta= :idRuta WHERE id = :id"
            );

            $stmt2 = Conexion::conectar()->prepare(
                "UPDATE $tabla2 SET limite = $editarLimite WHERE idVendedor = $id"
            );

            $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
            $stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
            $stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
            $stmt->bindParam(':tablaPremio', $datos["tablaPremio"], PDO::PARAM_INT);
            $stmt->bindParam(':idRol', $datos["idRol"], PDO::PARAM_INT);
            $stmt->bindParam(':idRuta', $datos["idRuta"], PDO::PARAM_INT);
            $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

            if ($stmt->execute() and $stmt2->execute()) {
                return "ok";
            } else {

                /* echo "\nPDO::errorInfo():\n";
                print_r(Conexion::conectar()->errorInfo()); */
                echo "
                        <script>
                            Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'ERROR: en el modelo',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        </script>
                        ";
            }
        } else if ($editarLimite == -1) {
            $stmt = Conexion::conectar()->prepare(
                "UPDATE $tabla SET nombre = :nombre, usuario = :usuario, 
                    password = :password, tablaPremio = :tablaPremio, idRol = :idRol, idRuta= :idRuta WHERE id = :id"
            );

            $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
            $stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
            $stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
            $stmt->bindParam(':tablaPremio', $datos["tablaPremio"], PDO::PARAM_INT);
            $stmt->bindParam(':idRol', $datos["idRol"], PDO::PARAM_INT);
            $stmt->bindParam(':idRuta', $datos["idRuta"], PDO::PARAM_INT);
            $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

            if ($stmt->execute()) {
                return "ok";
            } else {

                /* echo "\nPDO::errorInfo():\n";
                print_r(Conexion::conectar()->errorInfo()); */
                echo "
                        <script>
                            Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'ERROR: en el modelo',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        </script>
                        ";
            }
        } else {
            echo "
                        <script>
                            Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'ERROR: Límite Inválido',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        </script>
                        ";
        }
    }

    //Eliminar Usuarios
    static public function mdlEliminarUsuarios($tabla, $datos)
    {

        $stmt = Conexion::conectar()->prepare(
            "UPDATE $tabla SET pasivo = 1
            WHERE id = :id"
        );

        $stmt->bindParam(':id', $datos["id"], PDO::PARAM_INT);

        if ($stmt->execute()) {

            return "ok";
        } else {

            echo "\nPDO::errorInfo():\n";
            print_r(Conexion::conectar()->errorInfo());
        }
        $stmt = null;
    }
}
