<!-- Modal -->
<div class="modal fade" id="modalFormVisit" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal"><i class="ion ion-person-add"></i> Nuevo Empleado</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formVisit" name="formVisit" class="form-horizontal" autocomplete="off" >
              <input type="hidden" id="idVisit" name="idVisit" value="">
              <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>

            <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="txtIdentification">Número de cédula si aplica:</label>
                  <input type="text" 
                         class="form-control" 
                         id="txtIdentification" 
                         name="txtIdentification" 
                         placeholder="___-_______-_" 
                         data-inputmask="'mask': '999-9999999-9'" 
                         data-mask 
                         autocomplete="new-password" />
                </div>
                <div class="form-group col-md-6">
                  <label for="txtPassport">Número de pasaporte si aplica:</label>
                  <input type="text" 
                        class="form-control" 
                        id="txtPassport" 
                        name="txtPassport" 
                        placeholder="Número de pasaporte" 
                        autocomplete="new-password" />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="txtName">Nombres: <span class="required">*</span></label>
                  <input type="text" class="form-control" id="txtName" name="txtName" placeholder="Escriba aqui..." required="" autocomplete="new-password" />
                </div>
                <div class="form-group col-md-6">
                  <label for="txtLastName">Apellidos: <span class="required">*</span></label>
                  <input type="text" class="form-control" id="txtLastName" name="txtLastName" placeholder="Escriba aqui..." required="" autocomplete="new-password" />
                </div>
            </div>
            <div class="tile-footer">
              <button id="btnActionForm" class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
              <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>