<?php
if (($usuarioIngreso['idRol'] != 4)) {
  echo "<script>
            window.location = 'inicio';
        </script>";
  return;
}

$usuarios = ControladorUsuarios::ctrMostrarUsuarios(null, null);
date_default_timezone_set('America/Managua');
$Time = date('H:i:s', time());
$Date = date('Y-m-d');
$Fecha = date('d/m/Y');
$ventasTotales = ControladorLoteria::ctrMostrarTotalVentasInicio(null, null);

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
      <h2 class="text-center pt-5 px-3">Números Ganadores de Lotería</h2>
      <h5 class="pl-3 pt-2 text-center">Usuario: <span class="text-success"><?php echo $usuarioIngreso["nombre"] ?></span> </h5>
      <h5 class="pl-3 text-center">Fecha: <span class="text-success"><?php echo $Fecha ?></span> </h5>

      <div class="card-body p-2 mb-4">
        <div class="table-responsive">
          <table class="table container-fluid tablaGanadoresLoteria mx-0 display" width="100%">
            <thead class="table-bordered">
              <tr class="">
                <th>No.</th>
                <th>Fecha</th>
                <th>Venta Total</th>
                <th>Ganador</th>
                <th>Inversión</th>
                <th>Premio</th>
                <th>Utilidad</th>
              </tr>
            </thead>
            <tbody class="table-bordered">

            </tbody>
          </table>

          <?php
          $hi1 = '18:00:00'; /* 6 de la tarde */

          if ($Time > $hi1) {
            $display = 'd-block';
            echo '
                    <p class="card-text text-center mt-5">Por favor, asegúrese de guardar el número ganador correcto.</p>
          
                    <div class="d-flex  justify-content-end">
                          <button type="submit" id="" class="btn btn-info col-3" data-toggle="modal" data-target="#agregarGanadorLoteria">Agregar Ganador</button>
                    </div>
                    ';
          } else {
            $display = 'd-none';
          }
          ?>

        </div>
      </div>
    </div>
  </div>
</section>


<div class="modal fade mt-5" id="agregarGanadorLoteria" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog container">

    <div class="card">

      <form method="post">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title col-12 text-center" id="exampleModalLabel">Ganador</h5>
          </div>
          <div class="modal-body">

            <!-- <div class="input-group mb-3">
              <div class="input-group-prepend col-3 p-0">
                <span class="input-group-text col-12" id="basic-addon3">Fecha</span>
              </div>
              <input type="text" class="form-control shadow-none border text-center col-9" value="<?php echo $Fecha ?>" readonly require>
            </div> -->

            <div class="input-group mb-3">
              <div class="input-group-prepend col-3 p-0">
                <span class="input-group-text col-12" id="basic-addon3">Lotería del</span>
              </div>
              <input type="text" class="form-control shadow-none border text-center col-9" value="<?php echo $Fecha ?>" readonly require>
            </div>

            <div class="input-group mb-3">
              <div class="input-group-prepend col-3 p-0">
                <span class="input-group-text col-12" id="basic-addon3">Ventas</span>
              </div>
              <input type="number" class="form-control shadow-none border text-center col-9" id="registroVentasLoteria" name="registroVentasLoteria" value="<?php echo $ventasTotales[0] ?? '0' ?>" readonly require>
            </div>

            <div class="input-group mb-3">
              <div class="input-group-prepend col-3 p-0">
                <span class="input-group-text col-12" id="basic-addon3">Ganador</span>
              </div>
              <input type="number" class="form-control shadow-none border text-center col-9" id="xRegistroGanadorLoteria" name="xRegistroGanadorLoteria" placeholder="" require>
            </div>

            <div class="input-group mb-3">
              <div class="input-group-prepend col-3 p-0">
                <span class="input-group-text col-12" id="basic-addon3">Monto</span>
              </div>
              <input type="number" class="form-control shadow-none border text-center col-9" id="xRegistroInversionLoteria" name="xRegistroInversionLoteria" placeholder="" require>
            </div>

            <div class="input-group mb-3">
              <div class="input-group-prepend col-3 p-0">
                <span class="input-group-text col-12" id="basic-addon3">Premio</span>
              </div>
              <input type="number" class="form-control shadow-none border text-center col-9" id="xRegistroPremioLoteria" name="xRegistroPremioLoteria" placeholder="" readonly require>
            </div>

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
        $venta = new ControladorGanadoresLoteria;
        $venta->ctrRegistroGanadores();
        ?>
      </form>
    </div>