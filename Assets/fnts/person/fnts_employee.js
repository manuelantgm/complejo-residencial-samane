let tableEmployees; 
let rowTable = "";
let divLoading = document.querySelector("#divLoading");

document.addEventListener('DOMContentLoaded', function(){

    if (document.querySelector("#tableEmployees")) {
        tableEmployees = $('#tableEmployees').DataTable({
            ordering:false,
            "aProcessing":true,
            "aServerSide":true,
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            },
            "ajax":{
                "url": base_url + "/Employees/getEmployees",
                "dataSrc":""
            },
            "columns":[
                {
                    "data": null,
                    "render": function(data, type, row){
                        let btnView   = row.canView   ? `<button class="btn" onClick="fntViewInfo(${row.id_employee})"><i class="far fa-eye"></i> Mas detalles</button>` : "";
                        let btnEdit   = row.canEdit   ? `<button class="btn" onClick="fntEditInfo(this,${row.id_employee})"><i class="fa-solid fa-pen-to-square"></i> Editar</button>` : "";
                        let btnDelete = row.canDelete ? `<button class="btn" onClick="fntDelInfo(${row.id_employee})"><i class="far fa-trash-alt"></i> Eliminar</button>` : "";

                        return `
                            <div class="btn-group pull-right">
                                <button type="button" class="btn btn-sm dropdown-toggle bg-info" data-toggle="dropdown">
                                    <i class="fa-solid fa-gear"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>${btnView}</li>
                                    <li>${btnEdit}</li>
                                    <li>${btnDelete}</li>
                                </ul>
                            </div>`;
                    }
                },
                {"data":"names"},
                {"data":"last_names"},
                {"data":"ocupation"},
                {
                    "data":"status",
                    "render": function(data){
                        let badgeClass = data === "Activo" ? "badge-success" : "badge-danger";
                        return `<span class="badge ${badgeClass}">${data}</span>`;
                    }
                }
            ],
            "responsive": false,
            "bDestroy": true,
            "iDisplayLength": 10,
            "order":[[0,"desc"]]  
        });

    }

    if(document.querySelector("#formEmployee")){
        let formEmployee = document.querySelector("#formEmployee");
        formEmployee.onsubmit = function(e) {
            e.preventDefault();
            let intIdentification = document.querySelector('#txtIdentification').value;
            let strPassport= document.querySelector('#txtPassport').value;
            let strName = document.querySelector('#txtName').value;
            let strLastName = document.querySelector('#txtLastName').value;
            let intTypeContract = document.querySelector('#intEmpType').value;
            let selectOcupation = document.querySelector('#intOcupation');
            let intOcupation = selectOcupation.value;
            let strOcupation = selectOcupation.options[selectOcupation.selectedIndex].text;

            // VALIDATIONS
            if(strName.trim() == ''){
                Swal.fire({
                  title: "Atención!",
                  text: "Debe ingresar el nombre, Los campos con asterisco * son requeridos.",
                  icon: "info"
                });
                return false;
            }

            if(strLastName.trim() == ''){
                Swal.fire({
                  title: "Atención!",
                  text: "Debe ingresar el apellido, Los campos con asterisco * son requeridos.",
                  icon: "info"
                });
                return false;
            }

            if(intIdentification === '' && strPassport === ''){
                Swal.fire({
                    title: "Atención!",
                    text: "Debe ingresar una cédula o un pasaporte.",
                    icon: "info"
                });
                return false;
            }

            if(intTypeContract == "0"){
                Swal.fire({
                    title: "Atención!",
                    text: "Debe seleccionar el tipo de empleado.",
                    icon: "info"
                });
                return false;
            }

            if(intOcupation == "0"){
                Swal.fire({
                    title: "Atención!",
                    text: "Debe seleccionar la ocupación.",
                    icon: "info"
                });
                return false;
            }

            let elementsValid = document.getElementsByClassName("valid");
            for (let i = 0; i < elementsValid.length; i++) { 
                if(elementsValid[i].classList.contains('is-invalid')) { 
                    Swal.fire({
                      title: "Atención!",
                      text: "Por favor verifique los campos en rojo.",
                      icon: "info"
                    });
                    return false;
                } 
            } 

            divLoading.style.display = "flex";

            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Employees/upsertEmployee'; 
            let formData = new FormData(formEmployee);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        if(rowTable == ""){
                            tableEmployees.ajax.reload();
                        }else{
                            rowTable.cells[1].textContent = strName;
                            rowTable.cells[2].textContent = strLastName;
                            rowTable.cells[3].textContent = strOcupation;
                            rowTable = ""; 
                        }
                        $('#modalFormEmployee').modal("hide");
                        formEmployee.reset();
                        Swal.fire({
                          title: "BUEN TRABAJO!",
                          text: objData.msg,
                          icon: "success"
                        });
                    }else{
                        Swal.fire({
                          title: "ERROR",
                          text: objData.msg,
                          icon: "error"
                        });
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
        }
    }
}, false);

