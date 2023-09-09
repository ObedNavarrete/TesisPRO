<?php
if ($usuarioIngreso['rol'] != 'Super') {
    echo "<script>
            window.location = 'inicio';
        </script>";
    return;
}

$usuarios = ControladorPermisoImpresion::ctrMostrarUsuariosImprimen();
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
            <h3 class="card-title text-center h2">Permisos de Impresion</h3>

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
                            <th>Imprime?</th>
                        </tr>
                    </thead>
                    <tbody class="">
                        <?php foreach ($usuarios as $key => $value) : ?>
                            <?php
                            if ($value["imprime"] == 1) {
                                $permiso = "<button class='btn btn-success col-8 btn-sm btnDarPermiso' user='" . $value['id'] . "' estado='0'>SI</button>";
                            } else {
                                $permiso = "<button class='btn btn-danger col-8 btn-sm btnDarPermiso' user='" . $value['id'] . "' estado='1'>NO</button>";
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



<!--MODAL CREAR USUARIO-->
<div class="modal fade ml-1 mr-1" id="agregarUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title col-12 text-center" id="exampleModalLabel">Nuevo Usuario</h5>
                </div>
                <div class="modal-body">

                    <!-- Nombre -->
                    <div class="input-group mb-3">
                        <input type="text" class="form-control shadow-none border text-center" name="registroNombre" placeholder="Ingresa el nombre" require>
                    </div>

                    <!-- Usuario -->
                    <div class="input-group mb-3">
                        <input type="text" class="form-control shadow-none border text-center" name="registroUsuario" placeholder="Ingresa el usuario" require>
                    </div>

                    <!-- Password -->
                    <div class="input-group mb-3">
                        <input type="password" class="form-control shadow-none border text-center" name="registroPassword" placeholder="Ingresa la contraseña" require>
                    </div>

                    <!-- //LLevando datos desde la consulta de la base de datos en la tabla foranea -->
                    <div class="input-group mb-3">
                        <select class="form-control shadow-none border text-center" name="registroRol" required>
                            <option value="default" selected="selected">Seleccione el rol de usuario</option>
                            <?php foreach ($roles as $key => $valueRoles) : ?>
                                <option value="<?php echo $valueRoles['id']; ?>"><?php echo $valueRoles['nombre']; ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <!-- //LLevando datos desde la consulta de la base de datos en la tabla foranea -->
                    <div class="input-group mb-3">
                        <select class="form-control shadow-none border text-center" name="registroRuta" required>
                            <option value="default" selected="selected">Seleccione la ruta del usuario</option>
                            <?php foreach ($rutas as $key => $valueRutas) : ?>
                                <option value="<?php echo $valueRutas['id']; ?>"><?php echo $valueRutas['nombre']; ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>

                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                    <div>
                        <button type="submit" id="guardar-Usuario" class="btn btn-success">Guardar</button>
                    </div>
                </div>
            </div>

            <?php
            $registroUsuario = new ControladorUsuarios;
            $registroUsuario->ctrRegistroUsuario();
            ?>
        </form>
    </div>
</div>