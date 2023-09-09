<?php
require_once "conexion.php";

class ModeloVentas
{
    static public function mdlMostrarRecibos($tabla1, $tabla2, $tabla3, $item, $valor)
    {

        $stmt = Conexion::conectar()->prepare(
            "SELECT v.id as id,
            TIME_FORMAT(v.fecha, '%h:%i %p') as hora,
            v.codigo as codigo,
            n.numero as numero,
            v.inversion as inversion,
            v.premio as premio,
            DATE_FORMAT(v.fecha, '%d-%m-%Y') as fecha
            from $tabla1 v
            inner join $tabla2 n on v.idNumero = n.id
            inner join $tabla3 u on v.idVendidoPor = u.id
            where v.$item = :$item"
        );

        $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

        $stmt->execute();
        return $stmt->fetchAll();
    }

    static public function mdlMostrarVentasAlVender($tabla1, $tabla2, $tabla3, $item, $valor)
    {

        session_start();
        $ses = $_SESSION['idSesion'];

        $stmt = Conexion::conectar()->prepare(
            "SELECT SUM(v.premio) as inversion 
            from $tabla1 v
            inner join $tabla2 n on v.idNumero = n.id 
            inner join $tabla3 s on v.idSorteo = s.id
            WHERE v.$item = :$item AND v.idVendidoPor = $ses
            AND v.pasivo = 0
            AND DATE_FORMAT(v.fecha, '%Y-%m-%d') = CURDATE()
            AND CURTIME() >= inicio
            AND CURTIME() < fin"
        );

        $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

        $stmt->execute();
        return $stmt->fetch();
    }

    /**********************************VENDEDORES************************************/
    /*VER VENTAS */
    static public function mdlMostrarVentasVendedor($tabla1, $tabla2, $tabla3, $item, $valor)
    {

        if ($item != null && $valor != null) {
            $stmt = Conexion::conectar()->prepare(
                "SELECT v.id as id, n.numero as numero, v.fecha as fecha,
                s.sorteo as sorteo, i.inversion as inversion, i.premio as premio 
                from $tabla1 v
                inner join $tabla2 n on v.idNumero = n.id 
                inner join $tabla3 s on v.idSorteo = s.id
                WHERE v.$item = :$item
                AND v.pasivo = 0
                AND DATE_FORMAT(fecha, '%Y-%m-%d') = CURDATE()
                AND CURTIME() >= inicio
                AND CURTIME() < fin"
            );

            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

            // //Tambien podria hacerse de esta manera
            // $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla where $item = $valor");

            $stmt->execute();
            return $stmt->fetch();
        } else {
            $ses = $_SESSION['idSesion'];

            $stmt = Conexion::conectar()->prepare(
                "SELECT
                v.id as id, v.inversion as inversion,
                TIME_FORMAT(v.fecha, '%h:%i %p') as hora,
                n.numero as numero,
                v.premio as premio
                from $tabla1 v
                inner join $tabla2 n on v.idNumero = n.id
                inner join $tabla3 s on v.idSorteo = s.id
                AND v.idVendidoPor = $ses
                AND v.pasivo = 0
                AND DATE_FORMAT(fecha, '%Y-%m-%d') = CURDATE()
                AND CURTIME() >= inicio
                AND CURTIME() < fin order by id desc"
            );

            $stmt->execute();

            return $stmt->fetchAll();
        }
    }

    /*VER VENTAS NUM */
    static public function mdlMostrarVentasVendedorNum($tabla1, $tabla2, $tabla3, $item, $valor)
    {
        $ses = $_SESSION['idSesion'];

        $stmt = Conexion::conectar()->prepare(
            "SELECT
                count(v.id) as boletos,
                sum(v.inversion) as inversion,
                n.numero as numero,
                sum(v.premio) as premio
                from $tabla1 v
                inner join $tabla2 n on v.idNumero = n.id
                inner join $tabla3 s on v.idSorteo = s.id
                AND v.idVendidoPor = $ses
                AND v.pasivo = 0
                AND DATE_FORMAT(fecha, '%Y-%m-%d') = CURDATE()
                AND CURTIME() >= inicio
                AND CURTIME() < fin
                group by n.numero"
        );

        $stmt->execute();

        return $stmt->fetchAll();
    }

    /****************************************SUPERVISORES************************/
    /*VER VENTAS*/
    static public function mdlMostrarVentasSupervisor($tabla1, $tabla2, $tabla3, $tabla4)
    {
        if (isset($_SESSION["idSesion"])) {
            $usuarioIngreso = ControladorUsuarios::ctrMostrarUsuarios("id", $_SESSION["idSesion"]);
        }
        $ru = $usuarioIngreso["idRuta"];

        $stmt = Conexion::conectar()->prepare(
            "SELECT
                v.id as id, v.inversion as inversion,
                TIME_FORMAT(v.fecha, '%h:%i %p') as hora,
                u.nombre as nombre,
                n.numero as numero,
                v.premio as premio
                from $tabla1 v
                inner join $tabla2 n on v.idNumero = n.id
                inner join $tabla3 s on v.idSorteo = s.id
                inner join $tabla4 u on u.id = v.idVendidoPor
                AND u.idRuta = $ru
                AND v.pasivo = 0
                AND DATE_FORMAT(v.fecha, '%Y-%m-%d') = CURDATE()
                AND CURTIME() >= inicio
                AND CURTIME() < fin order by id desc"
        );

        $stmt->execute();

        return $stmt->fetchAll();
    }

