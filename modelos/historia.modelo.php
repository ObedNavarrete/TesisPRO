<?php
require_once "conexion.php";

class ModeloHistoria {
    /*==========================================
    Mostrar Roles de Usuario
    ==========================================*/
    static public function mdlMostrarHistoria($tabla1, $tabla2, $tabla3, $item, $valor) {
        $stmt = Conexion::conectar() -> prepare("SELECT
        DATE_FORMAT(date(v.fecha), '%d / %m / %Y') as fecha,
        u.nombre as nombre,
        COALESCE(SUM(v.inversion),0) as sorteos,
        (select coalesce(sum(vl.inversion),0)
                  from $tabla3 vl
                  where date(vl.fecha) = date(v.fecha)
                  and vl.idVendidoPor = v.idvendidoPor) as loteria
        from $tabla1 v
        INNER JOIN $tabla2 u on u.id = v.idVendidoPor
        WHERE v.pasivo = 0 and date(v.fecha) != curdate()
        AND (date(v.fecha) >= date_add(NOW(), INTERVAL -8 DAY)) AND v.$item = $valor
        GROUP BY u.nombre, date(v.fecha);");

        $stmt -> execute();

        return $stmt -> fetchAll(PDO::FETCH_ASSOC);

        $stmt = null;
    }
}