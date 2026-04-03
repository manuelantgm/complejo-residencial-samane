<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="<?= media();?>/img/icon.png" type="image/x-icon">
  <title><?= $data['page_tag'];?></title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= media(); ?>/plugins/fontawesome-6.5.1/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="<?= media(); ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?= media(); ?>/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?= media(); ?>/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= media(); ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= media(); ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= media(); ?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Select -->
  <link rel="stylesheet" href="<?= media(); ?>/dist/css/select/bootstrap-select.min.css">
  <link rel='stylesheet' href='<?= media(); ?>/plugins//bootstrap-datepicker/1.3.0/css/datepicker.css'><link rel="stylesheet" href="./style.css">
  
  <!-- Select2 -->
  <link rel="stylesheet" href="<?= media(); ?>/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= media(); ?>/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="<?= media(); ?>/dist/css/adminlte.min.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?= media(); ?>/plugins/summernote/summernote-bs4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?= media(); ?>/plugins/toastr/toastr.min.css">
  <!-- Style -->
  <link rel="stylesheet" href="<?= media(); ?>/dist/css/style.css">
</head>
<body class="hold-transition sidebar-mini sidebar-collapse">
<!-- Site wrapper -->
<div class="wrapper">
  <div id="divLoading" >
    <div>
      <img src="<?= media(); ?>/img/loading.svg" alt="Loading">
    </div>
  </div>
  <div class="container-toast" id="list-toast"></div>
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?= base_url(); ?>/crs/inicio" class="nav-link">Inicio</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- User Dropdown Menu -->
      <?php 
        $names = $_SESSION['userData']['nombres'] ?? '';
        $lastnames = $_SESSION['userData']['apellidos'] ?? '';

        $firstNamne = preg_split('/\s+/', trim($names))[0] ?? '';
        $firstSurname = preg_split('/\s+/', trim($lastnames))[0] ?? '';

        $nameShow = trim($firstNamne . ' ' . $firstSurname);
      ?>
      <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
          <span class="hidden-xs">Bienvenido(a) <strong style="color:#17a2b8;"><?= $nameShow; ?></strong> </span>
          <img src="<?= media(); ?>/img/uploads/<?= $_SESSION['userData']['image']; ?>" class="user-image" alt="User Image">
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

          <!-- User image -->
          <li class="user-header">
            <img src="<?= media(); ?>/img/uploads/<?= $_SESSION['userData']['image']; ?>" class="img-circle" alt="User Image">
            <p>
              <?= $nameShow; ?> 
              <small><?= $_SESSION['userData']['nombrerol']; ?></small>
            </p>
          </li>
         
          <!-- Menu Footer-->
          <li class="user-footer bg-info">
            <div class="pull-left">
              
            </div>
            <div class="pull-right">
              <a href="<?= base_url(); ?>/logout" class="btn btn-info"><i class="fa-solid fa-right-from-bracket"></i> Salir</a>
              <a href="<?= base_url(); ?>/usuarios/perfil" class="btn btn-info"><i class="fa-solid fa-user"></i> Perfil de usuario</a>
            </div>
          </li>
        </ul>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
    <?php require_once("nav_admin.php"); ?>