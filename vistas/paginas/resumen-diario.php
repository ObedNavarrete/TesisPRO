<?php

if (($usuarioIngreso['idRol'] != 4)) {
    echo "<script>
            window.location = 'inicio';
        </script>";
    return;
}

$detalleGanadores = ControladorGanadores::ctrResumenDiario();


?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 ml-2">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">SIGES</a></li>
                <li class="breadcrumb-item active">Resumen Diario</li>
            </ol>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->

    <div class="card mx-1 mx-lg-2">
        <div class="card-header border-transparent">
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
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table container-fluid tablaResumen mx-0 display" width="100%">
                    <thead class="table-bordered">
                        <tr>
                            <th class="d-none">FM</th>
                            <th>Fecha</th>
                            <th>Vendedor</th>
                            <th>Ruta</th>
                            <th>Ventas Totales</th>
                            <th>Premio Loto</th>
                            <th>Premio Lotería</th>
                            <th>Utilidad</th>
                        </tr>
                    </thead>
                    <tbody class="table-bordered text-center">

                        <?php foreach ($detalleGanadores as $key => $value) : ?>

                            <?php
                                    $diferencia = $value["ventas"] - $value["premioGanador"] - $value["premioGanadorLoteria"];

                                    if ($diferencia > 0) {
                                        $dff = "<a class='text-primary'>  " . $diferencia . "  </a>";
                                    } else {
                                        $dff = "<a class='text-warning'>  " . $diferencia . "  </a>";
                                    }
                            ?>
                            <tr class="text-center">
                                <td class="d-none"><?php echo $value["fm"] ?></td>
                                <td><?php echo $value["fecha"] ?></td>
                                <td><?php echo $value["usuario"] ?></td>
                                <td><?php echo $value["ruta"] ?></td>
                                <td><?php echo $value["ventas"] ?></td>
                                <td><?php echo $value["premioGanador"] ?></td>
                                <td><?php echo $value["premioGanadorLoteria"] ?></td>
                                <td><?php echo $dff ?></td>
                            </tr>
                        <?php endforeach ?>

                    </tbody>
                </table>

            </div>
        </div>

    </div>
    <!-- /.card -->
</div>