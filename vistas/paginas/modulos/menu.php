  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="inicio" class="brand-link">
        <span class="brand-text font-weight-weight ml-2">Gestión de Sorteos</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/AdminLTELogo.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $usuarioIngreso["nombre"] ?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Buscar" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="inicio" class="nav-link inicio" inf="inicio">
              <i class="nav-icon fab fa-instalod"></i>
              <p>
                Inicio
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="recibos-anteriores" class="nav-link inicio" inf="inicio">
              <i class="nav-icon fas fa-undo"></i>
              <p>
                Recibos Anteriores
              </p>
            </a>
          </li>
          
          <?php
              if($dia == 5){
                $cond = 1;
              }else if ($dia == 6){
                $cond = 1;
              }else {
                $cond = 0;
              }
          ?>

          <?php if (($usuarioIngreso['idRol'] != 2) && ($cond == 1)) : ?>
            <li class="nav-item ">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-cookie"></i>
                <p>
                  Lotería
                  <i class="right fas fa-angle-left text-info"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item ml-1">
                  <a href="xVentas-vendedores" class="nav-link" inf="numeros">
                    <i class="fas fa-angle-right nav-icon text-success"></i>
                    <p>Vendedores</p>
                  </a>
                </li>
                <li class="nav-item ml-1">
                  <a href="xVer-ventas-num" class="nav-link" inf="premios">
                    <i class="fas fa-angle-right nav-icon text-success"></i>
                    <p>Números</p>
                  </a>
                </li>
                <li class="nav-item ml-1">
                  <a href="xVer-ventas" class="nav-link" inf="numeros">
                    <i class="fas fa-angle-right nav-icon text-success"></i>
                    <p>Boletos</p>
                  </a>
                </li>
                <li class="nav-item ml-1">
                  <a href="xGanadores" class="nav-link" inf="premios">
                    <i class="fas fa-angle-right nav-icon text-success"></i>
                    <p>Ganadores</p>
                  </a>
                </li>
                <li class="nav-item ml-1">
                  <a href="xGanadoresDetalle" class="nav-link" inf="premios">
                    <i class="fas fa-angle-right nav-icon text-success"></i>
                    <p>Detalle Premios</p>
                  </a>
                </li>
              </ul>
            </li>
          <?php endif; ?>
          <!-- Hasta oubfwuoefbweofibewo;ewbfewobfewijbfowei'fpew'ofbew -->

          <?php if ($usuarioIngreso['rol'] == 'Editor') : ?>
          <?php if ($dia == 6 && $usuarioIngreso['idRuta'] == 5) : ?>
              <li class="nav-item">
                <a href="xLoteria" class="nav-link info-vendedor" inf="info-vendedor">
                  <i class="nav-icon fas fa-poll"></i>
                  <p>
                    Lotería
                  </p>
                </a>
              </li>
            <?php endif; ?>

          <?php if ($dia == 5) : ?>
              <li class="nav-item">
                <a href="xLoteria" class="nav-link info-vendedor" inf="info-vendedor">
                  <i class="nav-icon fas fa-poll"></i>
                  <p>
                    Lotería
                  </p>
                </a>
              </li>
            <?php endif; ?>

          <li class="nav-item">
            <a href="info-vendedor" class="nav-link info-vendedor" inf="info-vendedor">
              <i class="nav-icon fas fa-info"></i>
              <p>
                Info
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="historia" class="nav-link info-vendedor" inf="info-vendedor">
              <i class="nav-icon fas fa-step-backward"></i>
              <p>
                Historial
              </p>
            </a>
          </li>
          <?php endif; ?>

          <?php if (($usuarioIngreso['rol'] == 'Administrador') || ($usuarioIngreso['rol'] == 'Super')) : ?>
          <li class="nav-item">
            <a href="usuarios" class="nav-link usuarios" inf="usuarios">
              <i class="nav-icon fas fa-user-circle"></i>
              <p>
                Usuarios
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="ventas-limite" class="nav-link ventas-limite" inf="ventas-limite">
              <i class="nav-icon fas fa-highlighter"></i>
              <p>
                  Establecer Límites
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="listas" class="nav-link ventas-limite" inf="listas">
              <i class="nav-icon fas fa-list-ul"></i>
              <p>
                  Listas
              </p>
            </a>
          </li>
          <?php endif; ?>

          <?php if (($usuarioIngreso['idRol'] == 4) || ($usuarioIngreso['idRol'] == 1) || ($usuarioIngreso['idRol'] == 3)) : ?>
          <li class="nav-item">
            <a href="ventas-vendedores" class="nav-link ventas-vendedores" inf="ventas-vendedores">
              <i class="nav-icon fas fa-user-friends"></i>
              <p>
                Vendedores
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="ver-ventas-num" class="nav-link ver-ventas-num" inf="ver-ventas-num">
              <i class="nav-icon fas fa-file-excel"></i>
              <p>
                Números
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="ver-ventas" class="nav-link ver-ventas" inf="ver-ventas">
              <i class="nav-icon fas fa-file-invoice-dollar"></i>
              <p>
                Recibos
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="resumen-diario" class="nav-link resumen-diario" inf="resumen-diario">
              <i class="nav-icon fas fa-calculator"></i>
              <p>
                Resumen Diario
              </p>
            </a>
          </li>
          <?php endif; ?>

          <?php if (($usuarioIngreso['idRol'] == 4) || ($usuarioIngreso['idRol'] == 1)) : ?>
          <li class="nav-item">
            <a href="ganadores" class="nav-link ganadores" inf="ganadores">
              <i class="nav-icon fas fa-trophy"></i>
              <p>
                Ganadores
              </p>
            </a>
          </li>
          <?php endif; ?>

          <li class="nav-item">
            <a href="ganadoresDetalle" class="nav-link ganadoresDetalle" inf="ganadoresDetalle">
              <i class="nav-icon fas fa-spinner"></i>
              <p>
                Detalle Premios
              </p>
            </a>
          </li>

          <?php if (($usuarioIngreso['idRol'] == 4) || ($usuarioIngreso['idRol'] == 1)) : ?>
          <li class="nav-item">
            <a href="ventasFecha" class="nav-link ventasFecha" inf="ventasFecha">
              <i class="nav-icon far fa-calendar"></i>
              <p>
                Ventas Fecha
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="permiso-impresion" class="nav-link ventasFecha" inf="permiso-impresion">
              <i class="nav-icon fas fa-print"></i>
              <p>
                Impresión
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="permiso-acceso" class="nav-link" inf="permiso-acceso">
              <i class="nav-icon fas fa-key"></i>
              <p>
                Acceso
              </p>
            </a>
          </li>

          <li class="nav-item ">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Catálogos
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="numeros" class="nav-link" inf="numeros">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Números</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="premios" class="nav-link" inf="premios">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Premios</p>
                </a>
              </li>
            </ul>
          </li>
          <?php endif; ?>

        </ul>
      </nav>
    </div>
  </aside>