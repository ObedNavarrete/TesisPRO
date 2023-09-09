<?php
if (($usuarioIngreso['idRol'] != 2)) {
    echo "<script>
            window.location = 'inicio';
        </script>";
    return;
}

$historia = ControladorHistoria::ctrMostrarHistoria("idVendidoPor", $usuarioIngreso["id"]);


$fechaActual = date('d/m/Y');
date_default_timezone_set('America/Managua');
$Date = date('Y-m-d');
$Time = date('H:i:s', time());
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 ml-2">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">SIGES</a></li>
                <li class="breadcrumb-item active">Historia</li>
            </ol>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->

    <div class="card mx-lg-2">
        <div class="card-header border-transparent">
            <h3 class="card-title mt-2 text-center h2">Historial de Ventas</h3>

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
                <table class="table container-fluid tablaHistoria mx-0 display" width="100%">
                    <thead class="table-bordered">
                        <tr>
                            <th>Fecha</th>
                            <th>Sorteos</th>
                            <th>Lotería</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody class="table-bordered text-center">


                        <?php foreach ($historia as $key => $value) : ?>
                            <?php $total = $value["sorteos"] + $value["loteria"] ?>
                            <tr class="text-center">
                                <td><?php echo $value["fecha"] ?></td>
                                <td><?php echo $value["sorteos"] ?></td>
                                <td><?php echo $value["loteria"] ?></td>
                                <td><?php echo $total ?></td>
                            </tr>
                        <?php endforeach ?>

                    </tbody>
                </table>

            </div>
        </div>

    </div>
    <!-- /.card -->
</div>