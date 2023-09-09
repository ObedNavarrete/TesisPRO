<?php

error_reporting(E_ALL ^ E_NOTICE);
session_start();

if (($usuarioIngreso['idRol'] != 4)) {
    echo "<script>
            window.location = 'inicio';
        </script>";
    return;
}

$usuarios = ControladorUsuarios::ctrMostrarUsuarios(null, null);
$numeros = ControladorNumeros::ctrMostrarNumeros(null, null);

?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 ml-2">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">SIGES</a></li>
                <li class="breadcrumb-item active">Ventas Fecha</li>
            </ol>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->

    <div class="card mx-1 mx-lg-2">
        <div class="card-header border-transparent">
            <h3 class="card-title text-center h2">Filtros de Fechas</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">

            <button style="width: auto;" type="button" class="light-mode btn btn-info mb-2 ml-2 btn-sm shadow-none d-flex justify-content-between" id="daterange-btn">
            <span>Rango de fecha</span>
            &nbsp; &nbsp;
            <div>
                <i class="fas fa-chevron-down" style="vertical-align:middle;"></i>
            </div>
            </button>

            <div class="table-responsive">
            <table class="table m-0 table-bordered rounded-0 text-center tablaVentaVendedor" id="tablaVentasFecha" width="100%">
                                    <thead class="">
                                        <tr>
                                            <th>Del</th>
                                            <th>Al</th>
                                            <th>Nombre</th>
                                            <th>Ruta</th>
                                            <th>Ventas</th>
                                            <th>Premios</th>
                                            <th>Diferencia</th>

                                        </tr>
                                    </thead>
                                    <tbody class="">

                                        <?php
                                        if (isset($_GET["fechaInicial"])) {
                                            $fechaInicial = $_GET["fechaInicial"];
                                            $fechaFinal = $_GET["fechaFinal"];
                                            echo '
                                                <script>
                                                        $("#tablaVentasFecha").removeClass("tablaVentaVendedor");
                                                        $("#tablaVentasFecha").addClass("tablaVentaVendedorFecha");
                                                </script>
                                            ';
                                        } else {
                                            $fechaInicial = null;
                                            $fechaFinal = null;
                                        }

                                        $resp = ControladorVentasFecha::ctrMostrarVentasTotalesVendedorFecha($fechaInicial, $fechaFinal);

                                        ?>

                                        <?php foreach ($resp as $key => $val) : ?>
                                            
                                            <tr>
                                                <td><?php echo $val["fechaInicial"] ?? 'NO APLICA' ?></td>
                                                <td><?php echo $val["fechaFinal"] ?? 'NO APLICA' ?></td>
                                                <td><?php echo $val["usuario"] ?></td>
                                                <td><?php echo $val["ruta"] ?></td>
                                                <td><?php echo $val["ventas"] ?></td>
                                                <td><?php echo $val["premioGanador"] ?></td>
                                                <td><?php echo $val["ventas"] - $val["premioGanador"] ?></td>
                                            </tr>
                                        <?php endforeach ?>


                                    </tbody>

                                </table>
            <div class="table-responsive">

        </div>
        <!-- /.card-body -->

        <!-- <div class="card-footer clearfix">
            <button class="btn btn-sm btn-secondary float-right" data-toggle="modal" data-target="#agregarLimite">Nuevo Registro</button>
        </div> -->

    </div>
    <!-- /.card -->
</div>
