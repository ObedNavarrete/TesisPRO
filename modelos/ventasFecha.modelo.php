<?php
require_once "conexion.php";

class ModeloVentasFecha
{
        /* VENTA TOTAL DE LOS VENDEDORES SIN FILTRO EN EL INICIO */
        static public function mdlMostrarVentaVendedores($tabla1, $tabla2)
        {
            //Para mostrar todos los datos de la tabla en la seccion de usuarios
            $stmt = Conexion::conectar()->prepare(
                "SELECT
                u.nombre as nombre, sum(v.inversion) totalvendido, u.idRuta as ruta,
                    CASE
                        WHEN sum(v.inversion) > 300 THEN (sum(v.inversion)*.12)
                        ELSE (sum(v.inversion)*.1)
                    END as salariovendedor
                from $tabla1 v
                inner join $tabla2 u on v.idVendidoPor = u.id
                where v.pasivo = false
                group by u.nombre
                order by u.nombre asc"
            );
    
            $stmt->execute();
    
            return $stmt->fetchAll();
        }

    /* VENTA TOTAL DE LOS VENDEDORES FECHA EN EL INICIO */
    static public function mdlMostrarVentasTotalesVendedorFechaXXX($tabla1, $tabla2, $fechaInicial, $fechaFinal)
    {

        if ($fechaInicial == null) {

            $stmt = Conexion::conectar()->prepare(
                "SELECT
                u.nombre as nombre, sum(v.inversion) as totalvendido, u.idRuta as ruta,
                    CASE
                        WHEN sum(v.inversion) > 300 THEN (sum(v.inversion)*.12)
                        ELSE (sum(v.inversion)*.1)
                    END as salariovendedor
                from $tabla1 v
                inner join $tabla2 u on v.idVendidoPor = u.id
                where v.pasivo = false
                group by u.nombre
                order by u.nombre asc"
            );

            $stmt->execute();

            return $stmt->fetchAll();
        } else if ($fechaInicial == $fechaFinal) {

            $stmt = Conexion::conectar()->prepare(
                "SELECT
            u.nombre as nombre, sum(v.inversion) as totalvendido, u.idRuta as ruta,
                CASE
                        WHEN sum(v.inversion) > 300 THEN (sum(v.inversion)*.12)
                        ELSE (sum(v.inversion)*.1)
                END as salariovendedor
            from $tabla1 v
            inner join $tabla2 u on v.idVendidoPor = u.id
            WHERE date(v.fecha) = '$fechaFinal' and v.pasivo = false
            group by u.nombre
            order by u.nombre asc"
            );

            $stmt->bindParam(":fecha", $fechaFinal, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetchAll();
        } else {

            $stmt = Conexion::conectar()->prepare(
                "SELECT
            u.nombre as nombre, sum(v.inversion) as totalvendido, u.idRuta as ruta,
                CASE
                    WHEN sum(v.inversion) > 300 THEN (sum(v.inversion)*.12)
                    ELSE (sum(v.inversion)*.1)
                END as salariovendedor
            from $tabla1 v
            inner join $tabla2 u on v.idVendidoPor = u.id
            WHERE date(v.fecha) >= '$fechaInicial' AND date(v.fecha) <= '$fechaFinal' and v.pasivo = false
            group by u.nombre
            order by u.nombre asc"
            );

            $stmt->execute();

            return $stmt->fetchAll();
        }
    }

    static public function mdlMostrarVentasTotalesVendedorFechaDDD($tabla1, $tabla2, $tabla3, $fechaInicial, $fechaFinal)
    {

        if ($fechaInicial == null) {

            $stmt = Conexion::conectar()->prepare(
                "SELECT
                u.nombre as nombre, coalesce(sum(v.inversion),0) as totalvendido,
                coalesce((select sum(vl.inversion)
                from $tabla3 vl
                where vl.idVendidoPor = u.id AND vl.pasivo = false),0) as loteria,
                u.idRuta as ruta,
                    CASE
                        WHEN sum(v.inversion) > 300 THEN (sum(v.inversion)*.12)
                        ELSE (sum(v.inversion)*.1)
                    END as salariovendedor
                from $tabla1 v
                inner join $tabla2 u on v.idVendidoPor = u.id
                where v.pasivo = false
                group by u.nombre
                order by u.nombre asc"
            );

            $stmt->execute();

            return $stmt->fetchAll();
        } else if ($fechaInicial == $fechaFinal) {

            $stmt = Conexion::conectar()->prepare(
                "SELECT
            u.nombre as nombre, coalesce(sum(v.inversion),0) as totalvendido, 
            coalesce((select sum(vl.inversion)
                from $tabla3 vl
                where vl.idVendidoPor = u.id AND vl.pasivo = false AND date(vl.fecha) = '$fechaFinal'),0) as loteria,
            u.idRuta as ruta,
                CASE
                        WHEN sum(v.inversion) > 300 THEN (sum(v.inversion)*.12)
                        ELSE (sum(v.inversion)*.1)
                END as salariovendedor
            from $tabla1 v
            inner join $tabla2 u on v.idVendidoPor = u.id
            WHERE date(v.fecha) = '$fechaFinal' and v.pasivo = false
            group by u.nombre
            order by u.nombre asc"
            );

            $stmt->bindParam(":fecha", $fechaFinal, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetchAll();
        } else {

            $stmt = Conexion::conectar()->prepare(
                "SELECT
            u.nombre as nombre, coalesce(sum(v.inversion),0) as totalvendido, 
            coalesce((select sum(vl.inversion)
                from $tabla3 vl
                where vl.idVendidoPor = u.id AND vl.pasivo = false and date(vl.fecha) >= '$fechaInicial' AND date(vl.fecha) <= '$fechaFinal'),0) as loteria,
            u.idRuta as ruta,
                CASE
                    WHEN sum(v.inversion) > 300 THEN (sum(v.inversion)*.12)
                    ELSE (sum(v.inversion)*.1)
                END as salariovendedor
            from $tabla1 v
            inner join $tabla2 u on v.idVendidoPor = u.id
            WHERE date(v.fecha) >= '$fechaInicial' AND date(v.fecha) <= '$fechaFinal' and v.pasivo = false
            group by u.nombre
            order by u.nombre asc"
            );

            $stmt->execute();

            return $stmt->fetchAll();
        }
    }


    static public function mdlMostrarVentasTotalesVendedorFecha($fechaInicial, $fechaFinal)
    {

        if ($fechaInicial == null) {

            $stmt = Conexion::conectar()->prepare(
                "SELECT
                u.nombre as usuario,
                u.idRuta as ruta,
                        ((sum(v.venta_sorteo)) +
                            IFNULL((SELECT sum(ve.venta_sorteo) from detalle_ganadores_loteria ve
                                WHERE ve.id_vendedor = v.id_vendedor),0)
                            )
                        as ventas,
                (IFNULL((
                    (select sum(vv.premio)
                    from detalle_ganadores vv
                    inner join ganadores gg on gg.idNumero = vv.id_numero
                    and date(vv.fecha) = date(gg.fecha)
                    and vv.id_sorteo = gg.idSorteo
                    where vv.id_vendedor = v.id_vendedor)
                    +
                    IFNULL((
                        SELECT sum(vv.premio)
                        from ventas_loteria vv
                        inner join ganadores_loteria gg on gg.idNumero = vv.idNumero
                        and date(vv.fecha) = date(gg.fecha)
                        where vv.pasivo = 0
                        and vv.idVendidoPor = v.id_vendedor),0
                        )
                ),0)) as premioGanador
                from detalle_ganadores v
                inner join sorteos s on v.id_sorteo = s.id
                inner join numeros n on v.id_numero = n.id
                inner join usuarios u on v.id_vendedor = u.id
                group by  u.nombre;"
            );

            //$stmt->bindParam(":fecha", $fechaFinal, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetchAll();
        } else {

            $stmt = Conexion::conectar()->prepare(
                "SELECT
                '$fechaInicial' as fechaInicial,
                '$fechaFinal' as fechaFinal,
                date(v.fecha) as fm,
                date_format(v.fecha, '%d/%m/%Y') as fecha,
                u.nombre as usuario,
                u.idRuta as ruta,
                        ((sum(v.venta_sorteo)) +
                            IFNULL((SELECT sum(ve.venta_sorteo) from detalle_ganadores_loteria ve
                                WHERE ve.id_vendedor = v.id_vendedor
                                AND date(ve.fecha) >= '$fechaInicial' AND date(ve.fecha) <= '$fechaFinal'),0)
                            )
                        as ventas,
                (IFNULL((
                    (select sum(vv.premio)
                    from detalle_ganadores vv
                    inner join ganadores gg on gg.idNumero = vv.id_numero
                    and date(vv.fecha) = date(gg.fecha)
                    and vv.id_sorteo = gg.idSorteo
                    where vv.id_vendedor = v.id_vendedor
                    AND date(vv.fecha) >= '$fechaInicial' AND date(vv.fecha) <= '$fechaFinal')
                    +
                    IFNULL((
                        SELECT sum(vv.premio)
                        from ventas_loteria vv
                        inner join ganadores_loteria gg on gg.idNumero = vv.idNumero
                        and date(vv.fecha) = date(gg.fecha)
                        where vv.pasivo = 0
                        and vv.idVendidoPor = v.id_vendedor
                            AND date(vv.fecha) >= '$fechaInicial' AND date(vv.fecha) <= '$fechaFinal'),0
                        )
                ),0)) as premioGanador
                from detalle_ganadores v
                inner join sorteos s on v.id_sorteo = s.id
                inner join numeros n on v.id_numero = n.id
                inner join usuarios u on v.id_vendedor = u.id
                AND date(v.fecha) >= '$fechaInicial' AND date(v.fecha) <= '$fechaFinal'
                group by  u.nombre;"
            );

            $stmt->execute();

            return $stmt->fetchAll();
        }
    }

}
