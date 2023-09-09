<?php
require_once "conexion.php";

class ModeloRecibos {
        /**********************************VENDEDORES************************************/
    /*VER VENTAS */
    static public function mdlMostrarVentasVendedor($tabla1, $tabla2, $tabla3, $item, $valor)
    {

        if ($item != null && $valor != null) {
            $stmt = Conexion::conectar()->prepare(
                "SELECT distinct(v.codigo) as codigo,
                s.sorteo as sorteo,
                count(v.codigo) as numeros ,
                sum(v.inversion) as monto,
                date(v.fecha) as fecha,
                u.nombre as vende,
                TIME_FORMAT(v.fecha, '%H:%i') as id,
                TIME_FORMAT(v.fecha, '%h:%i') as hora
                ,v.pasivo as pasivo
                from $tabla1 v
                inner join $tabla3 s on v.idSorteo = s.id
                inner join $tabla2 u on v.idVendidoPor = u.id
                where v.$item = :item
                and date(v.fecha) = curdate() 
                AND CURTIME() >= s.inicio
                AND CURTIME() < s.fin
                group by v.codigo
                order by hora desc;"
            );

            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

            // //Tambien podria hacerse de esta manera
            // $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla where $item = $valor");

            $stmt->execute();
            return $stmt->fetch();
        } else {

            $ses = $_SESSION['idSesion'];
            $stmt = Conexion::conectar()->prepare(
                "SELECT distinct(v.codigo) as codigo,
                s.sorteo as sorteo,
                count(v.codigo) as numeros ,
                sum(v.inversion) as monto,
                date(v.fecha) as fecha,
                u.nombre as vende,
                TIME_FORMAT(v.fecha, '%H:%i') as id,
                TIME_FORMAT(v.fecha, '%h:%i') as hora
                from $tabla1 v
                inner join $tabla3 s on v.idSorteo = s.id
                inner join $tabla2 u on v.idVendidoPor = u.id
                where v.idVendidoPor = $ses
                and date(v.fecha) = curdate() 
                AND CURTIME() >= s.inicio
                AND CURTIME() < s.fin
                and v.pasivo = 0
                group by v.codigo
                order by hora desc;"
            );

            $stmt->execute();

            return $stmt->fetchAll();
        }
    }

    /****************************************SUPERVISORES************************/
    /*VER VENTAS*/
    static public function mdlMostrarVentasSupervisor($tabla1, $tabla2, $tabla3)
    {
        if (isset($_SESSION["idSesion"])) {
            $usuarioIngreso = ControladorUsuarios::ctrMostrarUsuarios("id", $_SESSION["idSesion"]);
        }
        $ru = $usuarioIngreso["idRuta"];

        $stmt = Conexion::conectar()->prepare(
            "SELECT distinct(v.codigo) as codigo,
            s.sorteo as sorteo,
            count(v.codigo) as numeros ,
            sum(v.inversion) as monto,
            date(v.fecha) as fecha,
            u.nombre as vende,
            TIME_FORMAT(v.fecha, '%H:%i') as id,
            TIME_FORMAT(v.fecha, '%h:%i') as hora
            from $tabla1 v
            inner join $tabla3 s on v.idSorteo = s.id
            inner join $tabla2 u on v.idVendidoPor = u.id
            where u.idRuta = $ru
            and date(v.fecha) = curdate() 
            AND CURTIME() >= s.inicio
            AND CURTIME() < s.fin
            and v.pasivo = 0
            group by v.codigo
            order by hora desc, v.id desc;"
        );

        $stmt->execute();

        return $stmt->fetchAll();
    }

    /****************************************Administradores************************/
    /*VER VENTAS*/
    static public function mdlMostrarVentasAdministrador($tabla1, $tabla2, $tabla3)
    {
        $stmt = Conexion::conectar()->prepare(
            "SELECT distinct(v.codigo) as codigo,
            s.sorteo as sorteo,
            count(v.codigo) as numeros ,
            sum(v.inversion) as monto,
            date(v.fecha) as fecha,
            u.nombre as vende,
            TIME_FORMAT(v.fecha, '%H:%i') as id,
            TIME_FORMAT(v.fecha, '%h:%i') as hora
            ,v.pasivo as pasivo
            from $tabla1 v
            inner join $tabla3 s on v.idSorteo = s.id
            inner join $tabla2 u on v.idVendidoPor = u.id
            where date(v.fecha) = curdate() 
            AND CURTIME() >= s.inicio
            AND CURTIME() < s.fin
            group by v.codigo
            order by hora desc, v.id desc;"
        );

        $stmt->execute();

        return $stmt->fetchAll();
    }

static public function mdlMostrarVentasSorteoAnterior($tabla1, $tabla2, $tabla3, $item, $valor)
    {

        if ($item != null && $valor != null) {
            $stmt = Conexion::conectar()->prepare(
                "SELECT distinct(v.codigo) as codigo,
                count(v.codigo) as numeros ,
                sum(v.inversion) as monto,
                s.sorteo as sorteo,
                DATE_FORMAT(v.fecha, '%d/%m/%Y') as fecha,
                u.nombre as vende,
                TIME_FORMAT(v.fecha, '%H:%i') as id,
                TIME_FORMAT(v.fecha, '%h:%i') as hora,
                v.pasivo pasivo
                from $tabla1 v
                inner join $tabla3 u on v.idVendidoPor = u.id
                inner join sorteos s on s.id = v.idSorteo
                where 
                $item = $valor
                AND v.idSorteo = 
                (SELECT (g.idSorteo) from $tabla2 g order by g.fecha DESC limit 1)
                AND date(v.fecha) = 
                (SELECT date(g.fecha) from $tabla2 g order by g.fecha DESC limit 1)
                group by v.codigo
                order by hora desc, v.id desc"
            );

            //$stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

            // //Tambien podria hacerse de esta manera
            // $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla where $item = $valor");

            $stmt->execute();
            return $stmt->fetchAll();
        } else {

            $stmt = Conexion::conectar()->prepare(
                "SELECT distinct(v.codigo) as codigo,
                count(v.codigo) as numeros ,
                sum(v.inversion) as monto,
                s.sorteo as sorteo,
                date_format(v.fecha, '%d-%m-%y') as fecha,
                u.nombre as vende,
                TIME_FORMAT(v.fecha, '%H:%i') as id,
                TIME_FORMAT(v.fecha, '%h:%i') as hora,
                v.pasivo pasivo
                from $tabla1 v
                inner join $tabla3 u on v.idVendidoPor = u.id
                inner join sorteos s on s.id = v.idSorteo
                inner join (SELECT (g.idSorteo) as idS, date(g.fecha) as ff from ganadores g order by g.fecha DESC LIMIT 5) t
                on t.idS = v.idSorteo and t.ff = date(v.fecha)
                group by v.codigo;"
            );

            $stmt->execute();

            return $stmt->fetchAll();
        }
    }

        static public function mdlMostrarREC($valor)
    {

        $stmt = Conexion::conectar()->prepare(
            "SELECT s.sorteo as sorteo, v.idNumero as numero, v.inversion as inversion, v.premio as premio,
            TIME_FORMAT(v.fecha, '%h:%i %p') as hora, DATE_FORMAT(v.fecha, '%d-%m-%y') as fecha,
            u.nombre as vende, v.codigo as codigo
            from ventas v
            inner join sorteos s on v.idSorteo = s.id
            inner join usuarios u on v.idVendidoPor = u.id
            where v.codigo = '$valor';"
        );

        $stmt->execute();

        return $stmt->fetchAll();
    }
}