window.addEventListener('load', function() {
    fntOcupations();
    fntDays();
}, false);

function fntViewInfo(idemployee){
    let request = (window.XMLHttpRequest) 
        ? new XMLHttpRequest() 
        : new ActiveXObject('Microsoft.XMLHTTP');

    let ajaxUrl = base_url + '/Employees/getEmployee/' + idemployee;
    request.open("GET", ajaxUrl, true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4){
            if(request.status == 200){
                let objData = JSON.parse(request.responseText);

                if(objData.status){
                    let employee = objData.data.employee;
                    let workdays = objData.data.workdays;

                    document.querySelector("#celIdentification").innerHTML = employee.identification ?? '';
                    document.querySelector("#celPassport").innerHTML = employee.passport ?? '';
                    document.querySelector("#celNames").innerHTML = employee.names ?? '';
                    document.querySelector("#celLastNames").innerHTML = employee.last_names ?? '';
                    document.querySelector("#celDateCreated").innerHTML = employee.created_at ?? '';

                    let htmlWorkdays = "";

                    if(Array.isArray(workdays) && workdays.length > 0){
                        htmlWorkdays += `<table class="table table-sm table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Día</th>
                                                    <th>Entrada</th>
                                                    <th>Salida</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;

                        workdays.forEach(function(item){
                            htmlWorkdays += `
                                <tr>
                                    <td>${item.day_name ?? 'N/D'}</td>
                                    <td>${formatTime12(item.start_time) ?? ''}</td>
                                    <td>${formatTime12(item.end_time) ?? ''}</td>
                                </tr>
                            `;
                        });

                        htmlWorkdays += `</tbody></table>`;
                    } else {
                        htmlWorkdays = '<span>No tiene días laborables asignados.</span>';
                    }

                    document.querySelector("#celWorkdays").innerHTML = htmlWorkdays;

                    $('#modalViewEmployee').modal('show');
                }else{
                    Swal.fire({
                        title: "ERROR",
                        text: objData.msg,
                        icon: "error"
                    });
                }
            }else{
                Swal.fire({
                    title: "ERROR",
                    text: "No fue posible obtener los datos del empleado.",
                    icon: "error"
                });
            }
        }
    }
}

function formatTime12(time24){
    if(!time24) return '';

    let parts = time24.split(':');
    let hours = parseInt(parts[0], 10);
    let minutes = parts[1];
    let suffix = hours >= 12 ? 'PM' : 'AM';

    hours = hours % 12;
    hours = hours ? hours : 12;

    return `${String(hours).padStart(2, '0')}:${minutes} ${suffix}`;
}
function resetEmployeeForm(){
    document.querySelector('#formEmployee').reset();
    document.querySelector('#idEmployee').value = 0;

    document.querySelectorAll('input[name="workDays[]"]').forEach(item => {
        item.checked = false;
    });

    document.querySelectorAll('input[id^="startTime"]').forEach(item => {
        item.value = '';
    });

    document.querySelectorAll('input[id^="endTime"]').forEach(item => {
        item.value = '';
    });

    document.querySelector("#intOcupation").value = '0';

    if (typeof $ !== "undefined" && $('#intOcupation').hasClass('selectpicker')) {
        $('#intOcupation').selectpicker('refresh');
    }
}

function fntEditInfo(element, idEmployee){
    rowTable = element.closest("tr");

    document.querySelector('#titleModal').innerHTML = "ACTUALIZAR EMPLEADO";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";

    resetEmployeeForm();

    let ajaxUrl = base_url + '/Employees/getEmployee/' + idEmployee;
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');

    request.open("GET", ajaxUrl, true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4){
            if(request.status == 200){
                let objData = JSON.parse(request.responseText);

                if(objData.status){
                    let employee = objData.data.employee;
                    let workdays = objData.data.workdays;

                    document.querySelector("#idEmployee").value = employee.id_employee;
                    document.querySelector("#txtIdentification").value = employee.identification ?? '';
                    document.querySelector("#txtPassport").value = employee.passport ?? '';
                    document.querySelector("#txtName").value = employee.names ?? '';
                    document.querySelector("#txtLastName").value = employee.last_names ?? '';
                    document.querySelector("#intEmpType").value = employee.employee_type ?? '0';
                    $('#intOcupation').selectpicker('val', String(employee.ocupation_id));
                    $('#intOcupation').selectpicker('render');

                    if (typeof $ !== "undefined" && $('#intOcupation').hasClass('selectpicker')) {
                        $('#intOcupation').selectpicker('refresh');
                    }

                    if(Array.isArray(workdays)){
                        workdays.forEach(function(item){
                            let dayId = item.day_id;

                            let checkDay = document.querySelector(`#day${dayId}`);
                            let startInput = document.querySelector(`#startTime${dayId}`);
                            let endInput = document.querySelector(`#endTime${dayId}`);

                            if(checkDay) checkDay.checked = true;
                            if(startInput) startInput.value = formatTime12(item.start_time);
                            if(endInput) endInput.value = formatTime12(item.end_time);
                        });
                    }

                    $('#modalFormEmployee').modal('show');
                }else{
                    Swal.fire("Error", objData.msg, "error");
                }
            }else{
                Swal.fire("Error", "No fue posible obtener los datos del empleado.", "error");
            }
        }
    }
}

