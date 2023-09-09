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
    div.dataTables_wrapper div.dataTables_info {
        padding-top: 0.85em;
        color: white;
    }
    div.dataTables_wrapper div.dataTables_paginate {
    background-color: white;
    font-weight: bolder;
    padding: 10px;
    margin: 0;
    white-space: nowrap;
    text-align: right;
    width: 100% !important;
    }
    div.dt-buttons{
        margin-left: 10px !important;
        margin-top: 10px !important;
    }
    </style>


<?php
if ($usuarioIngreso['rol'] == 'Editor') {
    $ventas = ControladorRecibos::ctrMostrarVentasVendedor(null, null);
} else if ($usuarioIngreso['rol'] == 'Supervisor') {
    $ventas = ControladorRecibos::ctrMostrarVentasSupervisor();
} else if ($usuarioIngreso['rol'] == 'Super') {
    $ventas = ControladorRecibos::ctrMostrarVentasAdministrador();
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
                <li class="breadcrumb-item active">Ventas Actuales</li>
            </ol>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->

    <div class="card mx-1 mx-lg-2">
        <div class="card-header border-transparent">
            <h3 class="card-title mt-2 ml-0 text-center h2">Recibos</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table container-fluid tablaVentasVendedor mx-0 display" width="100%">
                    <thead class="table-bordered">
                        <tr>
                            <th class="d-none">Id</th>
                            <th class="">Hora</th>
                            <?php if (($usuarioIngreso['rol'] == 'Supervisor') || ($usuarioIngreso['rol'] == 'Super') || ($usuarioIngreso['rol'] == 'Administrador')) : ?>
                                <th>Vendedor</th>
                            <?php endif; ?>
                            <th>Código</th>
                            <th>Números</th>
                            <th>Monto</th>
                            <th>Acciones</th>
                            <th>Reimpresión</th>
                        </tr>

                        <tr>
                            <th class="d-none">Id</th>
                            <th class="">Hora</th>
                            <?php if (($usuarioIngreso['rol'] == 'Supervisor') || ($usuarioIngreso['rol'] == 'Super') || ($usuarioIngreso['rol'] == 'Administrador')) : ?>
                                <th>Vendedor</th>
                            <?php endif; ?>
                            <th>Código</th>
                            <th>Números</th>
                            <th>Monto</th>
                            <th>Acciones</th>
                            <th>Reimpresión</th>
                        </tr>
                    </thead>
                    <tbody class="table-bordered text-center">
                    

                        <?php foreach ($ventas as $key => $value) : ?>
                            <?php
                                    $hi1 = '10:58:00';
                                    $hf1 = '11:30:00';
                                    $hi2 = '14:58:00';
                                    $hf2 = '15:30:09';
                                    $hi3 = '20:58:00';

                            if ($value["pasivo"] == 1) {
                                $txt = 'text-warning';
                            }else{
                                $txt = '';
                            }

                            //if (($usuarioIngreso['imprime'] == 0)) {
                                if ((($Time > $hi1) && ($Time < $hf1)) || (($Time > $hi2) && ($Time < $hf2)) || (($Time > $hi3))) {
                                    $btnElim = "";
                                } else {
                                    $btnElim = "<button class='btn btn-danger btn-sm btnEliminar'id-venta='" . $value["codigo"] . "'><i class='fas fa-trash-alt text-white'></i></button>";
                                }
                            //} else {
                            //    $btnElim = "";
                            //}

                            $acciones = "<div class='btn-group'><button class='btn btn-success btn-sm btnVerRecibo' data-toggle='modal' data-target='#verRecibo' id-ver='" . $value["codigo"] . "'><i class='fas fa-eye text-white'></i></button>" . $btnElim ?? '' . " </div>";
                            ?>
                            <tr class="text-center">
                                <td class="d-none"><?php echo $value["id"] ?></td>
                                <td class= " <?php echo $txt ?> "><?php echo $value["hora"] ?></td>
                                <?php if (($usuarioIngreso['rol'] == 'Supervisor') || ($usuarioIngreso['rol'] == 'Super') || ($usuarioIngreso['rol'] == 'Administrador')) : ?>
                                    <td class= " <?php echo $txt ?> "><?php echo $value["vende"] ?></td>
                                <?php endif; ?>
                                <td class= " <?php echo $txt ?> "><?php echo $value["codigo"] ?></td>
                                <td class= " <?php echo $txt ?> "><?php echo $value["numeros"] ?></td>
                                <td class= " <?php echo $txt ?> "><?php echo $value["monto"] ?></td>
                                <td class= " <?php echo $txt ?> "><?php echo $acciones ?></td>

                                <td><button class="btn btn-sm  btn-primary"><a class="text-white" href="/fpdf/recibo.php?codigo=<?php echo $value["codigo"] ?>"><i class="fas fa-print"></i></a></button></td>

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
      <div id="cod-rcb"></div>
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