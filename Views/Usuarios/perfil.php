<?php 
    headerAdmin($data); 
?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <div id="contentAjax"></div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1><i class="fa-solid fa-id-badge"></i> <strong><?= strtoupper($data['page_title']); ?></strong></h1>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-3">

                <!-- Profile Image -->
                <div class="card card-info card-outline">
                  <div class="card-body box-profile">
                    <div class="text-center">
                      <img class="profile-user-img img-fluid img-circle"
                           src="<?= media(); ?>/img/uploads/<?= $_SESSION['userData']['image']; ?>"
                           alt="User profile picture">
                    </div>
                    <h3 class="profile-username text-center"><?= $_SESSION['userData']['nombres']; ?></h3>

                    <p class="text-muted text-center"><?= $_SESSION['userData']['nombrerol']; ?></p>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
              <!-- /.col -->
              <div class="col-md-9">
                <div class="card card-info card-outline">
                  <div class="card-header p-0">
                    <ul class="nav nav-pills config">
                      <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab"><i class="fa-solid fa-user-pen"></i> DATOS PERSONALES</a></li>
                      <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab"><i class="fa-solid fa-camera-retro"></i> Imagen</a></li>
                    </ul>
                  </div><!-- /.card-header -->
                  <div class="card-body">
                    <div class="tab-content">
                      <div class="active tab-pane" id="activity">
                        <form id="formPerfil" name="formPerfil" class="form-horizontal">
                          <div class="form-group row">
                            <label for="txtNombre" class="col-sm-2 col-form-label">Nombres</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" id="txtNombre" name="txtNombre" value="<?= $_SESSION['userData']['nombres']; ?>" placeholder="Nombre">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="txtApellidos" class="col-sm-2 col-form-label">Apellidos</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" id="txtApellidos" name="txtApellidos" value="<?= $_SESSION['userData']['apellidos']; ?>" placeholder="Nombre">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="txtTelefono" class="col-sm-2 col-form-label">Telefono</label>
                            <div class="col-sm-10">
                              <input type="text" data-inputmask='"mask": "1+ (999) 999-9999"' data-mask class="form-control" id="txtTelefono" name="txtTelefono" value="<?= $_SESSION['userData']['telefono']; ?>" placeholder="Telefono">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="txtEmail" class="col-sm-2 col-form-label">Correo electronico</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" id="txtEmail" name="txtEmail" value="<?= $_SESSION['userData']['email_user']; ?>" placeholder="Correo electronico">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="txtPassword" class="col-sm-2 col-form-label">Contraseña</label>
                            <div class="col-sm-10">
                              <input type="password" class="form-control" id="txtPassword" name="txtPassword" placeholder="***">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="txtPasswordConfirm" class="col-sm-2 col-form-label">Confirmar Contraseña</label>
                            <div class="col-sm-10">
                              <input type="password" class="form-control" id="txtPasswordConfirm" name="txtPasswordConfirm" placeholder="***">
                            </div>
                          </div>

                          <div class="form-group row">
                            <div class="offset-sm-2 col-sm-10">
                              <button id="btnActionForm" class="btn btn-info" type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
                            </div>
                          </div>
                        </form>
                      </div>
                      <!-- /.tab-pane -->

                      <div class="tab-pane" id="settings">
                        <form id="formImage" name="formImage" class="form-horizontal">
                          <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">
                              Vista previa<br>
                              <img class="preview_img" src="<?= media(); ?>/img/uploads/<?= $_SESSION['userData']['image']; ?>">
                            </label>
                            
                            <div class="col-sm-10">
                              <div class="file-upload text-secondary">
                                <input type="file" class="image" name="image" accept="image/*">
                                <input type="hidden" name="image_old" id="image_old" value="<?= $_SESSION['userData']['image']; ?>">
                                <span class="fs-4 fw-2">Elija el archivo...</span>
                                <span>o arrastre y suelte el archivo aquí</span>
                              </div>
                            </div>
                          </div>
                        
                          <div class="form-group row">
                            <div class="offset-sm-2 col-sm-10">
                              <button type="submit" class="btn btn-success"><i class="fa-regular fa-floppy-disk"></i> Guardar</button>
                            </div>
                          </div>
                        </form>
                      </div>
                      <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                  </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
<?php footerAdmin($data); ?>