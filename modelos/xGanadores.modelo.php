<?php
require_once "conexion.php";

class ModeloGanadoresLoteria
{
    static public function mdlMostrarGanadores($tabla1, $tabla2, $item, $valor)
    {
        if ($item != null && $valor != null) {
            $stmt = Conexion::conectar()->prepare(
                "SELECT
                g.id as id,
                g.fecha as fecha,
                n.numero as ganador,
                g.inversion as inversion,
                g.premio as premio,
                g.venta_total as venta_sorteo,
                g.utilidad as utilidad
                from
                $tabla1 g
                inner join $tabla2 n on g.idNumero = n.id
                WHERE $item = :$item AND g.pasivo = 0 order by g.id desc"
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
                g.id as id,
                g.fecha as fecha,
                n.numero as ganador,
                g.inversion as inversion,
                g.premio as premio,
                g.venta_total as venta_sorteo,
                g.utilidad as utilidad
                from
                $tabla1 g
                inner join $tabla2 n on g.idNumero = n.id
                WHERE g.pasivo = 0 order by g.id desc"
            );

            $stmt->execute();

            return $stmt->fetchAll();
        }
    }

    static public function mdlRegistroGanadores($tabla, $datos)
    {

        $stmt = Conexion::conectar()->prepare(
            "INSERT INTO $tabla(idNumero, inversion, premio, utilidad, venta_total)
            VALUES (:idNumero, :inversion, :premio, :utilidad, :venta_total)"
        );

        $stmt->bindParam(":idNumero", $datos["idNumero"], PDO::PARAM_INT);
        $stmt->bindParam(":inversion", $datos["inversion"], PDO::PARAM_INT);
        $stmt->bindParam(":premio", $datos["premio"], PDO::PARAM_INT);
        $stmt->bindParam(":utilidad", $datos["utilidad"], PDO::PARAM_INT);
        $stmt->bindParam(":venta_total", $datos["venta_total"], PDO::PARAM_INT);
        //Igual a como sale en el controlador

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
                        title: 'ERROR: HERE',
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

    static public function mdldetalleGanadores($tabla1, $tabla3, $tabla4, $tabla5, $item, $valor)
    {

        if ($item != null && $valor != null) {
            $stmt = Conexion::conectar()->prepare(
                "SELECT
                date_format(v.fecha, '%d/%m/%Y') as fecha,
                u.nombre as usuario,
                u.idRuta as ruta,
                sum(v.inversion) as ventas,
                coalesce((
                    select sum(vv.inversion)
                    from $tabla1 vv
                    inner join $tabla5 gg on gg.idNumero = vv.idNumero
                    and date(vv.fecha) = date(gg.fecha)
                    where vv.pasivo = 0
                    and vv.idVendidoPor = v.idVendidoPor
                    and date(vv.fecha) = date(v.fecha)
                             ),0) as ventaGanador,
                coalesce((
                    select sum(vv.premio)
                    from $tabla1 vv
                    inner join $tabla5 gg on gg.idNumero = vv.idNumero
                    and date(vv.fecha) = date(gg.fecha)
                    where vv.pasivo = 0
                    and vv.idVendidoPor = v.idVendidoPor
                    and date(vv.fecha) = date(v.fecha)
                             ),0) as premioGanador
                from $tabla1 v
                inner join $tabla3 n on v.idNumero = n.id
                inner join $tabla4 u on v.idVendidoPor = u.id
                where v.pasivo = 0
                AND $item = $valor
                group by date_format(v.fecha, '%d/%m/%Y'), u.nombre
                order by date(v.fecha) desc limit 500"
            );

            $stmt->execute();

            return $stmt->fetchAll();
        } else {
            $stmt = Conexion::conectar()->prepare(
                "SELECT
                date_format(v.fecha, '%d/%m/%Y') as fecha,
                u.nombre as usuario,
                u.idRuta as ruta,
                sum(v.inversion) as ventas,
                coalesce((
                    select sum(vv.inversion)
                    from $tabla1 vv
                    inner join $tabla5 gg on gg.idNumero = vv.idNumero
                    and date(vv.fecha) = date(gg.fecha)
                    where vv.pasivo = 0
                    and vv.idVendidoPor = v.idVendidoPor
                    and date(vv.fecha) = date(v.fecha)
                             ),0) as ventaGanador,
                coalesce((
                    select sum(vv.premio)
                    from $tabla1 vv
                    inner join $tabla5 gg on gg.idNumero = vv.idNumero
                    and date(vv.fecha) = date(gg.fecha)
                    where vv.pasivo = 0
                    and vv.idVendidoPor = v.idVendidoPor
                    and date(vv.fecha) = date(v.fecha)
                             ),0) as premioGanador
                from $tabla1 v
                inner join $tabla3 n on v.idNumero = n.id
                inner join $tabla4 u on v.idVendidoPor = u.id
                where v.pasivo = 0
                group by date_format(v.fecha, '%d/%m/%Y'), u.nombre
                order by date(v.fecha) desc limit 500"
            );

            $stmt->execute();

            return $stmt->fetchAll();
        }
    }

    /* static public function mdlGraficoUtilidad($tabla)
    {
        $stmt = Conexion::conectar()->prepare(
            "SELECT date_format(g.fecha,'%d/%m') as fecha, 
                sum(g.utilidad) as ganancia 
                FROM $tabla g WHERE g.pasivo = false
                group by date_format(g.fecha,'%d/%m')
                limit 15;"
        );

        $stmt->execute();
        return $stmt->fetchAll();
    } */
}
