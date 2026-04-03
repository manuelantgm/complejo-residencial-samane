          <script>
              const base_url = "<?= base_url(); ?>";
              const smony = "<?= SMONEY; ?>";
          </script>
          <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
              <b>GomezSys IBP</b> 3.2
            </div>
            <strong>&copy; <?= date('Y'); ?> <?= SIGLAS; ?> Powered by <a href="https://gomezsys.net">GomezSys</a></strong>
          </footer>

          <!-- Control Sidebar -->
          <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
          </aside>
          <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->

        <!-- jQuery -->
        <script src="<?= media(); ?>/plugins/jquery/jquery.min.js"></script>
        <!-- datepicker -->
        <script src='<?= media(); ?>/plugins//bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js'></script>
        <!-- Bootstrap 4 -->
        <script src="<?= media(); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- Select2 -->
        <script src="<?= media(); ?>/plugins/select2/js/select2.full.min.js"></script>
        <!-- Tinymce -->
        <script type="text/javascript" src="<?= media(); ?>/plugins/tinymce/tinymce.min.js"></script>
        <!-- SweetAlert2 -->
        <script src="<?= media(); ?>/plugins/sweetalert2/sweetalert2.min.js"></script>
        <!-- Toastr -->
        <script src="<?= media(); ?>/plugins/toastr/toastr.min.js"></script>
        <script src="<?= media(); ?>/plugins/toastr/gsToast.js"></script>
        <!-- DataTables  & Plugins -->
        <script src="<?= media(); ?>/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="<?= media(); ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="<?= media(); ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
        <script src="<?= media(); ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
        <script src="<?= media(); ?>/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
        <script src="<?= media(); ?>/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
        <script src="<?= media(); ?>/plugins/jszip/jszip.min.js"></script>
        <script src="<?= media(); ?>/plugins/pdfmake/pdfmake.min.js"></script>
        <script src="<?= media(); ?>/plugins/pdfmake/vfs_fonts.js"></script>
        <script src="<?= media(); ?>/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
        <script src="<?= media(); ?>/plugins/datatables-buttons/js/buttons.print.min.js"></script>
        <script src="<?= media(); ?>/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
        <!-- Bootstrap Switch -->
        <script src="<?= media(); ?>/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
        <!-- bs-custom-file-input -->
        <script src="<?= media(); ?>/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
        <!-- InputMask -->
        <script src="<?= media(); ?>/plugins/moment/moment.min.js"></script>
        <script src="<?= media(); ?>/plugins/inputmask/jquery.inputmask.min.js"></script>
        <!-- jqueryNumber -->
        <script src="<?= media(); ?>/plugins/jqueryNumber/jquery.number.js"></script>
        <!-- Select -->
        <script src="<?= media(); ?>/plugins/select/bootstrap-select.min.js"></script>
        <!-- Summernote -->
        <script src="<?= media(); ?>/plugins/summernote/summernote-bs4.min.js"></script>
        <!-- Tempusdominus Bootstrap 4 -->
        <script src="<?= media(); ?>/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
        <!-- AdminLTE App -->
        <script src="<?= media(); ?>/dist/js/adminlte.min.js"></script>
        <script type="text/javascript" src="<?= media();?>/fnts/fnts_admin.js"></script>
        <?php
          function asset_version($fileName, $subDir = "fnts") {
              $filePath = __DIR__ . "/../../Assets/" . $subDir . "/" . $fileName;
              $version = file_exists($filePath) ? filemtime($filePath) : time();
              return media() . "/" . $subDir . "/" . $fileName . "?v=" . $version;
          }
        ?>
        <script src="<?= asset_version($data['page_functions_js']); ?>"></script>
    </body>
</html>