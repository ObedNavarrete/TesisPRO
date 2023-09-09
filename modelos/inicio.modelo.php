<?php
require_once "conexion.php";

class ModeloInicio {
    /*==========================================
    Mostrar Roles de Usuario
    ==========================================*/
    static public function mdlMostrarTotalVentasInicio($tabla1, $tabla2, $tabla3, $item, $valor) {
        if ($item != null && $valor != null) {
            $stmt = Conexion::conectar()->prepare(
                "SELECT sum(v.inversion) from $tabla1 v
                inner join $tabla2 s on v.idSorteo = s.id
                inner join $tabla3 u on u.id = v.idVendidoPor
                WHERE $item = $valor
                AND v.pasivo = 0
                AND DATE_FORMAT(v.fecha, '%Y-%m-%d') = CURDATE()
                AND CURTIME() >= s.inicio
                AND CURTIME() < s.fin"
            );

            //$stmt->bindParam(":" . $item, $valor, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
        } else {

            $stmt = Conexion::conectar()->prepare(
                "SELECT sum(v.inversion) from $tabla1 v
                inner join $tabla2 s on v.idSorteo = s.id
                inner join $tabla3 u on u.id = v.idVendidoPor
                WHERE v.pasivo = 0
                AND DATE_FORMAT(v.fecha, '%Y-%m-%d') = CURDATE()
                AND CURTIME() >= s.inicio
                AND CURTIME() < s.fin"
            );

            $stmt->execute();
            return $stmt->fetch();
        }
    }

    static public function mdlMostrarMaximoVendedor($tabla1, $tabla2, $tabla3, $item, $valor) {
        if ($item != null && $valor != null) {
            $stmt = Conexion::conectar()->prepare(
                "SELECT
                sum(r.monto) as sumatoria,
                count(r.codigo) as boletos,
                u.nombre as nombre
                from $tabla1 r
                inner join $tabla2 u on r.idVendidoPor = u.id
                inner join $tabla3 s on r.idSorteo = s.id
                WHERE $item = $valor
                AND r.pasivo = 0
                AND DATE_FORMAT(r.fecha, '%Y-%m-%d') = CURDATE()
                AND CURTIME() >= s.inicio
                AND CURTIME() < s.fin
                group by u.usuario, s.sorteo
                order by sum(r.monto) desc limit 1"
            );

            //$stmt->bindParam(":" . $item, $valor, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
        } else {

            $stmt = Conexion::conectar()->prepare(
                "SELECT
                sum(r.monto) as sumatoria,
                count(r.codigo) as boletos,
                u.nombre as nombre
                from $tabla1 r
                inner join $tabla2 u on r.idVendidoPor = u.id
                inner join $tabla3 s on r.idSorteo = s.id
                WHERE r.pasivo = 0
                AND DATE_FORMAT(r.fecha, '%Y-%m-%d') = CURDATE()
                AND CURTIME() >= s.inicio
                AND CURTIME() < s.fin
                group by u.usuario, s.sorteo
                order by sum(r.monto) desc limit 1"
            );

            $stmt->execute();
            return $stmt->fetch();
        }
    }

    static public function mdlMostrarConteoUsuarios($tabla, $item, $valor) {
        if ($item != null && $valor != null) {
            $stmt = Conexion::conectar()->prepare(
                "SELECT count(u.id) from $tabla u 
                where u.idRol = 2 and u.pasivo = 0
                AND $item = $valor"
            );

            //$stmt->bindParam(":" . $item, $valor, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
        } else {

            $stmt = Conexion::conectar()->prepare(
                "SELECT count(u.id) from $tabla u 
                where u.idRol = 2 and u.pasivo = 0"
            );

            $stmt->execute();
            return $stmt->fetch();
        }
    }
}