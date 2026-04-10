<?php 
    headerAdmin($data); 
    getModal('Visit/modalVisit',$data);
?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="container">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1><i class="fa-regular fa-handshake"></i> <strong><?= strtoupper($data['page_title']); ?></strong></h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item">
                    
                  </li>
                </ol>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="container">
            <div class="row">
              <div class="col-12">
                <!-- Default box -->
                <div class="card card-info card-outline">
                  <div class="card-header">
                    <h3 class="card-title"><i class="fa-regular fa-handshake"></i> Listando Visitas</h3>

                    <div class="card-tools">
                      <?php if($_SESSION['permisosMod']['w']){ ?>
                        <button type="button" onclick="openModal();" class="btn btn-block btn-success btn-sm"><i class='fa-regular fa-handshake'></i> <strong>Agregar visita</strong></button>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="card-body table-responsive">
                    <table class="table table-hover text-nowrap" id="tableVisits">
                      <thead class="bg-thead">
                        <tr>
                          <th>Acciones</th>
                          <th>Nombres</th>
                          <th>Apellidos</th>
                          <th>Identificación</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
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
    