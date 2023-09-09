<?php

require_once "controladores/plantilla.controlador.php";
require_once "controladores/usuarios.controlador.php";
require_once "controladores/roles.controlador.php";
require_once "controladores/rutas.controlador.php";
require_once "controladores/numeros.controlador.php";
require_once "controladores/premios.controlador.php";
require_once "controladores/sorteos.controlador.php";
require_once "controladores/admin.ventas-limite.controlador.php";
require_once "controladores/vender.controlador.php";
require_once "controladores/recibos.controlador.php";
require_once "controladores/inicio.controlador.php";
require_once "controladores/ganadores.controlador.php";
require_once "controladores/ventasFecha.controlador.php";
require_once "controladores/historia.controlador.php";

require_once "controladores/xLoteria.controlador.php";
require_once "controladores/xVender.controlador.php";
require_once "controladores/xRecibos.controlador.php";
require_once "controladores/xGanadores.controlador.php";

require_once "controladores/listas.controlador.php";

require_once "modelos/conexion.php";
require_once "modelos/usuarios.modelo.php";
require_once "modelos/roles.modelo.php";
require_once "modelos/rutas.modelo.php";
require_once "modelos/numeros.modelo.php";
require_once "modelos/premios.modelo.php";
require_once "modelos/sorteos.modelo.php";
require_once "modelos/admin.ventas-limite.modelo.php";
require_once "modelos/vender.modelo.php";
require_once "modelos/recibos.modelo.php";
require_once "modelos/inicio.modelo.php";
require_once "modelos/ganadores.modelo.php";
require_once "modelos/ventasFecha.modelo.php";
require_once "modelos/historia.modelo.php";

require_once "modelos/xLoteria.modelo.php";
require_once "modelos/xVender.modelo.php";
require_once "modelos/xRecibos.modelo.php";
require_once "modelos/xGanadores.modelo.php";

require_once "modelos/listas.modelo.php";

require_once "controladores/permiso-impresion.controlador.php";
require_once "modelos/permiso-impresion.modelo.php";

require_once "controladores/permiso-acceso.controlador.php";
require_once "modelos/permiso-acceso.modelo.php";

$plantilla = new ControladorPlantilla();
$plantilla->ctrPlantilla();
