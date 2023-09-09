<?php
require_once "conexion.php";

class ModeloGanadores
{
    static public function mdlMostrarGanadores($tabla1, $tabla2, $tabla3, $item, $valor)
    {
        if ($item != null && $valor != null) {
            $stmt = Conexion::conectar()->prepare(
                "SELECT
                g.id as id,
                s.sorteo as sorteo,
                s.id as idsorteo,
                g.fecha as fecha,
                n.numero as ganador,
                g.inversion as inversion,
                g.premio as premio,
                g.venta_total as venta_sorteo,
                g.utilidad as utilidad
                from
                $tabla1 g
                inner join $tabla2 n on g.idNumero = n.id
                inner join $tabla3 s on g.idSorteo = s.id
                WHERE $item = :$item AND g.pasivo = 0 order by g.id desc limit 90"
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
                s.sorteo as sorteo,
                s.id as idsorteo,
                g.fecha as fecha,
                n.numero as ganador,
                g.inversion as inversion,
                g.premio as premio,
                g.venta_total as venta_sorteo,
                g.utilidad as utilidad
                from
                $tabla1 g
                inner join $tabla2 n on g.idNumero = n.id
                inner join $tabla3 s on g.idSorteo = s.id
                WHERE g.pasivo = 0 order by g.id desc limit 90"
            );

            $stmt->execute();

            return $stmt->fetchAll();
        }
    }

    static public function mdlRegistroGanadores($tabla, $datos)
    {

        $gan = ControladorGanadores::ctrValidaUnGanador();
        
        if(($gan['fecha'] === $gan['fActual']) && ($gan['sorteo'] === $gan['sActual'])){
             echo "
                    <script>
                        Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Ya ha registrado el ganador!',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    if (window.history.replaceState) { // verificamos disponibilidad
                        window.history.replaceState(null, null, window.location.href);
                    }
                    
                    window.location.reload();

                    </script>
                    ";
        }else{

        $stmt = Conexion::conectar()->prepare(
            "INSERT INTO $tabla(idNumero, idSorteo, inversion, premio, utilidad, venta_total)
            VALUES (:idNumero, :idSorteo, :inversion, :premio, :utilidad, :venta_total)"
        );

        $stmt->bindParam(":idNumero", $datos["idNumero"], PDO::PARAM_INT);
        $stmt->bindParam(":idSorteo", $datos["idSorteo"], PDO::PARAM_INT);
        $stmt->bindParam(":inversion", $datos["inversion"], PDO::PARAM_INT);
        $stmt->bindParam(":premio", $datos["premio"], PDO::PARAM_INT);
        $stmt->bindParam(":utilidad", $datos["utilidad"], PDO::PARAM_INT);
        $stmt->bindParam(":venta_total", $datos["venta_total"], PDO::PARAM_INT);
        //Igual a como sale en el controlador
        }

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

    static public function mdldetalleGanadores($tabla1,$tabla2,$tabla3,$tabla4,$tabla5,$item,$valor){

        if ($item != null && $valor != null) {
            $stmt = Conexion::conectar()->prepare(
                "select dg.fecha fm, date_format(dg.fecha, '%d/%m/%Y') fecha, s.sorteo sorteo, u.idRuta ruta,
                    u.nombre usuario, dg.venta_sorteo ventas, dg.premio premioGanador, dg.utilidad utilidad
                from detalle_ganadores dg inner join sorteos s on dg.id_sorteo = s.id
                inner join numeros n on dg.id_numero = n.id
                inner join usuarios u on dg.id_vendedor = u.id
                where $item = $valor
                order by dg.fecha desc, dg.id_sorteo desc, u.idRuta, u.nombre limit 1700"
            );
    
            $stmt->execute();
    
            return $stmt->fetchAll();
        }else{
            $stmt = Conexion::conectar()->prepare(
                "select dg.fecha fm, date_format(dg.fecha, '%d/%m/%Y') fecha, s.sorteo sorteo, u.idRuta ruta,
                    u.nombre usuario, dg.venta_sorteo ventas, dg.premio premioGanador, dg.utilidad utilidad
                from detalle_ganadores dg inner join sorteos s on dg.id_sorteo = s.id
                inner join numeros n on dg.id_numero = n.id
                inner join usuarios u on dg.id_vendedor = u.id
                order by dg.fecha desc, dg.id_sorteo desc, u.idRuta, u.nombre limit 1700"
            );
    
            $stmt->execute();
    
            return $stmt->fetchAll();
        }
    }

