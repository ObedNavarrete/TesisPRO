<?php
require_once "conexion.php";

class ModeloListas
{
    /*==========================================
    Mostrar Roles de Usuario
    ==========================================*/
    static public function mdlMostrarListas()
    {
        $stmt = Conexion::conectar()->prepare(
            "SELECT date(v.fecha) as fecha,
            DATE_FORMAT(v.fecha, '%d-%m-%Y') as fechax,
            v.idVendidoPor as idVendidoPor,
            s.id as idSorteo,
            u.nombre as nombre, s.sorteo as sorteo, sum(inversion) as ventas
            from ventas v
            inner join usuarios u on v.idVendidoPor = u.id
            inner join sorteos s on v.idSorteo = s.id
            inner join
                (SELECT (g.idSorteo) as idS, date(g.fecha) as ff from ganadores g order by g.fecha DESC LIMIT 5) t
            on t.idS = v.idSorteo and t.ff = date(v.fecha)
            where v.pasivo = 0
            group by date(v.fecha), u.nombre, s.sorteo
            order by date(fecha) desc, s.id desc;"
        );

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = null;
    }

    static public function mdlMostrarListasDetalle($vende, $fecha, $idsorteo)
    {
        $stmt = Conexion::conectar()->prepare(
            "SELECT s.sorteo as sorteo, u.nombre as nombre, 
            DATE_FORMAT(v.fecha, '%d-%m-%Y') as fechax,
            v.idNumero as numero, sum(v.inversion) as monto, sum(v.premio) as premio
            from ventas v
            inner join sorteos s on v.idSorteo = s.id
            inner join usuarios u on v.idVendidoPor = u.id
            where date(v.fecha) = '$fecha'
            and v.idVendidoPor = $vende
            and v.idSorteo = $idsorteo
            and v.pasivo = 0
            group by v.idNumero;"
        );

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = null;
    }
}
