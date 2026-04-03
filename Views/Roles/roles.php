<?php 
    headerAdmin($data); 
    getModal('modalRoles',$data);
?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <div id="contentAjax"></div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1><i class="fa-solid fa-user-tag"></i> <strong><?= strtoupper($data['page_title']); ?></strong></h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item">
                    <button type="button" onclick="openModal();" class="btn btn-block btn-success btn-sm"><i class="fa-solid fa-tags"></i> <strong>NUEVO ROL</strong></button>
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
                    <h3 class="card-title"><i class="fa-solid fa-user-tag"></i> ROLES DE USUARIOS</h3>

                    <div class="card-tools">
                      
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-hover" id="tableRoles">
                        <thead class="bg-thead">
                          <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
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
    