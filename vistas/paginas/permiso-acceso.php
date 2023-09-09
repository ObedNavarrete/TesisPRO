<?php
if ($usuarioIngreso['rol'] != 'Super') {
    echo "<script>
            window.location = 'inicio';
        </script>";
    return;
}

$usuarios = ControladorPermisoAcceso::ctrMostrarUsuariosAcceso();
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 ml-2">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">SIGES</a></li>
                <li class="breadcrumb-item active">Números</li>
            </ol>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->

    <div class="card mx-1 mx-lg-4">
        <div class="card-header border-transparent">
            <h3 class="card-title text-center h2">Permisos de Acceso al Sistema</h3>

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
                <table class="table m-0">
                    <thead>
                        <tr class="text-center">
                            <th>Vendedor</th>
                            <th>Acceso</th>
                        </tr>
                    </thead>
                    <tbody class="">
                        <?php foreach ($usuarios as $key => $value) : ?>
                            <?php
                            if ($value["acceso"] == 0) {
                                $permiso = "<button class='btn btn-success col-8 btn-sm btnDarAcceso' user='" . $value['id'] . "' estado='1'>SI</button>";
                            } else {
                                $permiso = "<button class='btn btn-danger col-8 btn-sm btnDarAcceso' user='" . $value['id'] . "' estado='0'>NO</button>";
                            };
                            ?>
                            <tr class="text-center">
                                <td><?php echo $value["nombre"] ?></td>
                                <td><?php echo $permiso ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>