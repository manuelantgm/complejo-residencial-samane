<?php 
  headerAdmin($data); 
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"><div class="container-toast" id="list-toast"></div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"> Panel De Control <small><?= SIGLAS;?></small></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url(); ?>/crs/inicio">Inicio</a></li>
              <li class="breadcrumb-item"><a href="<?= base_url(); ?>/crs/inicio">c-Panel</a></li>
              <li class="breadcrumb-item active"><?= SIGLAS; ?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <h5 class="mb-2">Personas</h5>
        <div class="row">
          <div class="col-md-3 col-sm-6 col-12">
            <a href="<?= base_url(); ?>/crs/inicio" style="color:inherit;">
            <div class="info-box">
              <span class="info-box-icon bg-info"><i class="fa-solid fa-people-group"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">(<?= $data['persons'] ?>) Personas</span>
                <span class="info-box-number"><?= $data['persons'] ?> <i class="pl-2 fa fa-question-circle tip text-right" data-toggle="tooltip" data-placement="top" title="Total de personas asociadas."></i> </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            </a>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <a href="<?= base_url(); ?>/crs/familias" style="color:inherit;">
              <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fa-solid fa-people-roof"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">(<?= $data['families'] ?>) Familiares</span>
                  <span class="info-box-number"><?= $data['families'] ?> <i class="pl-2 fa fa-question-circle tip text-right" data-toggle="tooltip" data-placement="top" title="Familiares que viven dentro del complejo."></i></span>
                </div>
                <!-- /.info-box-content -->
              </div>
            </a>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <a href="<?= base_url(); ?>/crs/empleados" style="color:inherit;">
              <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fa-solid fa-people-carry-box"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">(<?= $data['employees'] ?>) Empleados</span>
                  <span class="info-box-number"><?= $data['employees'] ?> <i class="pl-2 fa fa-question-circle tip text-right" data-toggle="tooltip" data-placement="top" title="Empleados asociados al usuario principal o a la familia."></i></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </a>
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <a href="<?= base_url(); ?>/crs/visitas-frecuentes" style="color:inherit;">
              <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fa-regular fa-handshake"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">(<?= $data['visits'] ?>) Visitas Frecuentes</span>
                  <span class="info-box-number"><?= $data['visits'] ?> <i class="pl-2 fa fa-question-circle tip text-right" data-toggle="tooltip" data-placement="top" title="Visitas frecuentes."></i></span>
                </div>
                <!-- /.info-box-content -->
              </div>
            </a>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <h5 class="mb-2">Vehiculos</h5>
        <div class="row">
          <div class="col-md-3 col-sm-6 col-12">
            <a href="<?= base_url(); ?>/crs/vehiculos" style="color:inherit;">
              <div class="info-box">
                <span class="info-box-icon bg-olive disabled color-palette"><i class="fa fa-road"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">(<?= $data['vehicles'] ?>) Vehiculos</span>
                  <span class="info-box-number"><?= $data['vehicles'] ?> <i class="fa-solid fa-car"></i></span>
                </div>
                <!-- /.info-box-content -->
              </div>
            </a>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->  
<?php footerAdmin($data); ?>
    