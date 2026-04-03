<!-- Modal -->
<div class="modal fade" id="modalFormUsuario" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">NUEVO USUARIO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><i class="fa-solid fa-circle-xmark"></i></span>
        </button>
      </div>
      <div class="modal-body">
            <div class="tile-body">
              <form id="formUsuario" name="formUsuario" class="form-orizontal">
                <input type="hidden" id="idUsuario" name="idUsuario" value="">

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <div class="form__field">
                      <label class="form__label" for="txtIdentificacion">Identificacion</label>
                      <input type="text" 
                             data-inputmask="'mask': '999-9999999-9'"
                             data-mask="" 
                             class="form__input" 
                             id="txtIdentificacion" 
                             name="txtIdentificacion" 
                             placeholder="___-_______-_" />
                      <i class="fa-solid fa-address-card form__icon"></i>
                    </div>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <div class="form__field">
                      <label class="form__label" for="txtNombre">Nombre</label>
                      <input type="text" class="form__input" id="txtNombre" name="txtNombre" placeholder="Nombres del usuario" required="">
                      <i class="fa-solid fa-user-plus form__icon"></i>
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <div class="form__field">
                      <label class="form__label" for="txtApellido">Apellidos</label>
                      <input type="text" class="form__input" id="txtApellido" name="txtApellido" placeholder="Apellidos del usuario" required="">
                      <i class="fa-solid fa-user-plus form__icon"></i>
                    </div>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <div class="form__field">
                      <label class="form__label" for="txtTelefono">Tel&eacute;fono</label>
                      <input type="text" data-inputmask='"mask": "1+ (999) 999-9999"' data-mask class="form-control form__input" id="txtTelefono" name="txtTelefono" placeholder="Tel&eacute;fono" required="">
                      <i class="fa-solid fa-phone form__icon"></i>
                    </div>
                  </div>


                  <div class="form-group col-md-6">
                    <div class="form__field">
                      <label class="form__label" for="txtEmail">Email</label>
                      <input type="text" class="form__input" id="txtEmail" name="txtEmail" placeholder="Email..." required="">
                      <i class="fa-solid fa-envelope form__icon"></i>
                    </div>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <div class="form__field">
                      <label class="form__label" for="listRolid">Tipo de usuario</label>
                      <select class="form-control form__input" data-live-search="true" id="listRolid" name="listRolid" required ></select>
                      <i class="fa-solid fa-user-tag form__icon"></i>
                    </div>
                  </div>

                  <div class="form-group col-md-6">
                    <div class="form__field">
                      <label class="form__label" for="listStatus">Estado</label>
                      <select class="form-control selectpicker form__input" id="listStatus" name="listStatus" required="">
                        <option value="1">Activo</option>
                        <option value="2">Inactivo</option>
                      </select>
                      <i class="fa-solid fa-user-tag form__icon"></i>
                    </div>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <div class="form__field">
                      <label class="form__label" for="txtPassword">Contraseña</label>
                      <input type="password" class="form__input" id="txtPassword" name="txtPassword" placeholder="Contraseña..." >
                      <i class="fa-solid fa-lock form__icon"></i>
                    </div>
                  </div>
                </div>
                
                <div class="tile-footer">
                  <button id="btnActionForm" class="btn bg-gradient-success" type="submit"><i class="fa-solid fa-floppy-disk"></i> <span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;<a class="btn bg-gradient-secondary" href="#" data-dismiss="modal" ><i class="fa fa-fw fa-lg fa-times-circle"></i> Cancelar</a>
                </div>
              </form>
            </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalViewUser" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos del usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td>Identificación:</td>
              <td id="celIdentificacion">654654654</td>
            </tr>
            <tr>
              <td>Nombres:</td>
              <td id="celNombre">Jacob</td>
            </tr>
            <tr>
              <td>Apellidos:</td>
              <td id="celApellido">Jacob</td>
            </tr>
            <tr>
              <td>Teléfono:</td>
              <td id="celTelefono">Larry</td>
            </tr>
            <tr>
              <td>Email (Usuario):</td>
              <td id="celEmail">Larry</td>
            </tr>
            <tr>
              <td>Tipo Usuario:</td>
              <td id="celTipoUsuario">Larry</td>
            </tr>
            <tr>
              <td>Estado:</td>
              <td id="celEstado">Larry</td>
            </tr>
            <tr>
              <td>Fecha registro:</td>
              <td id="celFechaRegistro">Larry</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>