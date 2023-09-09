<?php
require_once "conexion.php";

class ModeloAdminVentasLimite
{
    /*MOSTRAR USUARIOS*/
    static public function mdlMostrarVentasLimite($tabla1, $tabla2, $tabla3, $item, $valor)
    {
        if ($item != null && $valor != null) {
            $stmt = Conexion::conectar()->prepare(
                "SELECT
                vnl.id as id,
                vnl.idNumero as idNumero,
                vnl.idVendedor as idVendedor,
                u.idRuta as ruta,
                u.nombre as nombre,
                n.numero as numero,
                vnl.limite as limite
                from $tabla1 vnl
                inner join $tabla2 n on vnl.idNumero = n.id
                inner join $tabla3 u on vnl.idVendedor = u.id
                WHERE vnl.$item = :$item
                AND vnl.pasivo = 0 AND u.pasivo = 0"
            );

            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

            // //Tambien podria hacerse de esta manera
            // $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla where $item = $valor");

            $stmt->execute();
            return $stmt->fetch();
        } else {
            //Para mostrar todos los datos de la tabla en la seccion de usuarios
            $stmt = Conexion::conectar()->prepare(
                "SELECT
                vnl.id as id,
                u.nombre as nombre,
                u.idRuta as ruta,
                n.numero as numero,
                vnl.limite as limite
                from $tabla1 vnl
                inner join $tabla2 n on vnl.idNumero = n.id
                inner join $tabla3 u on vnl.idVendedor = u.id
                AND vnl.pasivo = 0 AND u.pasivo = 0"
            );

            $stmt->execute();

            return $stmt->fetchAll();
        }
    }

    static public function mdlMostrarVentasLimiteAlVender($tabla1, $tabla2, $tabla3, $item, $valor)
    {

        session_start();
        $ses = $_SESSION['idSesion'];

            $stmt = Conexion::conectar()->prepare(
                "SELECT
                vnl.id as id,
                vnl.idNumero as idNumero,
                vnl.idVendedor as idVendedor,
                u.nombre as nombre,
                n.numero as numero,
                vnl.limite as limite
                from $tabla1 vnl
                inner join $tabla2 n on vnl.idNumero = n.id
                inner join $tabla3 u on vnl.idVendedor = u.id
                WHERE vnl.$item = :$item AND vnl.idVendedor = $ses
                AND vnl.pasivo = 0"
            );

            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

            // //Tambien podria hacerse de esta manera
            // $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla where $item = $valor");

            $stmt->execute();
            return $stmt->fetch();
        
    }

        static public function mdlMostrarVentasLimiteAlVenderLoto($tabla1, $tabla2, $tabla3)
    {

        session_start();
        $ses = $_SESSION['idSesion'];

        $stmt = Conexion::conectar()->prepare(
            "SELECT
                vnl.id as id,
                vnl.idNumero as idNumero,
                vnl.idVendedor as idVendedor,
                u.nombre as nombre,
                n.numero as numero,
                vnl.limite as limite
                from $tabla1 vnl
                inner join $tabla2 n on vnl.idNumero = n.id
                inner join $tabla3 u on vnl.idVendedor = u.id
                WHERE vnl.idNumero = 80 AND vnl.idVendedor = $ses
                AND vnl.pasivo = 0"
        );

        $stmt->execute();
        return $stmt->fetch();
    }



    static public function mdlRegistroVentaLimite($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(idNumero, idVendedor, limite)
            VALUES (:idNumero, :idVendedor, :limite)");

        $stmt->bindParam(':idNumero', $datos["idNumero"], PDO::PARAM_INT);
        $stmt->bindParam(':idVendedor', $datos["idVendedor"], PDO::PARAM_INT);
        $stmt->bindParam(':limite', $datos["limite"], PDO::PARAM_INT);
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
                        title: 'ERROR: Contacte al administrador del sistema!',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    </script>
                    ";
        }
    }

    static public function mdlEditarVentaLimite($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET limite = :limite WHERE id = :id");

        $stmt->bindParam(":limite", $datos["limite"], PDO::PARAM_INT);
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
                        title: 'ERROR: Contacte al administrador del sistema!',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    </script>
                    ";
        }
    }
}
