

<div class="content-header">

            <main>
                <div class="container-xl px-4 mt-5">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <!-- Basic login form-->
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="justify-content-center text-center card-header">
                                    <h4 class="text-center h3 mt-2 pt-2 px-2">Sistema de Gestión y Seguimiento de Sorteos</h4>
                                </div>
                                <div class="card-body">
                                    <!-- Login form-->
                                    <form class="mt-0" method="POST">

                                        <!-- Form Group (email address)-->
                                        <div class="mb-3 h4">
                                            <label class="small mb-1" for="inputEmailAddress">Usuario</label>
                                            <input class="form-control shadow-none border h4" name="ingUsuario" id="inputEmailAddress" type="text" placeholder="Escriba su Usuario" />
                                        </div>

                                        <!-- Form Group (password)-->
                                        <div class="mb-3 h4">
                                            <label class="small mb-1" for="inputPassword">Contraseña</label>
                                            <input class="form-control shadow-none border h4" name="ingPassword" id="inputPassword" type="password" placeholder="Escriba su Contraseña" />
                                        </div>

                                        <!-- Form Group (login box)-->
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button class="btn btn-primary" type="submit">Acceder</button>
                                        </div>
                                            <?php
                                                $login = new ControladorUsuarios();
                                                $login->ctrIngresoUsuario();
                                            ?>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
</div>