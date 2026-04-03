<?php 
    headerAdmin($data); 
    getModal('modalUsuarios',$data);
?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1><i class="fa-solid fa-users"></i> <strong><?= strtoupper($data['page_title']); ?></strong></h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item">
                    <button type="button" onclick="openModal();" class="btn btn-block btn-success btn-sm"><i class="fa-solid fa-user-plus"></i> <strong>NUEVO USUARIO</strong></button>
                  </li>
                </ol>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <!-- Default box -->
                <div class="card card-info card-outline">
                  <div class="card-header">
                    <h3 class="card-title"><i class="fa-solid fa-users"></i> USUARIOS</h3>

                    <div class="card-tools">
                      
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-hover" id="tableUsuarios">
                        <thead class="bg-thead">
                          <tr>
                            <th>ID</th>
                            <th>Nombres</th>
                            <th>Email</th>
                            <th>Tel&eacute;fono</th>
                            <th>Rol</th>
                            <th>Status</th>
                            <th class="text-center">Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
            </div>
          </div>
        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
<?php footerAdmin($data); ?>
    