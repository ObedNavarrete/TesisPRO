<?php

if (($usuarioIngreso['id'] != 1)) {
    echo "<script>
            window.location = 'inicio';
        </script>";
    return;
}

$usuarios = ControladorUsuarios::ctrMostrarUsuarios(null, null);
$numeros = ControladorNumeros::ctrMostrarNumeros(null, null);

?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 ml-2">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">SIGES</a></li>
                <li class="breadcrumb-item active">Límite Ventas</li>
            </ol>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->

    <div class="card mx-1 mx-lg-2">
        <div class="card-header border-transparent">
            <h3 class="card-title text-center h2">Límite de Ventas</h3>

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
                <table class="table container-fluid tablaVentasLimite mx-0 display" width="100%">
                    <thead class="table-bordered">
                        <tr>
                            <th>Nombre</th>
                            <th>Ruta</th>
                            <th>Número</th>
                            <th>Límite</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="table-bordered text-center">

                    </tbody>
                </table>

            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.card-body -->

        <!-- <div class="card-footer clearfix">
            <button class="btn btn-sm btn-secondary float-right" data-toggle="modal" data-target="#agregarLimite">Nuevo Registro</button>
        </div> -->

    </div>
    <!-- /.card -->
</div>

<!--MODAL EDITAR USUARIO-->
<div class="modal fade mt-5" id="editarLimite" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header barra-header-adminlte">
                    <h5 class="modal-title col-12 text-center" id="exampleModalLabel">Editar</h5>
                </div>
                <div class="modal-body">

                    <input type="hidden" name="editarId">

                    <div class="input-group mb-3">
                        <select class="form-control shadow-none border" id="editarUsuario" name="editarUsuario" required readonly>
                            <option value="" class="editarUsuarioOption text-center"></option>
                        </select>
                    </div>

                    <div class="input-group mb-3">
                        <select class="form-control shadow-none border" id="editarNumero" name="editarNumero" required readonly>
                            <option value="" class="editarNumeroOption text-center"></option>
                        </select>
                    </div>

                    <div class="input-group mb-3">
                        <input type="number" class="form-control shadow-none border text-center" name="editarLimite" placeholder="Premio Máximo" require>
                    </div>

                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>

            <?php
            $editarLimite = new ControladorVentasLimite;
            $editarLimite->ctrEditarVentaLimite();
            ?>
        </form>
    </div>
</div>