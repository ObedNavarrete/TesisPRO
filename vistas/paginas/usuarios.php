<?php

if (($usuarioIngreso['idRol'] != 4)) {
    echo "<script>
            window.location = 'inicio';
        </script>";
    return;
}

$usuarios = ControladorUsuarios::ctrMostrarUsuarios(null, null);
$roles = ControladorRoles::ctrMostrarRoles();
$rutas = ControladorRutas::ctrMostrarRutas();
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 ml-2">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">SIGES</a></li>
                <li class="breadcrumb-item active">Usuarios</li>
            </ol>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->

    <div class="card mx-1 mx-lg-4">
        <div class="card-header border-transparent">
            <h3 class="card-title text-center h2">Lista de Usuarios del Sistema</h3>

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
        
        <div class="clearfix mr-3 mb-0">
            <button class="btn btn-sm btn-info float-left ml-2 mt-1 mb-1" data-toggle="modal" data-target="#agregarUsuario">Nuevo Usuario</button>
        </div>
        <!-- /.card-footer -->

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table m-0 tablaUsuarios">
                    <thead>
                        <tr class="text-center">
                            <th>Nombre</th>
                            <th>Usuario</th>
                            <th>Premio</th>
                            <th>Ruta</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="">


                        <?php foreach ($usuarios as $key => $value) : ?>
                            <?php
                            $acciones = "<div class='btn-group'><button class='btn btn-warning shadow-none btn-sm editarUsuario' data-toggle='modal' data-target='#editarUsuario' idUsuario='" . $value["id"] . "'><i class='fas fa-pencil-alt shadow-none text-white'></i></button><button class='btn btn-danger btn-sm btnEliminar'id-usuario='" . $value["id"] . "'><i class='fas fa-trash-alt text-white'></i></button></div>";
                            
                            if ($value["idTabla"] == 1) {
                                $texto = "400 x 5";
                            }else{
                                $texto = "350 x 5";
                            }

                            if ($value["idRol"] != 2) {
                                $texto = "No aplica";
                            }


                            ?>
                            <tr class="text-center">
                                <td><?php echo $value["nombre"] ?></td>
                                <td><?php echo $value["usuario"] ?></td>
                                <td><?php echo $texto ?></td>
                                <td><?php echo $value["ruta"] ?></td>
                                <td><?php echo $value["rol"] ?></td>
                                <td><?php echo $acciones ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.card-body -->
        <!--<div class="card-footer clearfix">
            <button class="btn btn-sm btn-secondary float-right" data-toggle="modal" data-target="#agregarUsuario">Nuevo Usuario</button>
        </div> -->
        <!-- /.card-footer -->
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
                <div class="modal-body" id="inputmodal">

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
                        <select class="form-control shadow-none border text-center" id="registroRol" name="registroRol" required>
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

                    <!-- <div class="input-group mb-3">
                        <input type="number" class="form-control shadow-none border text-center" name="registroLimite" placeholder="Límite" require>
                    </div> -->

                    <!-- ofdsjuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuutablauuuuuuu -->
                    <div class="input-group mb-3" id="tablaDePremio">
                        
                    </div>
                    <!-- fddddddddddddddddddddddddddddddddddddddddddddddddddddddd -->

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


<!--MODAL EDITAR USUARIO-->
<div class="modal fade mt-5" id="editarUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header barra-header-adminlte">
                    <h5 class="modal-title col-12 text-center" id="exampleModalLabel">Editar Usuario</h5>
                </div>
                <div class="modal-body body-form-edit">

                    <input type="hidden" name="editarId">

                    <!-- Nombre -->
                    <div class="input-group mb-3">
                        <input type="text" class="form-control shadow-none border text-center" name="editarNombre" require>
                    </div>

                    <!-- Usuario -->
                    <div class="input-group mb-3">
                        <input type="text" class="form-control shadow-none border text-center" name="editarUsuario" require>
                    </div>

                    <!-- Password -->
                    <div class="input-group mb-3">
                        <input type="text" class="form-control shadow-none border text-center" name="editarPassword" placeholder="Escribe una nueva contraseña" require>
                    </div>

                    
                      <!-- ifygdsdskfjjdshkfhsdkfuhsduoifgsdougfsdoufgdsofsd -->
                      <div class="input-group mb-3">
                          <select class="form-control shadow-none border text-center" id="editarTabla" name="editarTabla" required>
                          <option value="" class="editarTablaOption"></option>
                              
                                  <option value="1">400 x 5</option>
                                  <option value="2">350 x 5</option>
                              
                          </select>
                      </div>
                      <!-- kdhgfsldk;hfs;odugfuogyfr9ewpgfoiadsgfiasgufasiugfiasfuas -->
                    

                    <div class="input-group mb-3">
                        <select class="form-control shadow-none border text-center" name="editarRol" require readonly>
                            <option value="" class="editarPerfilOption"></option>
                            <!--/* <?php foreach ($roles as $key => $valueRoles) : ?> */
                                <option value="<?php echo $valueRoles['id']; ?>"><?php echo $valueRoles['nombre']; ?>
                                </option>
                            <?php endforeach ?>-->
                        </select>
                    </div>

                    <div class="input-group mb-3">
                        <select class="form-control shadow-none border text-center" name="editarRuta" require>
                            <option value="" class="editarRutaOption"></option>
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
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>

            <?php
            $registroUsuario = new ControladorUsuarios;
            $registroUsuario->ctrEditarUsuario();
            ?>
        </form>
    </div>
</div>