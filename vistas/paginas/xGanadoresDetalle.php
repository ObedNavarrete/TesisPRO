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
    margin-top: 10px !important;
  }
</style>

<?php

if (($usuarioIngreso['idRol'] == 2)) {
    echo "<script>
            window.location = 'inicio';
        </script>";
    return;
}

if ($usuarioIngreso['rol'] == 'Supervisor') {
    $detalleGanadores = ControladorGanadoresLoteria::ctrDetalleGanadores("u.idRuta",$usuarioIngreso['idRuta']);
} else if ($usuarioIngreso['rol'] == 'Super') {
    $detalleGanadores = ControladorGanadoresLoteria::ctrDetalleGanadores(null,null);
}

?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 ml-2">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">SIGES</a></li>
                <li class="breadcrumb-item active">Ganadores Detalle</li>
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
                <table class="table container-fluid tablaGanadoresDetalle mx-0 display" width="100%">
                    <thead class="table-bordered">
                        <tr>
                            <th>Fecha</th>
                            <th>Vendedor</th>
                            <th>Ruta</th>
                            <th>Venta Sorteo</th>
                            <th>Venta Ganador</th>
                            <th>Premio</th>
                            <th>Utilidad</th>
                        </tr>

                        <tr>
                            <th>Fecha</th>
                            <th>Vendedor</th>
                            <th>Ruta</th>
                            <th>Venta Sorteo</th>
                            <th>Venta Ganador</th>
                            <th>Premio</th>
                            <th>Utilidad</th>
                        </tr>
                        
                    </thead>
                    <tbody class="table-bordered text-center">

                        <?php foreach ($detalleGanadores as $key => $value) : ?>

                            <?php
                                    $diferencia = $value["ventas"] - $value["premioGanador"];

                                    if ($diferencia > 0) {
                                        $diferencia = number_format($diferencia, 0, '.', ',');
                                        $dff = "<a class='text-primary'>  " . 'C$ ' . $diferencia . "  </a>";
                                    } else {
                                        $diferencia = number_format($diferencia, 0, '.', ',');
                                        $dff = "<a class='text-warning'>  " . 'C$ ' . $diferencia . "  </a>";
                                    }
                            ?>
                            <tr class="text-center">
                                <td><?php echo $value["fecha"] ?></td>
                                <td><?php echo $value["usuario"] ?></td>
                                <td><?php echo $value["ruta"] ?></td>
                                <td><?php echo 'C$ ' . number_format($value["ventas"], 0, '.', ',') ?></td>
                                <td><?php echo 'C$ ' . number_format($value["ventaGanador"], 0, '.', ',') ?></td>
                                <td><?php echo 'C$ ' . number_format($value["premioGanador"], 0, '.', ',') ?></td>
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