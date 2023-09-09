<?php

if ($usuarioIngreso['rol'] == 'Editor') {
    $ventas = ControladorRecibosLoteria::ctrMostrarVentasVendedor(null, null);
} else if ($usuarioIngreso['rol'] == 'Supervisor') {
    $ventas = ControladorRecibosLoteria::ctrMostrarVentasSupervisor();
} else if ($usuarioIngreso['rol'] == 'Super') {
    $ventas = ControladorRecibosLoteria::ctrMostrarVentasAdministrador();
}


$fechaActual = date('d/m/Y');
date_default_timezone_set('America/Managua');
$Date = date('Y-m-d');
$Time = date('H:i:s', time());

$hi1 = '18:00:00';

?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 ml-2">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">SIGES</a></li>
                <li class="breadcrumb-item active">Ventas Actuales</li>
            </ol>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->

    <div class="card mx-1 mx-lg-2">
        <div class="card-header border-transparent">
            <h3 class="card-title mt-2 text-center h2">Ventas <?php echo $fechaActual; ?></h3>

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
                <table class="table container-fluid tablaVentasVendedorLoteria mx-0 display" width="100%">
                    <thead class="table-bordered">
                        <tr>
                            <th class="d-none">Hora</th>
                            <th>Hora</th>
                            <?php if (($usuarioIngreso['rol'] == 'Supervisor') || ($usuarioIngreso['rol'] == 'Super') || ($usuarioIngreso['rol'] == 'Administrador')) : ?>
                                <th>Vendedor</th>
                            <?php endif; ?>
                            <th>Código</th>
                            <th>Números</th>
                            <th>Monto</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="table-bordered text-center">


                        <?php foreach ($ventas as $key => $value) : ?>
                            <?php
                            if ($Time < $hi1) {
                                $btnElim = "<button class='btn btn-danger btn-sm btnEliminar'id-venta='" . $value["codigo"] . "'><i class='fas fa-trash-alt text-white'></i></button>";
                            } else {
                                $btnElim = "";
                            }

                            if ($value["pasivo"] == 1) {
                                $txt = 'text-warning';
                            }else{
                                $txt = '';
                            }

                            $acciones = "<div class='btn-group'><button class='btn btn-success btn-sm btnVerReciboLoteria' data-toggle='modal' data-target='#verRecibo' id-ver='" . $value["codigo"] . "'><i class='fas fa-eye text-white'></i></button>" . $btnElim ?? '' . " </div>";
                            ?>
                            <tr class="text-center">
                                <td class="d-none"><?php echo $value["hora"] ?></td>
                                <td class= " <?php echo $txt ?> "><?php echo $value["horax"] ?></td>
                                <?php if (($usuarioIngreso['rol'] == 'Supervisor') || ($usuarioIngreso['rol'] == 'Super') || ($usuarioIngreso['rol'] == 'Administrador')) : ?>
                                    <td class= " <?php echo $txt ?> "><?php echo $value["vende"] ?></td>
                                <?php endif; ?>
                                <td class= " <?php echo $txt ?> "><?php echo $value["codigo"] ?></td>
                                <td class= " <?php echo $txt ?> "><?php echo $value["numeros"] ?></td>
                                <td class= " <?php echo $txt ?> "><?php echo $value["monto"] ?></td>
                                <td class= " <?php echo $txt ?> "><?php echo $acciones ?></td>
                            </tr>
                        <?php endforeach ?>

                    </tbody>
                </table>

            </div>
        </div>

    </div>
    <!-- /.card -->
</div>


<div class="modal fade mt-5" id="verRecibo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog container">

        <div class="card">
            <h2 class="text-center pt-5 text-success">RIFA DÍAZ</h2>
            <div class="texto-aqui">

            </div>
            <!-- <h5 class="pl-2 pt-2">Vendedor: <span class="text-success"><?php echo $usuarioIngreso["nombre"] ?></span> </h5>
      <h5 class="pl-2">Boleto no: <span class="text-success"><?php echo $recibo ?></span> </h5> -->
            <div class="card-body">

                <div class="row border-bottom">
                    <p class="text-center col-4 font-weight-bolder">Número</p>
                    <p class="text-center col-4 font-weight-bolder">Monto</p>
                    <p class="text-center col-4 font-weight-bolder">Premio</p>
                </div>

                <form method="post" class="encabezadoRecibo" id="">

                    <div class="row viendoRecibo" id="viendoRecibo">

                    </div>

                    <div class="d-flex modal-footer justify-content-end">
                        <button data-dismiss="modal" id="" class="btn btn-info">Cerrar</button>
                    </div>

                </form>

            </div>

        </div>
    </div>