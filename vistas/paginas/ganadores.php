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
if (($usuarioIngreso['idRol'] != 4)) {
    echo "<script>
            window.location = 'inicio';
        </script>";
    return;
}

$gan = ControladorGanadores::ctrValidaUnGanador();

$usuarios = ControladorUsuarios::ctrMostrarUsuarios(null, null);
$sorteos = ControladorSorteos::ctrMostrarSorteos(null, null);
date_default_timezone_set('America/Managua');
$Time = date('H:i:s', time());
$Date = date('Y-m-d');
$Fecha = date('d/m/Y');
$FFF = date('Y/m/d');

$ventasTotales = ControladorInicio::ctrMostrarTotalVentasInicio(null,null);

$yaHayGanador = ControladorGanadores::ctrBtnGanador();

if ($Time > $sorteos[0]['inicio'] and $Time < $sorteos[0]['fin']) {
    $id = $sorteos[0]['id'];
    $valor = $sorteos[0]['sorteo'];
  } else
          if ($Time > $sorteos[1]['inicio'] and $Time < $sorteos[1]['fin']) {
    $id = $sorteos[1]['id'];
    $valor = $sorteos[1]['sorteo'];
  } else
          if ($Time > $sorteos[2]['inicio'] and $Time < $sorteos[2]['fin']) {
    $id = $sorteos[2]['id'];
    $valor = $sorteos[2]['sorteo'];
  } else {
    $id = 0;
    $valor = 0;
  }
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 ml-2">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">SIGES</a></li>
                <li class="breadcrumb-item active">Ganadores</li>
            </ol>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<section class="content formulario-ventas mb-3">
    <div class="container-fluid mt-3">

    <div class="card">
      <h2 class="text-center pt-5 px-3">Números Ganadores de Sorteos </h2>
      <h5 class="pl-3 pt-2 text-center">Usuario: <span class="text-success"><?php echo $usuarioIngreso["nombre"] ?></span> </h5>
      <h5 class="pl-3 text-center">Fecha: <span class="text-success"><?php echo $Fecha ?></span> </h5>
      <h5 class="pl-3 text-center">Sorteo Actual: <span class="text-success"><?php echo $valor ?></span> </h5>
      
      <div class="card-body p-2 mb-4">
            <div class="table-responsive">
                <table class="table container-fluid tablaGanadores mx-0 display" width="100%">
                    <thead class="table-bordered">
                        <tr class="">
                            <th>No.</th>
                            <th>Fecha</th>
                            <th>Sorteo</th>
                            <th>Venta Total</th>
                            <th>Ganador</th>
                            <th>Premio</th>
                            <th>Utilidad</th>
                            <th>Resumen</th>
                        </tr>

                        <tr class="">
                            <th>No.</th>
                            <th>Fecha</th>
                            <th>Sorteo</th>
                            <th>Venta Total</th>
                            <th>Ganador</th>
                            <th>Premio</th>
                            <th>Utilidad</th>
                            <th>Resumen</th>
                        </tr>
                    </thead>
                    <tbody class="table-bordered">

                    </tbody>

                </table>

                <?php
                $hi1 = '11:00:00';
                $hf1 = '11:15:00';
                $hi2 = '15:00:00';
                $hf2 = '15:15:00';
                $hi3 = '21:00:00';
                $hf3 = '21:15:00';

                if ((($Time > $hi1) && ($Time < $hf1)) || (($Time > $hi2) && ($Time < $hf2)) || (($Time > $hi3) && ($Time < $hf3))) {
                    
                    if(($gan['fecha'] === $gan['fActual']) && ($gan['sorteo'] === $gan['sActual'])){
                        echo '<p class="card-text text-center mt-5 px-2">Ya agregó un ganador para este sorteo.</p>';
                    }else{
                        $display = 'd-block';
                        echo '
                        <div class="d-flex  justify-content-end">
                            <button type="submit" id="" class="btn btn-info col-3" data-toggle="modal" data-target="#agregarGanador">Agregar Ganador</button>
                        </div>
                        ';
                    }

                } else {
                    $display = 'd-none';
                }
            ?>

            </div>
        </div>
    </div>
    </div>
  </section>


  <div class="modal fade mt-5" id="agregarGanador" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog container">

    <div class="card">
      
      <form method="post">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title col-12 text-center" id="exampleModalLabel">Formulario de Ventas</h5>
          </div>
          <div class="modal-body">

          <div class="input-group mb-3">
              <div class="input-group-prepend col-3 p-0">
                <span class="input-group-text col-12" id="basic-addon3">Fecha</span>
              </div>
              <input type="text" class="form-control shadow-none border text-center col-9" id="registroFecha" name="registroFecha" value="<?php echo $Fecha ?>" readonly require>
            </div>

            <div class="input-group mb-3">
              <div class="input-group-prepend col-3 p-0">
                <span class="input-group-text col-12" id="basic-addon3">Sorteo</span>
              </div>
              <select class="form-control shadow-none border col-9" id="registroSorteo" name="registroSorteo" required>
                <option value="<?php echo $id ?>" class="registroSorteoOption text-center"><?php echo $valor ?></option>
              </select>
            </div>

            <div class="input-group mb-3">
              <div class="input-group-prepend col-3 p-0">
                <span class="input-group-text col-12" id="basic-addon3">Ventas</span>
              </div>
              <input type="number" class="form-control shadow-none border text-center col-9" id="registroVentas" name="registroVentas" value="<?php echo $ventasTotales[0] ?? '0' ?>" readonly require>
            </div>

            <input type="hidden" name="regIdInversion">

            <div class="input-group mb-3">
              <div class="input-group-prepend col-3 p-0">
                <span class="input-group-text col-12" id="basic-addon3">Ganador</span>
              </div>
              <input type="number" class="form-control shadow-none border text-center col-9" id="registroGanador" name="registroGanador" placeholder="" require>
            </div>

            <div class="input-group mb-3">
              <div class="input-group-prepend col-3 p-0">
                <span class="input-group-text col-12" id="basic-addon3">Inversión</span>
              </div>
              <input type="number" class="form-control shadow-none border text-center col-9" id="registroInversion" name="registroInversion" placeholder="" require>
            </div>

            <div class="input-group mb-3">
              <div class="input-group-prepend col-3 p-0">
                <span class="input-group-text col-12" id="basic-addon3">Premio</span>
              </div>
              <input type="number" class="form-control shadow-none border text-center col-9" id="registroPremio" name="registroPremio" placeholder="" readonly require>
            </div>

            <input type="hidden" name="registroUsuario" id="registroUsuario" value="<?php echo $usuarioIngreso["id"] ?>">

          </div>
          <div class="modal-footer d-flex  justify-content-end">
            <div>
                <button data-dismiss="modal" id="" class="btn btn-danger">Cerrar</button>
            </div>
            <div>
              <button type="submit" id="" class="btn btn-info">Guardar</button>
            </div>
          </div>
        </div>

        <?php
        $venta = new ControladorGanadores;
        $venta->ctrRegistroGanadores();
        ?>
      </form>
</div>
</div>
</div>

<div class="modal fade mt-5" id="verResumen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog container">

    <div class="card">
      <h2 class="text-center pt-5 text-success text-bold">RIFA DÍAZ</h2>
      <div id="sorteo"></div>
      <div class="Fecha"></div>
      <div class="Ganador"></div>
      <!-- <h5 class="pl-2 pt-2">Vendedor: <span class="text-success"><?php echo $usuarioIngreso["nombre"] ?></span> </h5>
      <h5 class="pl-2">Boleto no: <span class="text-success"><?php echo $recibo ?></span> </h5> -->
      <div class="card-body">

        <div class="row border-bottom">
          <p class="text-center col-4 font-weight-bolder">Ruta</p>
          <p class="text-center col-4 font-weight-bolder">Venta</p>
          <p class="text-center col-4 font-weight-bolder">Premio</p>
        </div>

        <form method="post" class="encabezadoLista" id="">

          <div class="row viendoLista" id="viendoLista">

          </div>

          <div class="d-flex modal-footer justify-content-end">
            <button data-dismiss="modal" id="" class="btn btn-info">Cerrar</button>
          </div>

        </form>

      </div>

    </div>
  </div>
</div>