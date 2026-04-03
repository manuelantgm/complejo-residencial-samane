  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url(); ?>/crs/inicio" class="brand-link">
      <img src="<?= media(); ?>/img/mainLogo.png" alt="<?= SIGLAS; ?>" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light"><?= SIGLAS;?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?= media(); ?>/img/uploads/<?= $_SESSION['userData']['image']; ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="<?= base_url(); ?>/usuarios/perfil" class="d-block"><?= $nameShow; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="<?= base_url(); ?>/crs/inicio" class="nav-link <?php if($data['page_name'] == "dashboard"){echo "active";} ?>">
              <i class="nav-icon fa-solid fa-house"></i>
              <p>Inicio</p>
            </a>
          </li>
          <?php if(!empty($_SESSION['permisos'][MUSUARIOS]['r'])){ ?>
          <li class="nav-item">
            <a href="#" class="nav-link <?php if($data['page_name'] == "roles" || $data['page_name'] == "usuarios"){echo "active";} ?>">
              <i class="nav-icon fa-solid fa-users"></i>
              <p>
                Usuarios
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                <a href="<?= base_url(); ?>/usuarios" class="nav-link">
                  <i class="fa-solid fa-list-check nav-icon"></i>
                  <p>Lista usuarios</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url(); ?>/roles" class="nav-link">
                  <i class="fa-solid fa-user-tag nav-icon"></i>
                  <p>Rol de usuarios</p>
                </a>
              </li>
            </ul>
          </li>
          <?php } ?>
          <?php if(!empty($_SESSION['permisos'][MFAMILIES]['r'])){ ?>
          <li class="nav-item">
            <a href="<?= base_url(); ?>/crs/familias" class="nav-link <?php if($data['page_name'] == "families"){echo "active";} ?>">
              <i class="fa-solid fa-people-roof nav-icon"></i>
              <p>Familiares</p>
            </a>
          </li>
          <?php } ?>
          <?php if(!empty($_SESSION['permisos'][MEMPLOYEES]['r'])){ ?>
          <li class="nav-item">
            <a href="<?= base_url(); ?>/crs/empleados" class="nav-link <?php if($data['page_name'] == "employees"){echo "active";} ?>">
              <i class="fa-solid fa-list-check nav-icon"></i>
              <p>Empleados</p>
            </a>
          </li>
          <?php } ?>
          <?php if(!empty($_SESSION['permisos'][MVISITS]['r'])){ ?>
          <li class="nav-item">
            <a href="<?= base_url(); ?>/crs/visitas-frecuentes" class="nav-link <?php if($data['page_name'] == "visits"){echo "active";} ?>">
              <i class="fa-regular fa-handshake nav-icon"></i>
              <p>Visitas Frecuentes</p>
            </a>
          </li>
          <?php } ?>
          <?php if(!empty($_SESSION['permisos'][MVEHICLES]['r'])){ ?>
          <li class="nav-item">
            <a href="<?= base_url(); ?>/crs/vehiculos" class="nav-link <?php if($data['page_name'] == "vehicles"){echo "active";} ?>">
              <i class="fa-solid fa-car nav-icon"></i>
              <p>Vehiculos</p>
            </a>
          </li>
          <?php } ?>
          <?php if(!empty($_SESSION['permisos'][MCONFIGURACION]['r'])){ ?>
          <li class="nav-item">
            <a href="<?= base_url(); ?>/configuracion" class="nav-link <?php if($data['page_name'] == "configuracion"){echo "active";} ?>">
              <i class="fa-solid fa-gear nav-icon"></i>
              <p>Configuraci&oacute;n</p>
            </a>
          </li>
          <?php } ?>
          <li class="nav-item">
            <a href="<?= base_url(); ?>/logout" class="nav-link">
              <i class="nav-icon fa-solid fa-right-from-bracket"></i>
              <p>Salir</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>