<?php
require_once "conexion.php";
include_once "/home/customer/www/rifadiaz.net/public_html/controladores/usuarios.controlador.php";
include_once "/home/customer/www/rifadiaz.net/public_html/modelos/usuarios.modelo.php";

class ModeloPremios
{

    /*MOSTRAR USUARIOS*/
    static public function mdlMostrarPremios($tabla, $item, $valor)
    {
        session_start();
    if (isset($_SESSION["idSesion"])) {
        $usuarioIngreso = ControladorUsuarios::ctrMostrarUsuarios("id", $_SESSION["idSesion"]);
    }

        $tablaPremio = $usuarioIngreso["idTabla"];

        if ($item != null && $valor != null) {
            $stmt = Conexion::conectar()->prepare(
                "SELECT t.id as id, t.inversion as inversion, 
                t.tablaPremio as tablaPremio,
                t.premio as premio FROM $tabla t 
                WHERE t.$item = :$item and t.tablaPremio = $tablaPremio
                AND pasivo = 0 ORDER BY inversion ASC"
            );

            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

            // //Tambien podria hacerse de esta manera
            // $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla where $item = $valor");

            $stmt->execute();
            return $stmt->fetch();
        } else {
            //Para mostrar todos los datos de la tabla en la seccion de usuarios
            $stmt = Conexion::conectar()->prepare(
                "SELECT t.id as id, t.inversion as inversion, 
                t.tablaPremio as tablaPremio,
                t.premio as premio FROM $tabla t
                WHERE pasivo = 0  ORDER BY inversion ASC"
            );

            $stmt->execute();

            return $stmt->fetchAll();
        }
    }

    /*MOSTRAR USUARIOS*/
        static public function mdlMostrarPremioEditar($tabla, $item, $valor)
        {
    
            if ($item != null && $valor != null) {
                $stmt = Conexion::conectar()->prepare(
                    "SELECT t.id as id, t.inversion as inversion, 
                    t.tablaPremio as tablaPremio,
                    t.premio as premio FROM $tabla t 
                    WHERE t.$item = :$item
                    AND pasivo = 0 ORDER BY inversion ASC"
                );
    
                $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
    
                // //Tambien podria hacerse de esta manera
                // $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla where $item = $valor");
    
                $stmt->execute();
                return $stmt->fetch();
            } else {
                //Para mostrar todos los datos de la tabla en la seccion de usuarios
                $stmt = Conexion::conectar()->prepare(
                    "SELECT t.id as id, t.inversion as inversion, 
                    t.tablaPremio as tablaPremio,
                    t.premio as premio FROM $tabla t
                    WHERE pasivo = 0  ORDER BY inversion ASC"
                );
    
                $stmt->execute();
    
                return $stmt->fetchAll();
            }
        }

    static public function mdlRegistroPremios($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare(
            "INSERT INTO $tabla(inversion, premio, tablaPremio)
            VALUES (:inversion, :premio, :tablaPremio)"
        );

        $stmt->bindParam(":inversion", $datos["inversion"], PDO::PARAM_INT);
        $stmt->bindParam(":premio", $datos["premio"], PDO::PARAM_INT);
        $stmt->bindParam(":tablaPremio", $datos["tablaPremio"], PDO::PARAM_INT);
        //Igual a como sale en el controlador

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
                        title: 'ERROR: No puede tener dos veces el mismo monto',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    </script>
                    ";
        }
    }

    //Para editar un Usuario
    static public function mdlEditarPremios($tabla, $datos)
    {

        $stmt = Conexion::conectar()->prepare(
            "UPDATE $tabla SET inversion = :inversion, premio = :premio WHERE id = :id"
        );

        $stmt->bindParam(":inversion", $datos["inversion"], PDO::PARAM_INT);
        $stmt->bindParam(":premio", $datos["premio"], PDO::PARAM_INT);
        $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
        //Igual a como sale en el controlador

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
                        title: 'ERROR: No puede tener dos números iguales',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    </script>
                    ";
        }
    }

    //Eliminar Usuarios
    static public function mdlEliminarPremios($tabla, $datos)
    {

        $stmt = Conexion::conectar()->prepare(
            "UPDATE $tabla SET pasivo = 1
            WHERE id = :id"
        );

        $stmt->bindParam(':id', $datos["id"], PDO::PARAM_INT);

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
                        title: 'ERROR: No puede tener dos números iguales',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    </script>
                    ";
        }
        $stmt = null;
    }
}
