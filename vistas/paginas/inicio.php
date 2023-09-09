<?php
$usuarios = ControladorUsuarios::ctrMostrarUsuarios(null, null);
$sorteos = ControladorSorteos::ctrMostrarSorteos(null, null);

date_default_timezone_set('America/Managua');
$Date = date('Y-m-d');
$Time = date('H:i:s', time());

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

//PARA VER EL TOTAL DE VENTAS
if ($usuarioIngreso['rol'] == 'Supervisor') {
  $ventasTotales = ControladorInicio::ctrMostrarTotalVentasInicio("u.idRuta", $usuarioIngreso['idRuta']);
} else if ($usuarioIngreso['rol'] == 'Super') {
  $ventasTotales = ControladorInicio::ctrMostrarTotalVentasInicio(null, null);
}

//PARA VER EL VENDEDOR CON MAYOR VENTA
if ($usuarioIngreso['rol'] == 'Supervisor') {
  $vendedorMayor = ControladorInicio::ctrMostrarMaximoVendedor("u.idRuta", $usuarioIngreso['idRuta']);
} else if ($usuarioIngreso['rol'] == 'Super') {
  $vendedorMayor = ControladorInicio::ctrMostrarMaximoVendedor(null, null);
}

//esto
if ($usuarioIngreso['rol'] == 'Supervisor') {
  $ventasTotalesLoteria = ControladorLoteria::ctrMostrarTotalVentasInicio("u.idRuta", $usuarioIngreso['idRuta']);
} else if ($usuarioIngreso['rol'] == 'Super') {
  $ventasTotalesLoteria = ControladorLoteria::ctrMostrarTotalVentasInicio(null, null);
}
//ESTO

//PARA VER EL CONTEO DE VENDEDORES
if ($usuarioIngreso['rol'] == 'Supervisor') {
  $conteoUsuarios = ControladorInicio::ctrMostrarConteoUsuario("u.idRuta", $usuarioIngreso['idRuta']);
} else if ($usuarioIngreso['rol'] == 'Super') {
  $conteoUsuarios = ControladorInicio::ctrMostrarConteoUsuario(null, null);
}


//Evaluando Cuál Es El Número Con Mayor Premio
if (($usuarioIngreso['rol'] == 'Super')) {
  $respuesta = ControladorVentas::ctrMostrarVentasAdministradorNum(null, null);
  $premio = 0;
  $venta = 0;
  $mayor = 0;

  foreach ($respuesta as $key => $value) {
    $premio = $premio + $value["premio"];
    $venta = $venta + $value["inversion"];

    if ($value["premio"] > $mayor) {
      $mayor = $value["premio"];
      $numero = $value["numero"];
    } else {
      $mayor = $mayor;
      $numero = $numero;
    }
  }
} else if (($usuarioIngreso['rol'] == 'Supervisor')) {
  $respuesta = ControladorVentas::ctrMostrarVentasSupervisorNum(null, null);
  $premio = 0;
  $venta = 0;
  $mayor = 0;

  foreach ($respuesta as $key => $value) {
    $premio = $premio + $value["premio"];
    $venta = $venta + $value["inversion"];

    if ($value["premio"] > $mayor) {
      $mayor = $value["premio"];
      $numero = $value["numero"];
    } else {
      $mayor = $mayor;
      $numero = $numero;
    }
  }
} else {
  $respuesta = ControladorVentas::ctrMostrarVentasVendedorNum(null, null);
  $premio = 0;
  $venta = 0;
  $mayor = 0;

  foreach ($respuesta as $key => $value) {
    $premio = $premio + $value["premio"];
    $venta = $venta + $value["inversion"];

    if ($value["premio"] > $mayor) {
      $mayor = $value["premio"];
      $numero = $value["numero"];
    } else {
      $mayor = $mayor;
      $numero = $numero;
    }
  }
}

if($usuarioIngreso['idTabla']==1){
    $informacion = 'RIFA DÍAZ';
}else{
    $informacion = 'LUCKY STAR';
}
?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"><?php echo $informacion; ?></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">SIGES</a></li>
          <li class="breadcrumb-item active">Inicio</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>

