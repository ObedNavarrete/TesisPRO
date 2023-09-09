<?php

if (($usuarioIngreso['idRol'] == 2)) {
    echo "<script>
            window.location = 'inicio';
        </script>";
    return;
}

if ($usuarioIngreso['rol'] == 'Supervisor') {
    $ventas = ControladorVentasLoteria::ctrMostrarListaVendedeoresSupervisor();
} else if ($usuarioIngreso['rol'] == 'Super') {
    $ventas = ControladorVentasLoteria::ctrMostrarListaVendedeoresAdministrador();
}

$fechaActual = date('d/m/Y');

?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 ml-2">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">SIGES</a></li>
                <li class="breadcrumb-item active">Ventas Vendedores</li>
            </ol>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->

    <div class="card mx-1 mx-lg-2">
        <div class="card-header border-transparent">
            <h3 class="card-title text-center h2">Ventas <?php echo $fechaActual; ?></h3>

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
                <table class="table container-fluid tablaListaVentasVendedorLoteria mx-0 display" width="100%">
                    <thead class="table-bordered">
                        <tr>
                            <th>Vendedor</th>
                            <th>Ventas</th>
                            <th>Boletos</th>
                            <th>Ruta</th>
                        </tr>
                    </thead>
                    <tbody class="table-bordered text-center">

                        <?php foreach ($ventas as $key => $value) : ?>
                            <tr class="text-center">
                                <td><?php echo $value["nombre"] ?></td>
                                <td><?php echo $value["sumatoria"] ?></td>
                                <td><?php echo $value["boletos"] ?></td>
                                <td><?php echo $value["ruta"] ?></td>
                            </tr>
                        <?php endforeach ?>

                    </tbody>
                </table>

            </div>
        </div>

    </div>
    <!-- /.card -->
</div>