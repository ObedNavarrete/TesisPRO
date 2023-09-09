<?php

if($dia == 5){
  $va = 1;
}else if ($dia == 6){
  $va = 1;
}else{
  $va = 0;
}

if (($usuarioIngreso['rol'] != 'Editor') || ($va == 0)) {
  echo "<script>
            window.location = 'inicio';
      </script>";
  return;
}

$usuarios = ControladorUsuarios::ctrMostrarUsuarios(null, null);
$sorteos = ControladorSorteos::ctrMostrarSorteos(null, null);

date_default_timezone_set('America/Managua');
$Date = date('d/m/Y');
$Time = date('H:i:s', time());
?>

<div id="carouselExampleControls" class="carousel slide" data-ride="carousel" data-interval=false>
<div class="carousel-inner">
<div class="carousel-item active" data-interval=false>

<section class="content formulario-ventas mt-0 mb-0">
  <div class="modal-body d-flex  justify-content-end">
    <a href="xVer-ventas-num" id="" class="btn btn-warning mr-2 text-white">Números</a>
    <a href="xVer-ventas" id="" class="btn btn-success">Recibos</a>
  </div>
  <div class="container-fluid form-ag">
    <form method="post">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title col-12 text-center" id="exampleModalLabel">Venta Lotería</h5>
        </div>
        <div class="modal-body">

          <input type="hidden" id="diadehoy" value="<?php echo $dia ?>">

          <div class="input-group mb-3">
            <div class="input-group-prepend col-4 p-0">
              <span class="input-group-text col-12" id="basic-addon3">Sorteo</span>
            </div>
            <input type="text" class="form-control shadow-none border text-center col-8" id="" name="" placeholder="" value="Lotería" readonly>
          </div>

          <div class="input-group mb-3">
            <div class="input-group-prepend col-4 p-0">
              <span class="input-group-text col-12" id="basic-addon3">Número</span>
            </div>
            <input type="number" class="form-control shadow-none border text-center col-8" id="registroNumeroLoteria" name="registroNumeroLoteria" placeholder="" maxlength="2" onkeyup="if (this.value.length == this.getAttribute('maxlength')) registroInversionLoteria.focus()" require>
          </div>

          <div class="input-group mb-3">
            <div class="input-group-prepend col-4 p-0">
              <span class="input-group-text col-12" id="basic-addon3">R Monto</span>
            </div>
            <input type="number" class="form-control shadow-none border text-center col-8" id="registroInversionLoteria" name="registroInversionLoteria" placeholder="" require>
          </div>

          <input type="hidden" name="regIdInversion">

          <div class="input-group mb-3">
            <div class="input-group-prepend col-4 p-0">
              <span class="input-group-text col-12" id="basic-addon3">Actual</span>
            </div>
            <input type="number" class="form-control shadow-none border text-center col-8" id="registroActualNumLoteria" name="registroActualNumLoteria" placeholder="" readonly require>
          </div>

          <div class="input-group mb-3">
            <div class="input-group-prepend col-4 p-0">
              <span class="input-group-text col-12" id="basic-addon3">Límite</span>
            </div>
            <input type="number" class="form-control shadow-none border text-center col-8" id="registroMaximoLoteria" name="registroMaximoLoteria" placeholder="" readonly require>
          </div>

          <!-- <div class="input-group mb-3">
            <div class="input-group-prepend col-4 p-0">
              <span class="input-group-text col-12" id="basic-addon3">Premio</span>
            </div>
            <input type="number" class="form-control shadow-none border text-center col-8" id="registroPremioLoteria" name="registroPremioLoteria" placeholder="" readonly require>
          </div> -->

          <input type="hidden" name="registroUsuarioLoteria" id="registroUsuarioLoteria" value="<?php echo $usuarioIngreso["id"] ?>">
          <input type="hidden" name="registroPasivoLoteria" id="registroPasivoLoteria" value="">

        </div>
        <div class="modal-footer d-flex  justify-content-end">
          <div>
            <a type="" id="agregarElementoLoteria" class="btn btn-danger agregar">Agregar</a>
          </div>
        </div>
      </div>
    </form>
  </div>
</section>

</div>

<div class="carousel-item" data-interval=false>

<section class="content formulario-ventas mb-5">
  <div class="container-fluid mt-5">

    <?php
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $recibo = substr(str_shuffle($permitted_chars), 0, 8);
    ?>

    <div class="card">
      <h2 class="text-center pt-5">RIFA DÍAZ</h2>
      <h5 class="pl-3 pt-2 text-center">Lotería del <span class="text-success"><?php echo $Date ?></span> </h5>
      <h5 class="pl-3 text-center">Vendedor: <span class="text-success"><?php echo $usuarioIngreso["nombre"] ?></span> </h5>
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

          <input type="hidden" id="arrayParaVenderLoteria" name="arrayParaVenderLoteria">
          <input type="hidden" id="regReciboLoteria" name="regReciboLoteria" value="<?php echo $recibo ?>">

          <?php
          $hi1 = '18:00:00'; /* 6 de la tarde */

          if (($Time >= $hi1)) {
            $display = 'd-none';
            echo '
                    <p class="card-text text-center text-info text-uppercase h3">No es posible realizar ventas en este momento<p/>
                    ';
          } else {
            $display = 'd-block';

            echo '
                    <p class="card-text text-center">Por favor, asegurese de que la información que guarde, esté correcta</p>
          
                    <div class="d-flex  justify-content-end">
                          <button type="submit" id="" class="btn btn-info col-4">Guardar</button>
                    </div>
                    ';
          }
          ?>

          <?php
          $guardarVentaLoteria = new ControladorVentasLoteria;
          $guardarVentaLoteria->ctrRegistroVenta();
          ?>
        </form>

        <div class="d-flex  justify-content-end mt-2">
          <button id="limpiarReciboLoteria" class="btn btn-success col-4 <?php echo $display ?>">Limpiar</button>
        </div>

      </div>
    </div>
  </div>
</section>

</div>
</div>

</div>