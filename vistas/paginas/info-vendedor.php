<?php
if (($usuarioIngreso['idRol'] != 2)) {
    echo "<script>
            window.location = 'inicio';
        </script>";
    return;
}
    $ventasTotalesLoteria = ControladorLoteria::ctrMostrarTotalVentasInicio("v.idVendidoPor", $usuarioIngreso['id']);
    $ventasTotales = ControladorInicio::ctrMostrarTotalVentasInicio("v.idVendidoPor", $usuarioIngreso['id']);
?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">SIGES</a></li>
          <li class="breadcrumb-item active">Info</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>

<section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-coins"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Sorteo</span>
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
                <!-- TODOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO -->
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-user-tag"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Lotería</span>
            <span class="info-box-number">
              <small>C$</small>
              <?php echo $ventasTotalesLoteria[0] ?? "0" ?>
            </span>
          </div>
        </div>
      </div>
      <!-- ESTOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO -->
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-car"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Línea de Trabajo</span>
                <span class="info-box-number">Ruta <?php echo $usuarioIngreso["idRuta"] ?> </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-code"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Desarrollador</span>
                <span class="info-box-number"><a href="https://wa.me/50582724138" class="text-info">Obed Navarrete</a></span>
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