<?php if (($usuarioIngreso['rol'] == 'Editor')) : ?>


  <div id="carouselExampleControls" class="carousel slide" data-ride="carousel" data-interval=false>
    <div class="carousel-inner">
      <div class="carousel-item active" data-interval=false>

        <section class="content formulario-ventas mt-0 mb-0">
          <div class="modal-body d-flex  justify-content-end">
            <a href="ver-ventas-num" id="" class="btn btn-warning mr-2 text-white">Números</a>
            <a href="ver-ventas" id="" class="btn btn-success">Recibos</a>
          </div>
          <div class="container-fluid form-ag">
            <form method="post">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title col-12 text-center" id="exampleModalLabel">Formulario de Ventas</h5>
                </div>
                <div class="modal-body">

                  <div class="input-group w-100 mb-3 row container d-flex justify-content-center mx-0">
                    <select class="form-control shadow-none border col-6" id="registroSorteo" name="registroSorteo" required>
                      <option value="<?php echo $id ?>" class="registroSorteoOption text-center"><?php echo $valor ?></option>
                    </select>
                    <input type="number" class="form-control shadow-none border text-center col-6" id="registroMaximo" name="registroMaximo" placeholder="Límite" readonly require>
                  </div>

                  <div class="input-group w-100 mb-3 row container d-flex justify-content-center mx-0">
                    <input type="number" class="form-control shadow-none border text-center col-8" id="registroActualNum" name="registroActualNum" placeholder="Actual" readonly require>
                    <input type="number" class="form-control shadow-none border text-center col-8" id="registroPremio" name="registroPremio" placeholder="Premio" readonly require>
                  </div>

                  <div class="input-group w-100 mb-3 row container d-flex justify-content-center mx-0">
                    <input type="number" class="form-control shadow-none border text-center col-6" id="registroNumero" name="registroNumero" placeholder="Número" maxlength="2" onkeyup="if (this.value.length == this.getAttribute('maxlength')) registroInversion.focus()" require>
                    <input type="number" class="form-control shadow-none border text-center col-6" id="registroInversion" name="registroInversion" placeholder="Monto" require>
                  </div>

                  <input type="hidden" name="regIdInversion">


                  <input type="hidden" name="registroUsuario" id="registroUsuario" value="<?php echo $usuarioIngreso["id"] ?>">
                  <input type="hidden" name="registroPasivo" id="registroPasivo" value="">

                </div>
                <div class="modal-footer d-flex  justify-content-end">
                  <div>
                    <a type="" id="agregarElemento" class="btn btn-danger agregar">Agregar</a>
                  </div>
                </div>
              </div>



              <!-- <?php
                    $venta = new ControladorVentas;
                    $venta->ctrRegistroVentas();
                    ?> -->
            </form>
          </div>
        </section>
      </div>


      <div class="carousel-item" data-interval=false>
        <section class="content formulario-ventas mb-5">
          <div class="container-fluid">

            <?php
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $recibo = substr(str_shuffle($permitted_chars), 0, 8);
            ?>

            <div class="card">
              <h2 class="text-center pt-5">RIFA DÍAZ</h2>
              <h5 class="pl-3 pt-2 text-center">Vendedor: <span class="text-success"><?php echo $usuarioIngreso["nombre"] ?></span> </h5>
              <h5 class="pl-3 text-center">Boleto no: <span class="text-success"><?php echo $recibo ?></span> </h5>
              <div class="card-body">

                <div class="row border-bottom">
                  <p class="text-center col-4 font-weight-bolder">Número</p>
                  <p class="text-center col-4 font-weight-bolder">Monto</p>
                  <p class="text-center col-4 font-weight-bolder">Premio</p>
                </div>

                <form method="post" class="" id="nuevaVenta">
                  <input type="hidden" id="registroImprime" name="registroImprime" value=<?php echo $usuarioIngreso['imprime'] ?>>
                  <div class="row nuevaVenta">

                  </div>
                  <div class="input-group mb-3 border-top">
                    <input type="number" class="form-control shadow-none border-0 text-center totalisimo" name="regSumaBoleto" placeholder="" readonly require>
                  </div>

                  <input type="hidden" id="arrayParaVender" name="arrayParaVender">
                  <input type="hidden" id="regRecibo" name="regRecibo" value="<?php echo $recibo ?>">

                  <?php
                  $hi1 = '11:00:00';
                  $hf1 = '11:15:00';
                  $hi2 = '15:00:00';
                  $hf2 = '15:15:09';
                  $hi3 = '21:00:00';

                  if ((($Time > $hi1) && ($Time < $hf1)) || (($Time > $hi2) && ($Time < $hf2)) || (($Time > $hi3))) {
                    $display = 'd-none';
                    echo '
                    <p class="card-text text-center text-info text-uppercase h3">No es posible realizar ventas en este momento<p/>
                    ';
                  } else {
                    $display = 'd-block';

                    echo '
                    <div class="d-flex  justify-content-end">
                          <button type="submit" id="" class="btn btn-info col-4">Guardar</button>
                    </div>
                    ';
                  }
                  ?>

                  <?php
                  $guardarVenta = new ControladorVentas;
                  $guardarVenta->ctrRegistroVenta();
                  ?>
                </form>

                <div class="d-flex  justify-content-start" style="margin-top: -40px">
                  <button id="limpiarRecibo" class="btn btn-success col-4 <?php echo $display ?>">Limpiar</button>
                </div>

              </div>
            </div>
          </div>
        </section>

      </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
