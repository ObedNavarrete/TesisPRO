<?php
require_once "conexion.php";

class ModeloRutas {
    /*==========================================
    Mostrar Roles de Usuario
    ==========================================*/
    static public function mdlMostrarRutas($tabla) {
        $stmt = Conexion::conectar() -> prepare("SELECT id,
        nombre
        FROM $tabla");

        $stmt -> execute();

        return $stmt -> fetchAll(PDO::FETCH_ASSOC);

        $stmt = null;
    }
}