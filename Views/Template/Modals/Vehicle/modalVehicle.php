<!-- Modal -->
<div class="modal fade" id="modalFormVehicle" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal"><i class="fa-solid fa-car"></i> Nuevo Empleado</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formVehicle" name="formVehicle" class="form-horizontal" autocomplete="off" >
              <input type="hidden" id="idVehicle" name="idVehicle" value="">
              <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
            <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="txtMark">Marca: <span class="required">*</span></label>
                  <input type="text" class="form-control" id="txtMark" name="txtMark" placeholder="Escriba aqui..." required="" autocomplete="new-password" />
                </div>
                <div class="form-group col-md-6">
                  <label for="txtModel">Modelo: <span class="required">*</span></label>
                  <input type="text" class="form-control" id="txtModel" name="txtModel" placeholder="Escriba aqui..." required="" autocomplete="new-password" />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="txtColor">Color: <span class="required">*</span></label>
                  <input type="text" class="form-control" id="txtColor" name="txtColor" placeholder="Escriba aqui..." required="" autocomplete="new-password" />
                </div>
                <div class="form-group col-md-6">
                  <label for="txtYear">Año: <span class="required">*</span></label>
                  <input type="text" class="form-control" id="txtYear" name="txtYear" placeholder="Escriba aqui..." required="" autocomplete="new-password" />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="txtPlate">Placa: <span class="required">*</span></label>
                  <input type="text" class="form-control" id="txtPlate" name="txtPlate" placeholder="Escriba aqui..." required="" autocomplete="new-password" />
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