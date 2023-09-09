<?php
require_once "conexion.php";

class ModeloLoteria
{
    /*==========================================
    Mostrar Roles de Usuario
    ==========================================*/
    static public function mdlMostrarTotalVentasInicio($tabla1, $tabla3, $item, $valor)
    {
        if ($item != null && $valor != null) {
            $stmt = Conexion::conectar()->prepare(
                "SELECT sum(v.inversion) from $tabla1 v
                inner join $tabla3 u on u.id = v.idVendidoPor
                WHERE $item = $valor
                AND v.pasivo = 0
                AND DATE_FORMAT(v.fecha, '%Y-%m-%d') = CURDATE()"
            );

            //$stmt->bindParam(":" . $item, $valor, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
        } else {

            $stmt = Conexion::conectar()->prepare(
                "SELECT sum(v.inversion) from $tabla1 v
                inner join $tabla3 u on u.id = v.idVendidoPor
                WHERE v.pasivo = 0
                AND DATE_FORMAT(v.fecha, '%Y-%m-%d') = CURDATE()"
            );

            $stmt->execute();
            return $stmt->fetch();
        }
    }
}
