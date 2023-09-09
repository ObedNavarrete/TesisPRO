<?php


if ($usuarioIngreso['rol'] == 'Editor') {
    $ventasNum = ControladorVentasLoteria::ctrMostrarVentasVendedorNum(null, null);
} else if ($usuarioIngreso['rol'] == 'Supervisor') {
    $ventasNum = ControladorVentasLoteria::ctrMostrarVentasSupervisorNum();
} else if ($usuarioIngreso['rol'] == 'Super') {
    $ventasNum = ControladorVentasLoteria::ctrMostrarVentasAdministradorNum();
}
$fechaActual = date('d/m/Y');

?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 ml-2">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">SIGES</a></li>
                <li class="breadcrumb-item active">Ventas Números Lotería</li>
            </ol>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->

    <div class="card mx-1 mx-lg-2">
        <div class="card-header border-transparent">
            <h3 class="card-title text-center h2">Ventas Números <?php echo $fechaActual; ?></h3>

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
                <table class="table container-fluid mx-0 display tablaVentasNumLoteria" width="100%">
                    <thead class="table-bordered">
                        <tr>
                            <th>Número</th>
                            <th>Boletos</th>
                            <th>Monto</th>
                            <th>Premio</th>
                            <?php if ($usuarioIngreso['rol'] == 'Super') : ?>
                                <th>Acciones</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody class="table-bordered text-center">

                        <?php foreach ($ventasNum as $key => $value) : ?>
                            <?php 
                            $numero = str_pad($value["numero"], 2, "0", STR_PAD_LEFT); 
                            $acciones = "<div class='btn-group'><button class='btn btn-success btn-sm btnVerNumero' data-toggle='modal' data-target='#verNum' id-ver='" . $value["numero"] . "'><i class='fas fa-eye text-white'></i></button></div>";
                            ?>

                            <tr class="text-center">
                                <td><?php echo $numero ?></td>
                                <td><?php echo $value["boletos"] ?></td>
                                <td><?php echo $value["inversion"] ?></td>
                                <td><?php echo $value["premio"] ?></td>
                                <?php if ($usuarioIngreso['rol'] == 'Super') : ?>
                                    <td><?php echo $acciones ?></td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach ?>

                    </tbody>
                </table>

            </div>
        </div>

    </div>
    <!-- /.card -->
</div>

<div class="modal fade mt-5" id="verNum" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog container">

        <div class="card">
            <h2 class="text-center pt-5 text-success">Detalle Número</h2>
            <div class="texto-aqui">

            </div>
            <!-- <h5 class="pl-2 pt-2">Vendedor: <span class="text-success"><?php echo $usuarioIngreso["nombre"] ?></span> </h5>
      <h5 class="pl-2">Boleto no: <span class="text-success"><?php echo $recibo ?></span> </h5> -->
            <div class="card-body">

                <div class="row border-bottom">
                    <p class="text-center col-3 font-weight-bolder">Vende</p>
                    <p class="text-center col-3 font-weight-bolder">Recibo</p>
                    <p class="text-center col-3 font-weight-bolder">Monto</p>
                    <p class="text-center col-3 font-weight-bolder">Premio</p>
                </div>

                <form method="post" class="encabezadoRecibo" id="">

                    <div class="row viendoNumero" id="viendoNumero">

                    </div>

                    <div class="d-flex modal-footer justify-content-end">
                        <button data-dismiss="modal" id="" class="btn btn-info">Cerrar</button>
                    </div>

                </form>

            </div>

        </div>
    </div>