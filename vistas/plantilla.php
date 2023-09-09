<?php
session_start();
if (isset($_SESSION["idSesion"])) {
    $SESS = $_SESSION["idSesion"];
    $usuarioIngreso = ControladorUsuarios::ctrMostrarUsuarios("id", $_SESSION["idSesion"]);
}
date_default_timezone_set('America/Managua');
$dia = date("N");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rifa Díaz</title>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-86YE5N0H23"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-86YE5N0H23');
    </script>

    <link async rel="preconnect" href="https://fonts.googleapis.com">
    <link async rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link async href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link async rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link async rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link async rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- SweetAlert -->
    <link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.min.css">
    <!-- Estilos personales -->
    <link rel="stylesheet" href="vistas/css/main.css?v=1">

    <!-- JavaScript -->
    <!-- jQuery -->
    <script src="plugins/jquery/jquery.js"></script>
    <!-- Bootstrap 4 -->
    <script async src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DATATABLE RESPONSIVE -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.2/af-2.3.7/b-2.0.0/b-colvis-2.0.0/b-html5-2.0.0/b-print-2.0.0/cr-1.5.4/date-1.1.1/fc-3.3.3/fh-3.1.9/kt-2.6.4/r-2.2.9/rg-1.1.3/rr-1.2.8/sc-2.0.5/sb-1.2.1/sp-1.4.0/sl-1.3.3/datatables.min.css" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.2/af-2.3.7/b-2.0.0/b-colvis-2.0.0/b-html5-2.0.0/b-print-2.0.0/cr-1.5.4/date-1.1.1/fc-3.3.3/fh-3.1.9/kt-2.6.4/r-2.2.9/rg-1.1.3/rr-1.2.8/sc-2.0.5/sb-1.2.1/sp-1.4.0/sl-1.3.3/datatables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.1.9/js/dataTables.fixedHeader.min.js"></script>
    <!-- overlayScrollbars -->
    <script async src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script async src="dist/js/adminlte.js"></script>
    <!-- SweetAlert 2 -->
    <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- MAIN -->
    <script src="vistas/js/main.js"></script>

    <!-- DATERANGEPICKER -->
    <link href="plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet" />
    <script src="plugins/moment.min.js"></script>
    <script src="plugins/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- Morris.js charts -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>


</head>

<body class="hold-transition sidebar-mini layout-fixed dark-mode">
    <div class="wrapper">

        <?php

        if (isset($_SESSION["iniciarSesion"]) && ($_SESSION["iniciarSesion"]) == "ok") {

            include 'paginas/modulos/header.php';

            echo '<div class="content-wrapper">';

            include 'paginas/modulos/menu.php';

            if (isset($_GET["ruta"])) {
                if ($_GET["ruta"] == "inicio") {
                    include 'paginas/inicio.php';
                    echo '<script src="vistas/js/inicio.js?v=3"></script>';
                }

                if ($_GET["ruta"] == "usuarios") {
                    include 'paginas/usuarios.php';
                    echo '<script src="vistas/js/usuarios.js"></script>';
                }

                if ($_GET["ruta"] == "ventas-limite") {
                    include 'paginas/ventas-limite.php';
                    echo '<script src="vistas/js/ventas-limite.js"></script>';
                }

                if ($_GET["ruta"] == "numeros") {
                    include 'paginas/numeros.php';
                    echo '<script src="vistas/js/numeros.js"></script>';
                }

                if ($_GET["ruta"] == "premios") {
                    include 'paginas/premios.php';
                    echo '<script src="vistas/js/premios.js"></script>';
                }

                if ($_GET["ruta"] == "ver-ventas") {
                    include 'paginas/ver-ventas.php';
                    echo '<script src="vistas/js/ver-ventas.js?v=4"></script>';
                }

                if ($_GET["ruta"] == "ver-ventas-num") {
                    include 'paginas/ver-ventas-num.php';
                    echo '<script src="vistas/js/ver-ventas-num.js?v=1"></script>';
                }

                if ($_GET["ruta"] == "ventas-vendedores") {
                    include 'paginas/ventas-vendedores.php';
                    echo '<script src="vistas/js/ventas-vendedores.js"></script>';
                }

                if ($_GET["ruta"] == "info-vendedor") {
                    include 'paginas/info-vendedor.php';
                }

                if ($_GET["ruta"] == "ganadores") {
                    include 'paginas/ganadores.php';
                    echo '<script src="vistas/js/ganadores.js?v=4"></script>';
                }

                if ($_GET["ruta"] == "ventasFecha") {
                    include 'paginas/ventasFecha.php';
                    echo '<script src="vistas/js/ventasFecha.js?v=3"></script>';
                }

                if ($_GET["ruta"] == "ganadoresDetalle") {
                    include 'paginas/ganadoresDetalle.php';
                    echo '<script src="vistas/js/ganadoresDetalle.js?v=3"></script>';
                }

                if ($_GET["ruta"] == "recibos-anteriores") {
                    include 'paginas/recibos-anteriores.php';
                    echo '<script src="vistas/js/recibos-anteriores.js?v=5"></script>';
                }

                if ($_GET["ruta"] == "historia") {
                    include 'paginas/historia.php';
                    echo '<script src="vistas/js/historia.js"></script>';
                }

                if ($_GET["ruta"] == "resumen-diario") {
                    include 'paginas/resumen-diario.php';
                    echo '<script src="vistas/js/resumen-diario.js"></script>';
                }

                /* desde aqui */
                /*****************/
                if ($_GET["ruta"] == "xLoteria") {
                    include 'paginas/xLoteria.php';
                    echo '<script src="vistas/js/xLoteria.js?v=8"></script>';
                }

                if ($_GET["ruta"] == "xVer-ventas") {
                    include 'paginas/xVer-ventas.php';
                    echo '<script src="vistas/js/xVer-ventas.js?v=1"></script>';
                }

                if ($_GET["ruta"] == "xVer-ventas-num") {
                    include 'paginas/xVer-ventas-num.php';
                    echo '<script src="vistas/js/xVer-ventas-num.js"></script>';
                }

                if ($_GET["ruta"] == "xVentas-vendedores") {
                    include 'paginas/xVentas-vendedores.php';
                    echo '<script src="vistas/js/xVentas-vendedores.js"></script>';
                }

                if ($_GET["ruta"] == "xGanadores") {
                    include 'paginas/xGanadores.php';
                    echo '<script src="vistas/js/xGanadores.js"></script>';
                }

                if ($_GET["ruta"] == "xGanadoresDetalle") {
                    include 'paginas/xGanadoresDetalle.php';
                    echo '<script src="vistas/js/xGanadoresDetalle.js?v=1"></script>';
                }

                if ($_GET["ruta"] == "listas") {
                    include 'paginas/listas.php';
                    echo '<script src="vistas/js/listas.js?v=1"></script>';
                }

                if ($_GET["ruta"] == "permiso-impresion") {
                    include 'paginas/permiso-impresion.php';
                    echo '<script src="vistas/js/permiso-impresion.js?v=2"></script>';
                }

                if ($_GET["ruta"] == "permiso-acceso") {
                    include 'paginas/permiso-acceso.php';
                    echo '<script src="vistas/js/permiso-acceso.js"></script>';
                }

                if ($_GET["ruta"] == "salir") {
                    include 'paginas/salir.php';
                }
            } else {
                include 'paginas/inicio.php';
                echo '<script src="vistas/js/inicio.js?v=3"></script>';
            }

            echo '</div>';
        } else {
            include 'paginas/login.php';
        }

        ?>

    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

</body>

</html>