<?php endif; ?>

<?php if (($usuarioIngreso['rol'] != 'Editor')) : ?>
  <section class="content">
    <div class="container-fluid">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-coins"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Totales</span>
              <span class="info-box-number">
                <small>C$</small>
                <?php echo $ventasTotales[0] ?? '0'; ?>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-arrow-up"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">No. <?php echo isset($numero) ? $numero : '[$]'; ?></span>
              <span class="info-box-number">C$ <?php echo $mayor ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>

        <!-- ESTOOOOOOO -->
        <!-- ksu;dfvbidslhfvhdfdsvufdslhfdslhfsldbjfjlbdsfksdlbjfljvdshfkjlkjadbfhsdvf -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-user-check"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Lotería</span>
              <span class="info-box-number">
                <small>C$</small>
                <?php echo $ventasTotalesLoteria[0] ?? '0'; ?>
              </span>
            </div>
          </div>
        </div>
        <!-- ESTOOOOOOO -->
        <!-- ksu;dfvbidslhfvhdfdsvufdslhfdslhfsldbjfjlbdsfksdlbjfljvdshfkjlkjadbfhsdvf -->
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Vendedores</span>
              <span class="info-box-number ml-2"><?php echo $conteoUsuarios[0] ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
  </section>

  <?php if (($usuarioIngreso['rol'] == 'Super')) : ?>
  <section class="content formulario-ventas mb-3">
    <div class="container-fluid mt-3">


      <div class="table-responsive">

        <div class="card m-0">

          <div class="card-body">

            <h4 class="text-center">
              <span class="text-primary font-weight-bolder">VENTAS</span> VS <span class="text-warning font-weight-bolder">PREMIOS</span>
            </h4>

            <div id="myfirstchart" style="height: 250px;"></div>

          </div>

        </div>

        <script>
          new Morris.Line({
            element: 'myfirstchart',
            data: [
              <?php
              $respuestas = ControladorGanadores::ctrGraficoUtilidades();
              if ($respuestas != null) {
                foreach ($respuestas as $key => $value) {
                   echo "{ y: '" . $value["fechax"] . "', value: '" . $value["ganancia"] . "', value2:'" . $value["venta"] . "' },";
                }
              } else {
                echo "{ y: '0', value: '0' }";
              }
              ?>
            ],
            xkey: 'y',
            ykeys: ['value2', 'value'],
            labels: ['Ventas', 'Premios'],
            parseTime: false,
            lineColors: ['#007BFF', '#F39C12'],
            lineWidth: 2,
            hideHover: 'auto',
            gridTextColor: '#fff',
            gridStrokeWidth: 0.3,
            pointSize: 4,
            pointStrokeColors: ['black'],
            gridLineColor: 'black',
            gridTextFamily: 'Poppins',
            gridTextSize: 12,
            resize: true
          });
        </script>

      </div>
    </div>
  </section>
  <?php endif; ?>

  <div class="mt-5">
  </div>

<?php endif; ?>

</div>