    static public function mdlGraficoUtilidad($tabla, $tabla2){
        $stmt = Conexion::conectar()->prepare(
                "select date_format(g.fecha, '%m/%d')                         as fecha,
       date_format(g.fecha, '%d-%m')                         as fechax,
       (sum(g.venta_sorteo) +
        COALESCE((SELECT SUM(gl.venta_sorteo)
                  from detalle_ganadores_loteria gl
                  where date(gl.fecha) = date(g.fecha)), 0)) as venta,
       (sum(g.premio)
           +
        COALESCE((SELECT SUM(gl.premio)
                  from detalle_ganadores_loteria gl
                  where date(gl.fecha) = date(g.fecha)), 0)) as ganancia
        from detalle_ganadores g
        where date(g.fecha) >= date_add(NOW(), INTERVAL -10 DAY)
        AND YEAR(CURDATE()) = year(g.fecha)
        group by date(g.fecha)
        limit 10;"
            );

            $stmt->execute();
            return $stmt->fetchAll();
    }

    static public function mdlBtnGanador($tabla){
        $stmt = Conexion::conectar()->prepare(
                "SELECT date(g.fecha) as fecha, 
                g.idSorteo as id 
                from $tabla g 
                ORDER BY g.fecha desc limit 1"
            );

            $stmt->execute();
            return $stmt->fetch();
    }

    static public function mdlValidaUnGanador($tabla1, $tabla2){
        $stmt = Conexion::conectar()->prepare(
                "SELECT 
                (SELECT curdate()) as fActual, 
                date(g.fecha) as fecha, 
                (SELECT s.id from $tabla2 s 
                WHERE curtime() > s.inicio 
                and curtime() < s.fin) as sActual, 
                g.idSorteo as sorteo 
                from $tabla1 g 
                ORDER BY g.fecha 
                DESC LIMIT 1;"
            );

            $stmt->execute();
            return $stmt->fetch();
    }

    static public function mdlResumenDiario(){
        $stmt = Conexion::conectar()->prepare(
            "SELECT
            date(v.fecha) as fm,
            date_format(v.fecha, '%d/%m/%Y') as fecha,
            u.nombre as usuario,
            u.idRuta as ruta,
            ((sum(v.venta_sorteo)) +
                 coalesce((SELECT sum(ve.venta_sorteo) from detalle_ganadores_loteria ve
                    where date(ve.fecha) = date(v.fecha) and ve.id_vendedor = v.id_vendedor),0)
                 )
            as ventas,
            0 as ventaGanador,
            0 as ventaGanadorLoteria,
            (coalesce((
                (select sum(vv.premio)
                from detalle_ganadores vv
                inner join ganadores gg on gg.idNumero = vv.id_numero
                and date(vv.fecha) = date(gg.fecha)
                and vv.id_sorteo = gg.idSorteo
                where vv.id_vendedor = v.id_vendedor
                and date(vv.fecha) = date(v.fecha))
            ),0)) as premioGanador,
                    COALESCE((
                    SELECT sum(vv.premio)
                    from detalle_ganadores_loteria vv
                    inner join ganadores_loteria gg on gg.idNumero = vv.id_numero
                    and date(vv.fecha) = date(gg.fecha)
                    where vv.id_vendedor = v.id_vendedor
                    and date(vv.fecha) = date(v.fecha)),0
                    ) as premioGanadorLoteria
            from detalle_ganadores v
            inner join sorteos s on v.id_sorteo = s.id
            inner join usuarios u on v.id_vendedor = u.id
            where date(v.fecha) >= date_add(NOW(), INTERVAL -8 DAY)
            group by date(v.fecha), u.nombre
            order by v.fecha desc, s.id desc;"
        );

        $stmt->execute();
        return $stmt->fetchAll();
    }

    static public function mdlMostrarResumen($idnumero, $fecha, $idsorteo)
    {
        $stmt = Conexion::conectar()->prepare(
            "SELECT u.idRuta as ruta,
             sum(inversion) as ventas,
            (select sum(vv.premio)
            from ventas vv
            inner join usuarios uu on uu.id = vv.idVendidoPor
            where vv.idNumero = $idnumero
              and date(vv.fecha) = date('$fecha')
              and vv.idSorteo = $idsorteo
              and vv.pasivo = false
              and uu.idRuta=u.idRuta)
                as premio
            from ventas v
            inner join usuarios u on v.idVendidoPor = u.id
            where date(v.fecha) = date('$fecha') and idSorteo = $idsorteo
            and v.pasivo = false
            group by u.idRuta;"
        );

        $stmt->execute();
        return $stmt->fetchAll();
    }
}