    /*VER VENTAS NUM */
    static public function mdlMostrarVentasSupervisorNum($tabla1, $tabla2, $tabla3, $tabla4)
    {
        if (isset($_SESSION["idSesion"])) {
            $usuarioIngreso = ControladorUsuarios::ctrMostrarUsuarios("id", $_SESSION["idSesion"]);
        }
        $ru = $usuarioIngreso["idRuta"];

        $stmt = Conexion::conectar()->prepare(
            "SELECT
                count(v.id) as boletos,
                sum(v.inversion) as inversion,
                n.numero as numero,
                sum(v.premio) as premio
                from $tabla1 v
                inner join $tabla2 n on v.idNumero = n.id
                inner join $tabla3 s on v.idSorteo = s.id
                inner join $tabla4 u on u.id = v.idVendidoPor
                AND u.idRuta = $ru
                AND v.pasivo = 0
                AND DATE_FORMAT(v.fecha, '%Y-%m-%d') = CURDATE()
                AND CURTIME() >= inicio
                AND CURTIME() < fin
                group by n.numero"
        );

        $stmt->execute();

        return $stmt->fetchAll();
    }

    /****************************************Administradores************************/
    /*VER VENTAS*/
    static public function mdlMostrarVentasAdministrador($tabla1, $tabla2, $tabla3, $tabla4)
    {
        $stmt = Conexion::conectar()->prepare(
            "SELECT
                v.id as id, v.inversion as inversion,
                TIME_FORMAT(v.fecha, '%h:%i %p') as hora,
                u.nombre as nombre,
                n.numero as numero,
                v.premio as premio
                from $tabla1 v
                inner join $tabla2 n on v.idNumero = n.id
                inner join $tabla3 s on v.idSorteo = s.id
                inner join $tabla4 u on u.id = v.idVendidoPor
                AND v.pasivo = 0
                AND DATE_FORMAT(v.fecha, '%Y-%m-%d') = CURDATE()
                AND CURTIME() >= inicio
                AND CURTIME() < fin order by id desc"
        );

        $stmt->execute();

        return $stmt->fetchAll();
    }

    /*VER VENTAS NUM */
    static public function mdlMostrarVentasAdministradorNum($tabla1, $tabla2, $tabla3, $tabla4)
    {
        $stmt = Conexion::conectar()->prepare(
            "SELECT
                count(v.id) as boletos,
                sum(v.inversion) as inversion,
                n.numero as numero,
                sum(v.premio) as premio
                from $tabla1 v
                inner join $tabla2 n on v.idNumero = n.id
                inner join $tabla3 s on v.idSorteo = s.id
                inner join $tabla4 u on u.id = v.idVendidoPor
                AND v.pasivo = 0
                AND DATE_FORMAT(v.fecha, '%Y-%m-%d') = CURDATE()
                AND CURTIME() >= inicio
                AND CURTIME() < fin
                group by n.numero"
        );

        $stmt->execute();

        return $stmt->fetchAll();
    }

