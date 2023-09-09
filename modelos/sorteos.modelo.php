<?php
require_once "conexion.php";

class ModeloSorteos
{
    static public function mdlMostrarSorteos($tabla)
    {
        $stmt = Conexion::conectar()->prepare("SELECT id, TIME(inicio) AS inicio,
        TIME(fin) AS fin, sorteo
        FROM $tabla");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = null;
    }

    static public function mdlMostrarSorteoActual()
    {
        $stmt = Conexion::conectar()->prepare("SELECT *
        from sorteos where curtime() > inicio and curtime() < fin;");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt = null;
    }

}