function resetEmployeeForm(){
    document.querySelector('#formEmployee').reset();
    document.querySelector('#idEmployee').value = 0;

    document.querySelectorAll('input[name="workDays[]"]').forEach(item => {
        item.checked = false;
    });

    document.querySelectorAll('input[id^="startTime"]').forEach(item => {
        item.value = '';
    });

    document.querySelectorAll('input[id^="endTime"]').forEach(item => {
        item.value = '';
    });

    document.querySelector("#intOcupation").value = '0';

    if (typeof $ !== "undefined" && $('#intOcupation').hasClass('selectpicker')) {
        $('#intOcupation').selectpicker('refresh');
    }
}

function formatTime12(time24){
    if(!time24) return '';

    let parts = time24.split(':');
    let hours = parseInt(parts[0], 10);
    let minutes = parts[1];
    let suffix = hours >= 12 ? 'PM' : 'AM';

    hours = hours % 12;
    hours = hours ? hours : 12;

    return `${String(hours).padStart(2, '0')}:${minutes} ${suffix}`;
}

function fntDelInfo(personid){
    Swal.fire({
        title: "ELIMINAR FAMILIAR",
        text: "¿Realmente quieres eliminar el familiar que has seleccionado?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#28a745",
        confirmButtonText: "<i class='fa-solid fa-trash'></i> Si, bórralo!",
        cancelButtonText: "<i class='fa-solid fa-floppy-disk'></i> No!",
    }).then((result) => {
        
        if (result.isConfirmed) 
        {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Families/delFamily';
            let strData = "idFamily="+personid;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        Swal.fire({
                          title: "Eliminado!",
                          text: objData.msg,
                          icon: "success"
                        });
                        tableEmployees.api().ajax.reload();
                    }else{
                        Swal.fire({
                          title: "Atención!",
                          text: objData.msg,
                          icon: "error"
                        });
                    }
                }
            }
        }

    });
}

