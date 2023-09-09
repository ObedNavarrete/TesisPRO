<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<link href="https://nightly.datatables.net/css/jquery.dataTables.css" rel="stylesheet" type="text/css" />
<script src="https://nightly.datatables.net/js/jquery.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<style>
  button,
  input,
  optgroup,
  select,
  textarea {
    margin: 0;
    font-family: inherit;
    font-size: inherit;
    line-height: inherit;
    background-color: inherit;
    outline: none;
    color: white;
    text-align: center;
    border: none;
    width: 100%;
  }
  div.dataTables_wrapper div.dataTables_paginate {
    background-color: white;
    font-weight: bolder;
    padding: 10px;
    margin: 0;
    white-space: nowrap;
    text-align: right;
}
  div.dataTables_wrapper div.dataTables_info {
    padding-top: 0.85em;
    color: white;
  }
  div.dt-buttons{
    margin-left: 10px !important;
  }
</style>


<?php

if ($usuarioIngreso['rol'] == 'Editor') {
    $ventas = ControladorRecibos::ctrMostrarVentasSorteoAnterior('v.idVendidoPor', $usuarioIngreso['id']);
} else if ($usuarioIngreso['rol'] == 'Supervisor') {
    $ventas = ControladorRecibos::ctrMostrarVentasSorteoAnterior('u.idRuta', $usuarioIngreso['idRuta']);
} else if ($usuarioIngreso['rol'] == 'Super') {
    $ventas = ControladorRecibos::ctrMostrarVentasSorteoAnterior(null,null);
}


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
                <li class="breadcrumb-item active">Sorteo Anterior</li>
            </ol>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->

    <div class="card mx-lg-2">
        <div class="card-header border-transparent">
            <h3 class="card-title mt-2 text-center h2">Ventas registradas para el último sorteo</h3>

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
                <table class="table container-fluid tablaVentasVendedorAnterior mx-0 display" width="100%">
                    <thead class="table-bordered">
                        <tr>
                            <th class="d-none">Id</th>
                            <th class="">Fecha</th>
                            <th class="">Sorteo</th>
                            <th class="">Hora</th>
                            <?php if (($usuarioIngreso['rol'] == 'Supervisor') || ($usuarioIngreso['rol'] == 'Super') || ($usuarioIngreso['rol'] == 'Administrador')) : ?>
                                <th>Vendedor</th>
                            <?php endif; ?>
                            <th>Código</th>
                            <th>Números</th>
                            <th>Monto</th>
                            <th>Acciones</th>
                        </tr>

                        <tr>
                            <th class="d-none">Id</th>
                            <th class="">Fecha</th>
                            <th class="">Sorteo</th>
                            <th class="">Hora</th>
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
                            $acciones = "<div class='btn-group'><button class='btn btn-success btn-sm btnVerRecibo' data-toggle='modal' data-target='#verReciboAnterior' id-ver='" . $value["codigo"] . "'><i class='fas fa-eye text-white'></i></button></div>";
                            ?>


                            <?php if($value["pasivo"] == 1) : ?>
                            <tr class="text-center text-warning">
                                <td class="d-none"><?php echo $value["id"] ?></td>
                                <td class=""><?php echo $value["fecha"] ?></td>
                                <td class=""><?php echo $value["sorteo"] ?></td>
                                <td class=""><?php echo $value["hora"] ?></td>
                                <?php if (($usuarioIngreso['rol'] == 'Supervisor') || ($usuarioIngreso['rol'] == 'Super') || ($usuarioIngreso['rol'] == 'Administrador')) : ?>
                                    <td><?php echo $value["vende"] ?></td>
                                <?php endif; ?>
                                <td><?php echo $value["codigo"] ?></td>
                                <td><?php echo $value["numeros"] ?></td>
                                <td><?php echo $value["monto"] ?></td>
                                <td><?php echo $acciones ?></td>
                            </tr>
                            <?php endif; ?>

                            <?php if($value["pasivo"] == 0) : ?>
                                <tr class="text-center ">
                                    <td class="d-none"><?php echo $value["id"] ?></td>
                                    <td class=""><?php echo $value["fecha"] ?></td>
                                    <td class=""><?php echo $value["sorteo"] ?></td>
                                    <td class=""><?php echo $value["hora"] ?></td>
                                    <?php if (($usuarioIngreso['rol'] == 'Supervisor') || ($usuarioIngreso['rol'] == 'Super') || ($usuarioIngreso['rol'] == 'Administrador')) : ?>
                                        <td><?php echo $value["vende"] ?></td>
                                    <?php endif; ?>
                                    <td><?php echo $value["codigo"] ?></td>
                                    <td><?php echo $value["numeros"] ?></td>
                                    <td><?php echo $value["monto"] ?></td>
                                    <td><?php echo $acciones ?></td>
                                </tr>
                            <?php endif; ?>

                    
                        <?php endforeach ?>

                    </tbody>
                </table>

            </div>
        </div>

    </div>
    <!-- /.card -->
</div>


<div class="modal fade mt-5" id="verReciboAnterior" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog container">

        <div class="card">
            <h2 class="text-center pt-5 text-success">RIFA DÍAZ</h2>
            <div id="cod-rcba"></div>
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