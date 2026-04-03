<?php 
    headerAdmin($data); 
    $config = $data['config'];
?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <div id="contentAjax"></div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1><i class="fa-solid fa-gear"></i> <strong><?= strtoupper($data['page_title']); ?></strong></h1>
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
                           src="<?= media();?>/img/logo.jpeg"
                           alt="User profile picture">
                    </div>

                    <h3 class="profile-username text-center"><?= $config['nombre_comercial']; ?></h3>

                    <p class="text-muted text-center"><?= $config['direccion']; ?></p>

                    <ul class="list-group list-group-unbordered mb-3">
                      <li class="list-group-item">
                        <b>Rnc:</b> <a class="float-right"><?= $config['rnc']; ?></a>
                      </li>
                      <li class="list-group-item">
                        <b>Telefono</b> <a class="float-right"><?= $config['telefono']; ?></a>
                      </li>
                    </ul>
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
                      <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab"><i class="fa-solid fa-building"></i> Perfil</a></li>
                      <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab"><i class="fa-solid fa-camera-retro"></i> Logo</a></li>
                    </ul>
                  </div><!-- /.card-header -->
                  <div class="card-body">
                    <div class="tab-content">
                      <div class="active tab-pane" id="activity">
                        <form id="formConfiguration" name="formConfiguration" class="form-horizontal">
                          <div class="form-group row">
                            <label for="txtNomEmp" class="col-sm-2 col-form-label">Nombre comercial</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" id="txtNomEmp" name="txtNomEmp" value="<?= $config['nombre_comercial']; ?>" placeholder="Nombre comercial...">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="txtDireccion" class="col-sm-2 col-form-label">Direccion</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" id="txtDireccion" name="txtDireccion" value="<?= $config['direccion']; ?>" placeholder="Direccion">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="txtTel" class="col-sm-2 col-form-label">Telefono</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" id="txtTel" name="txtTel" value="<?= $config['telefono']; ?>" placeholder="Telefono">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="txtDescripcion" class="col-sm-2 col-form-label">Descripcion</label>
                            <div class="col-sm-10">
                              <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" placeholder="Descripcion"><?= $config['descripcion']; ?></textarea>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="txtEmail" class="col-sm-2 col-form-label">Correo electronico</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" id="txtEmail" name="txtEmail" value="<?= $config['email']; ?>" placeholder="Correo electronico">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="txtRnc" class="col-sm-2 col-form-label">RNC o Cédula</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" id="txtRnc" name="txtRnc" value="<?= $config['rnc']; ?>" placeholder="Rnc">
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="txtBanco" class="col-sm-2 col-form-label">Banco</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" id="txtBanco" name="txtBanco" value="<?= $config['banco']; ?>" placeholder="Banco...">
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="tipoDeCuenta" class="col-sm-2 col-form-label">Tipo de cuenta</label>
                            <div class="col-sm-10">
                              <select class="form-control" id="tipoDeCuenta" name="tipoDeCuenta" >
                                <option value="0">--Seleccione--</option>
                                <option value="1" <?php if($config['tipo_cuenta'] == 1){echo "selected";} ?>>Cuenta corriente</option>
                                <option value="2" <?php if($config['tipo_cuenta'] == 2){echo "selected";} ?>>Cuenta de ahorro</option>
                              </select>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="txtNumCuenta" class="col-sm-2 col-form-label">N&uacute;mero de cuenta</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" id="txtNumCuenta" name="txtNumCuenta" value="<?= $config['numero_cuenta']; ?>" placeholder="N&uacute;mero de la cuenta...">
                            </div>
                          </div>

                          <div class="form-group row">
                            <div class="offset-sm-2 col-sm-10">
                              <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
                            </div>
                          </div>
                        </form>
                      </div>
                      <!-- /.tab-pane -->

                      <div class="tab-pane" id="settings">
                        <form class="form-horizontal">

                          <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">
                              Vista previa<br>
                              <img class="preview_img" src="<?= media();?>/img/logo.jpeg">
                            </label>
                            
                            <div class="col-sm-10">
                              <div class="file-upload text-secondary">
                                <input type="file" class="image" name="image" accept="image/*">
                                <input type="hidden" name="image_old" id="image_old">
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
    