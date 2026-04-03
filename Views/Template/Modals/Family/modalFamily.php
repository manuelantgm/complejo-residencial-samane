<!-- Modal -->
<div class="modal fade" id="modalFormFamily" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal"><i class="ion ion-person-add"></i> Nuevo Cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="formFamily" name="formFamily" class="form-horizontal" autocomplete="off">
              <input type="hidden" id="idFamily" name="idFamily" value="">
              <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>

              <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="listAge">Mayor de edad <span class="required">*</span></label>
                    <select class="form-control" data-live-search="true" id="listAge" name="listAge" required >
                      <option value="0">--Seleccione--</option>
                      <option value="1">Si</option>
                      <option value="2">No</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="txtIdentification">Identificacion</label>
                  <input type="text" 
                         class="form-control" 
                         id="txtIdentification" 
                         name="txtIdentification" 
                         placeholder="___-_______-_" 
                         data-inputmask="'mask': '999-9999999-9'" 
                         data-mask 
                         autocomplete="new-password" />
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="txtName">Nombres <span class="required">*</span></label>
                  <input type="text" class="form-control" id="txtName" name="txtName" placeholder="Escriba aqui..." required="" autocomplete="new-password" />
                </div>
                <div class="form-group col-md-6">
                  <label for="txtLastName">Apellidos <span class="required">*</span></label>
                  <input type="text" class="form-control" id="txtLastName" name="txtLastName" placeholder="Escriba aqui..." required="" autocomplete="new-password" />
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="txtRelationship">Parentezco <span class="required">*</span></label>
                  <input type="text" 
                         class="form-control" 
                         id="txtRelationship" 
                         name="txtRelationship" 
                         placeholder="Escriba aqui..." required />
                </div>
                <div class="form-group col-md-6">
                  <label for="intPhone">Teléfono</label>
                  <input type="text" data-inputmask='"mask": "1+ (999) 999-9999"' data-mask class="form-control" class="form-control valid validNumber" id="intPhone" name="intPhone" onkeypress="return controlTag(event);" placeholder="1+ (___) ___-____" autocomplete="off">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="listStreetId">Direccion / Calle <span class="required">*</span></label>
                    <select class="form-control" data-live-search="true" id="listStreetId" name="listStreetId" required></select>
                </div>
                <div class="form-group col-md-6">
                    <label for="intNumber">Numero / Vivivenda <span class="required">*</span></label>
                    <input type="number" class="form-control" id="intNumber" name="intNumber" placeholder="#" required />
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="txtEmail">Email</label>
                  <input type="email" class="form-control valid validEmail" id="txtEmail" name="txtEmail" placeholder="test@mail.com" autocomplete="new-password" />
                </div>
                <div class="form-group col-md-6">
                  <label for="txtPassword">Password </label>
                  <input type="password" class="form-control" id="txtPassword" name="txtPassword" placeholder="******" autocomplete="new-password" />
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