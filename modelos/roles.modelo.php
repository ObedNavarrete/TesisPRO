<?php
require_once "conexion.php";

class ModeloRol {
    /*==========================================
    Mostrar Roles de Usuario
    ==========================================*/
    static public function mdlMostrarRoles($tabla) {
        $stmt = Conexion::conectar() -> prepare("SELECT id,
        nombre, 
        descripcion 
        FROM $tabla");

        $stmt -> execute();

        return $stmt -> fetchAll(PDO::FETCH_ASSOC);

        $stmt = null;
    }
}