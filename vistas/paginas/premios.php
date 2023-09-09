<?php

if ($usuarioIngreso['rol'] != 'Super') {
    echo "<script>
            window.location = 'inicio';
        </script>";
    return;
}

?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 ml-2">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">SIGES</a></li>
                <li class="breadcrumb-item active">Premios</li>
            </ol>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->

    <div class="card mx-1 mx-lg-2">
        <div class="card-header border-transparent">
            <h3 class="card-title text-center h2">Catálogo de Números</h3>

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
                <table class="table container-fluid tablaPremios mx-0 display" width="100%">
                    <thead class="table-bordered">
                        <tr>
                            <th>Monto</th>
                            <th>Premio</th>
                            <th>Tabla</th>
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

        <div class="card-footer clearfix">
            <button class="btn btn-sm btn-secondary float-right" data-toggle="modal" data-target="#agregarInversion">Nuevo Registro</button>
        </div>

    </div>
    <!-- /.card -->
</div>



<div class="modal fade" id="agregarInversion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title col-12 text-center" id="exampleModalLabel">Nuevo Número</h5>
                </div>
                <div class="modal-body">

                    <!-- Monto -->
                    <div class="input-group mb-3">
                        <input type="text" class="form-control shadow-none border text-center" name="registroInversion" placeholder="Ingresa el Monto" require>
                    </div>

                    <!-- Premio -->
                    <div class="input-group mb-3">
                        <input type="text" class="form-control shadow-none border text-center" name="registroPremio" placeholder="Premio Equivalente" require>
                    </div>

                    <div class="input-group mb-3" id="tablaDePremio">
                        <select class='form-control shadow-none border text-center dentroTabla' id='registroTabla' name='registroTabla' required>
                            <option value='1' selected='selected'>400 x 5</option>
                            <option value='2'>350 x 5</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                    <div>
                        <button type="submit" id="guardar-Usuario" class="btn btn-dark">Guardar</button>
                    </div>
                </div>
            </div>

            <?php
            $registroInversion = new ControladorPremios;
            $registroInversion->ctrRegistroPremios();
            ?>

        </form>
    </div>
</div>


<div class="modal fade" id="editarInversion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header barra-header-adminlte">
                    <h5 class="modal-title col-12 text-center" id="exampleModalLabel">Editar Registro</h5>
                </div>
                <div class="modal-body">

                    <input type="hidden" name="editarId">

                    <!-- Monto -->
                    <div class="input-group mb-3">
                        <div class="input-gruop-append input-group-text">
                            <span class="fas fa-signature"></span>
                        </div>
                        <input type="text" class="form-control shadow-none border" name="editarInversion" require>
                    </div>

                    <!-- Premio -->
                    <div class="input-group mb-3">
                        <div class="input-gruop-append input-group-text">
                            <span class="fas fa-signature"></span>
                        </div>
                        <input type="text" class="form-control shadow-none border" name="editarPremio" require>
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
            $editarInversion = new ControladorPremios;
            $editarInversion->ctrEditarPremios();
            ?>

        </form>
    </div>
</div>