function fntOcupations(){
    if(document.querySelector('#intOcupation')){
        let ajaxUrl = base_url + '/Ocupations/getSelectOcupations';

        fetch(ajaxUrl)
        .then(res => res.json())
        .then(objData => {
            let htmlOptions = `<option value="0">--Seleccione--</option>`;
            objData.forEach(item => {
                htmlOptions += `
                    <option value="${item.id_ocupation}">
                        ${item.ocupation}
                    </option>`;
            });

            let select = document.querySelector('#intOcupation');
            select.innerHTML = htmlOptions;

            // DESTRUIR Y REINICIALIZAR
            $('#intOcupation').selectpicker('destroy');
            $('#intOcupation').selectpicker();

        })
        .catch(err => console.error(err));
    }
}

function fntDays(){
    if(document.querySelector('#listDays')){
        let ajaxUrl = base_url + '/Days/getSelectDays';
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');

        request.open("GET", ajaxUrl, true);
        request.send();

        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                let objData = JSON.parse(request.responseText);
                let htmlOptions = '<div class="row">';

                objData.forEach(function(day){
                    htmlOptions += `
                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="border rounded p-2 h-100">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           id="day${day.id_day}" 
                                           name="workDays[]" 
                                           value="${day.id_day}">
                                    <label class="form-check-label font-weight-bold" for="day${day.id_day}">
                                        ${day.day}
                                    </label>
                                </div>

                                <div class="form-group">
                                    <label for="startTime${day.id_day}">Hora de inicio</label>
                                    <div class="input-group date" id="startimepicker${day.id_day}" data-target-input="nearest">
                                        <input type="text"
                                               class="form-control datetimepicker-input"
                                               data-target="#startimepicker${day.id_day}"
                                               data-toggle="datetimepicker"
                                               id="startTime${day.id_day}"
                                               name="startTime[${day.id_day}]"
                                               placeholder="00:00 AM" 
                                               autocomplete="new-password" 
                                               readonly />
                                        <div class="input-group-append" data-target="#startimepicker${day.id_day}" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="far fa-clock"></i></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-0">
                                    <label for="endTime${day.id_day}">Hora de fin</label>
                                    <div class="input-group date" id="endtimepicker${day.id_day}" data-target-input="nearest">
                                        <input type="text"
                                               class="form-control datetimepicker-input"
                                               data-target="#endtimepicker${day.id_day}"
                                               data-toggle="datetimepicker"
                                               id="endTime${day.id_day}"
                                               name="endTime[${day.id_day}]"
                                               placeholder="00:00 PM" 
                                               autocomplete="new-password" 
                                               readonly />
                                        <div class="input-group-append" data-target="#endtimepicker${day.id_day}" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="far fa-clock"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                });

                htmlOptions += '</div>';

                document.querySelector('#listDays').innerHTML = htmlOptions;

                objData.forEach(function(day){
                    $(`#startimepicker${day.id_day}`).datetimepicker({
                        format: 'LT'
                    });

                    $(`#endtimepicker${day.id_day}`).datetimepicker({
                        format: 'LT'
                    });
                });
            }
        }
    }
}

function openModal()
{
    rowTable = "";
    document.querySelector('#idEmployee').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "<i class='ion ion-person-add'></i> NUEVO EMPLEADO";
    document.querySelector("#formEmployee").reset();
    $('#modalFormEmployee').modal('show');
}

$('[data-mask]').inputmask();

//Timepicker
$('#startimepicker').datetimepicker({
    format: 'LT'
});

$('#endtimepicker').datetimepicker({
    format: 'LT'
});