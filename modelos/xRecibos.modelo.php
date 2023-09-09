<?php
require_once "conexion.php";

class ModeloRecibosLoteria
{
    /**********************************VENDEDORES************************************/
    /*VER VENTAS */
    static public function mdlMostrarVentasVendedor($tabla1, $tabla2, $item, $valor)
    {

        if ($item != null && $valor != null) {
            $stmt = Conexion::conectar()->prepare(
                "SELECT r.codigo as codigo,
                TIME_FORMAT(DATE_SUB(r.fecha, INTERVAL 0 HOUR), '%H:%i') as hora,
                TIME_FORMAT(r.fecha, '%h:%i') as horax,
                r.cantidadNumeros as numeros,
                r.monto as monto,
                u.nombre as vende
                from $tabla1 r
                inner join $tabla2 u on r.idVendidoPor = u.id
                WHERE v.$item = :$item
                AND v.pasivo = 0
                AND DATE_FORMAT(r.fecha, '%Y-%m-%d') = CURDATE()"
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
            count(v.codigo) as numeros ,
            sum(v.inversion) as monto,
            date(v.fecha) as fecha,
            u.nombre as vende,
            TIME_FORMAT(v.fecha, '%H:%i') as hora,
            TIME_FORMAT(v.fecha, '%h:%i') as horax
            from $tabla1 v
            inner join $tabla2 u on v.idVendidoPor = u.id
            where date(v.fecha) = curdate()
            AND v.idVendidoPor = $ses
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
    static public function mdlMostrarVentasSupervisor($tabla1, $tabla2)
    {
        if (isset($_SESSION["idSesion"])) {
            $usuarioIngreso = ControladorUsuarios::ctrMostrarUsuarios("id", $_SESSION["idSesion"]);
        }
        $ru = $usuarioIngreso["idRuta"];

        $stmt = Conexion::conectar()->prepare(
            "SELECT distinct(v.codigo) as codigo,
            count(v.codigo) as numeros ,
            sum(v.inversion) as monto,
            date(v.fecha) as fecha,
            u.nombre as vende,
            TIME_FORMAT(v.fecha, '%H:%i') as hora,
            TIME_FORMAT(v.fecha, '%h:%i') as horax
            from $tabla1 v
            inner join $tabla2 u on v.idVendidoPor = u.id
            where date(v.fecha) = curdate()
            AND u.idRuta = $ru
            and v.pasivo = 0
            group by v.codigo
            order by hora desc;"
        );

        $stmt->execute();

        return $stmt->fetchAll();
    }

    /****************************************Administradores************************/
    /*VER VENTAS*/
    static public function mdlMostrarVentasAdministrador($tabla1, $tabla2)
    {
        $stmt = Conexion::conectar()->prepare(
            "SELECT distinct(v.codigo) as codigo,
            count(v.codigo) as numeros ,
            sum(v.inversion) as monto,
            date(v.fecha) as fecha,
            u.nombre as vende,
            TIME_FORMAT(v.fecha, '%H:%i') as hora,
            TIME_FORMAT(v.fecha, '%h:%i') as horax
            ,v.pasivo as pasivo
            from $tabla1 v
            inner join $tabla2 u on v.idVendidoPor = u.id
            where date(v.fecha) = curdate()
            group by v.codigo
            order by hora desc;"
        );

        $stmt->execute();

        return $stmt->fetchAll();
    }

    static public function mdlMostrarRECLoteria($valor)
    {

        $stmt = Conexion::conectar()->prepare(
            "SELECT v.idNumero as numero, v.inversion as inversion, v.premio as premio,
            TIME_FORMAT(v.fecha, '%h:%i %p') as hora, DATE_FORMAT(v.fecha, '%d-%m-%y') as fecha,
            u.nombre as vende, v.codigo as codigo
            from ventas_loteria v
            inner join usuarios u on v.idVendidoPor = u.id
            where v.codigo = '$valor';"
        );

        $stmt->execute();

        return $stmt->fetchAll();
    }
}
