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
                      <label class="form__label" for="intLocationid">Urbanización:</label>
                      <select class="form-control form__input" data-live-search="true" id="intLocationid" name="intLocationid" required >
                        <option value="0">--Seleccione--</option>
                        <option value="1">Los Samanes</option>
                        <option value="2">Samanes Residences</option>
                        <option value="3">Altos de los Samanes</option>
                      </select>
                      <i class="fa-solid fa-map form__icon"></i>
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <div class="form__field">
                      <label class="form__label" for="nomenclaturaid">Nomenclatura:</label>
                      <select class="form-control form__input" data-live-search="true" id="nomenclaturaid" name="nomenclaturaid" required >
                        <option value="0">--Seleccione--</option>
                        <option value="1">Solar</option>
                        <option value="2">Construcción</option>
                        <option value="3">Vivienda propia</option>
                        <option value="4">Vivienda alquilada</option>
                      </select>
                      <i class="fa-solid fa-clipboard-list form__icon"></i>
                    </div>
                  </div>
                  
                </div>

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
                  <div class="form-group col-md-6">
                    <div class="form__field">
                      <label class="form__label" for="txtPassport">Número de pasaporte si aplica:</label>
                      <input type="text"
                             class="form__input" 
                             id="txtPassport" 
                             name="txtPassport" 
                             placeholder="Escribe aqui..." />
                      <i class="fa-solid fa-address-card form__icon"></i>
                    </div>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <div class="form__field">
                      <label class="form__label" for="txtNombres">Nombre</label>
                      <input type="text" class="form__input" id="txtNombres" name="txtNombres" placeholder="Nombres del usuario" required="">
                      <i class="fa-solid fa-user-plus form__icon"></i>
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <div class="form__field">
                      <label class="form__label" for="txtApellidos">Apellidos</label>
                      <input type="text" class="form__input" id="txtApellidos" name="txtApellidos" placeholder="Apellidos del usuario" required="">
                      <i class="fa-solid fa-user-plus form__icon"></i>
                    </div>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <div class="form__field">
                      <label class="form__label" for="street_id">Calle:</label>
                      <select class="form-control form__input" data-live-search="true" id="street_id" name="street_id" required>
                        <option value="0">--Seleccione--</option>
                      </select>
                      <i class="fa-solid fa-road form__icon"></i>
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <div class="form__field">
                      <label class="form__label" for="homeNumber">Número de casa:</label>
                      <input type="number" class="form__input" id="homeNumber" name="homeNumber" placeholder="0" required="">
                      <i class="fa-solid fa-hashtag form__icon"></i>
                    </div>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <div class="form__field">
                      <label class="form__label" for="txtCel">Celular:</label>
                      <input type="text" data-inputmask='"mask": "1+ (999) 999-9999"' data-mask class="form-control form__input" id="txtCel" name="txtCel" placeholder="Tel&eacute;fono" required="">
                      <i class="fa-solid fa-mobile-button form__icon"></i>
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <div class="form__field">
                      <label class="form__label" for="txtPhone">Teléfono casa:</label>
                      <input type="text" data-inputmask='"mask": "1+ (999) 999-9999"' data-mask class="form-control form__input" id="txtPhone" name="txtPhone" placeholder="Tel&eacute;fono" required="">
                      <i class="fa-solid fa-tty form__icon"></i>
                    </div>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <div class="form__field">
                      <label class="form__label" for="txtEmail">Email</label>
                      <input type="text" class="form__input" id="txtEmail" name="txtEmail" placeholder="Email..." required="" autocomplete="new-password">
                      <i class="fa-solid fa-envelope form__icon"></i>
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <div class="form__field">
                      <label class="form__label" for="txtPassword">Contraseña</label>
                      <input type="password" class="form__input" id="txtPassword" name="txtPassword" placeholder="Contraseña..."  autocomplete="new-password">
                      <i class="fa-solid fa-lock form__icon"></i>
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
                      <i class="fa-solid fa-tag form__icon"></i>
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