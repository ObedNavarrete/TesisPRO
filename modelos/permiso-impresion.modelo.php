<?php
require_once "conexion.php";

class ModeloPermisoImpresion
{
    static public function mdlMostrarUsuariosImprimen()
    {
        $stmt = Conexion::conectar()->prepare(
            "SELECT u.id AS id,
                    u.tablaPremio AS idTabla,
                    u.nombre AS nombre,
                    u.usuario AS usuario,
                    u.password AS password,
                    u.imprime AS imprime,
                    r.id AS idRol,
                    r.nombre AS rol,
                    ru.id as idRuta,
                    ru.nombre as ruta
                    FROM usuarios u
                    INNER JOIN roles r
                    ON u.idRol = r.id 
                    INNER JOIN rutas ru
                    on u.idRuta = ru.id
                    WHERE u.pasivo=0 and u.idRol = 2 order by u.nombre asc"
        );

        // //Tambien podria hacerse de esta manera
        // $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla where $item = $valor");

        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    static public function mdlActualizarPermiso($valor1, $valor2)
    {

        $stmt = Conexion::conectar()->prepare("UPDATE usuarios SET imprime = :$valor2 WHERE id = :$valor1");

        $stmt->bindParam(":" . $valor1, $valor1, PDO::PARAM_INT);
        $stmt->bindParam(":" . $valor2, $valor2, PDO::PARAM_INT);

        if ($stmt->execute()) {

            return "ok";
        } else {

            return "error";
        }

        /* $stmt -> close(); */
        $stmt = null;
    }
}