    static public function mdlRegistroVentas($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare(
            "INSERT INTO $tabla(idNumero, idSorteo, inversion, premio, idVendidoPor, codigo)
            VALUES (:idNumero, :idSorteo, :inversion, :premio, :idVendidoPor, :codigo)"
        );

        $stmt->bindParam(":idNumero", $datos["idNumero"], PDO::PARAM_INT);
        $stmt->bindParam(":idSorteo", $datos["idSorteo"], PDO::PARAM_INT);
        $stmt->bindParam(":inversion", $datos["inversion"], PDO::PARAM_INT);
        $stmt->bindParam(':premio', $datos["premio"], PDO::PARAM_INT);
        $stmt->bindParam(":idVendidoPor", $datos["idVendidoPor"], PDO::PARAM_INT);
        $stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        } else {
            echo "\nPDOStatement::errorInfo():\n";
            print_r(Conexion::conectar()->errorInfo());
            echo "
                    <script>
                        Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'ERROR: No guarda en el modelo',
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

    static public function mdlRegistroRecibos($recibos, $suma, $codigo, $cantidadNumeros, $vende, $sorteo){

        $stmt = Conexion::conectar()->prepare(
            "INSERT INTO $recibos(codigo, cantidadNumeros, monto, idVendidoPor, idSorteo)
            VALUES (:codigo, :cantidadNumeros, :monto, :idVendidoPor, :idSorteo)"
        );

        $stmt->bindParam(":codigo", $codigo, PDO::PARAM_STR);
        $stmt->bindParam(":cantidadNumeros", $cantidadNumeros, PDO::PARAM_INT);
        $stmt->bindParam(":monto", $suma, PDO::PARAM_INT);
        $stmt->bindParam(":idVendidoPor", $vende, PDO::PARAM_INT);
        $stmt->bindParam(":idSorteo", $sorteo, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            echo "\nPDO::errorInfo():\n";
            print_r(Conexion::conectar()->errorInfo());
            echo "
                    <script>
                        Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'ERROR: No guarda en el modelo OK',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    </script>
                    ";
        }

    }


    static public function mdlEliminarVentas($tabla, $tabla2, $datos)
    {

        $stmt = Conexion::conectar()->prepare(
            "UPDATE $tabla SET pasivo = 1
            WHERE codigo = :codigo"
        );

        $stmt->bindParam(':codigo', $datos["codigo"], PDO::PARAM_STR);

        $stmt2 = Conexion::conectar()->prepare(
            "UPDATE $tabla2 SET pasivo = 1
            WHERE codigo = :codigo"
        );
        $stmt2->bindParam(':codigo', $datos["codigo"], PDO::PARAM_STR);

        if ($stmt->execute() AND $stmt2->execute()) {
            return "ok";
        } else {

            echo "
                    <script>
                        Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'ERROR: No puede tener dos números iguales',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    if (window.history.replaceState) { // verificamos disponibilidad
                        window.history.replaceState(null, null, window.location.href);
                    }
                    
                    </script>
                    ";
        }
        $stmt = null;
    }

     /*VER LISTA VENDEDORES SUPERVISOR */
     static public function mdlMostrarListaVendedeoresSupervisor($tabla1, $tabla2, $tabla3)
     {
        if (isset($_SESSION["idSesion"])) {
            $usuarioIngreso = ControladorUsuarios::ctrMostrarUsuarios("id", $_SESSION["idSesion"]);
        }
        $ru = $usuarioIngreso["idRuta"];

         $stmt = Conexion::conectar()->prepare(
             "SELECT sum(v.inversion) as sumatoria,
            count(distinct(v.codigo)) as boletos,
            u.idRuta as ruta, u.nombre as nombre
            from $tabla1 v inner join $tabla2 u
            on v.idVendidoPor = u.id
            inner join $tabla3 s on v.idSorteo = s.id
            WHERE DATE_FORMAT(v.fecha, '%Y-%m-%d') = CURDATE()
            AND CURTIME() >= inicio
            AND CURTIME() < fin 
            AND v.pasivo = 0
            AND u.idRuta = $ru
            group by u.usuario, s.sorteo;"
         );
 
         $stmt->execute();
 
         return $stmt->fetchAll();
     }

     /*VER LISTA VENDEDORES ADMIN */
     static public function mdlMostrarListaVendedeoresAdministrador($tabla1, $tabla2, $tabla3)
     {
         $stmt = Conexion::conectar()->prepare(
            "SELECT sum(v.inversion) as sumatoria,
            count(distinct(v.codigo)) as boletos,
            u.idRuta as ruta, u.nombre as nombre
            from $tabla1 v inner join $tabla2 u
            on v.idVendidoPor = u.id
            inner join $tabla3 s on v.idSorteo = s.id
            WHERE DATE_FORMAT(v.fecha, '%Y-%m-%d') = CURDATE()
            AND CURTIME() >= inicio
            AND CURTIME() < fin 
            and v.pasivo = 0
            group by u.usuario, s.sorteo;"
         );
 
         $stmt->execute();
 
         return $stmt->fetchAll();
     }

     /*MOSTRAR VENTAS GANADOR*/
     static public function mdlMostrarVentasGanador($tabla1, $tabla2, $tabla3, $item, $valor)
    {
        $stmt = Conexion::conectar()->prepare(
            "SELECT COALESCE(SUM(v.premio),0) as premio,
             COALESCE(SUM(v.inversion),0) as inversion
            from $tabla1 v
            inner join $tabla2 n on v.idNumero = n.id 
            inner join $tabla3 s on v.idSorteo = s.id
            WHERE v.$item = $valor
            AND v.pasivo = 0
            AND DATE_FORMAT(v.fecha, '%Y-%m-%d') = CURDATE()
            AND CURTIME() >= inicio
            AND CURTIME() < fin"
        );

        //$stmt->bindParam(":" . $item, $valor, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetch();
    }

    static public function mdlMostrarVentasNoDetalle($tabla1, $tabla2, $tabla3, $tabla4, $item, $valor)
    {
        $stmt = Conexion::conectar()->prepare(
            "SELECT
            u.nombre as nombre,
            v.codigo as boleto,
            v.inversion as monto,
            v.premio as premio,
            u.idRuta as ruta
            from $tabla1 v
            inner join $tabla2 n on v.idNumero = n.id
            inner join $tabla3 s on v.idSorteo = s.id
            inner join $tabla4 u on v.idVendidoPor = u.id
            WHERE v.$item = $valor
            AND v.pasivo = 0
            AND DATE_FORMAT(v.fecha, '%Y-%m-%d') = CURDATE()
            AND CURTIME() >= inicio
            AND CURTIME() < fin"
        );

        //$stmt->bindParam(":" . $item, $valor, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll();
    }
}
