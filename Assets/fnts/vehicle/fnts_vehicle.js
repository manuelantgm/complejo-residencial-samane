let tableVehicles; 
let rowTable = "";
let divLoading = document.querySelector("#divLoading");

document.addEventListener('DOMContentLoaded', function(){

    if (document.querySelector("#tableVehicles")) {
        tableVehicles = $('#tableVehicles').DataTable({
            ordering:false,
            "aProcessing":true,
            "aServerSide":true,
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            },
            "ajax":{
                "url": base_url + "/Vehicles/getVehicles",
                "dataSrc":""
            },
            "columns":[
                {
                    "data": null,
                    "render": function(data, type, row){
                        let btnEdit   = row.canEdit   ? `<button class="btn" onClick="fntEditInfo(this,${row.id_vehicle})"><i class="fa-solid fa-pen-to-square"></i> Editar</button>` : "";
                        let btnDelete = row.canDelete ? `<button class="btn" onClick="fntDelInfo(${row.id_vehicle})"><i class="far fa-trash-alt"></i> Eliminar</button>` : "";

                        return `
                            <div class="btn-group pull-right">
                                <button type="button" class="btn btn-sm dropdown-toggle bg-info" data-toggle="dropdown">
                                    <i class="fa-solid fa-gear"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>${btnEdit}</li>
                                    <li>${btnDelete}</li>
                                </ul>
                            </div>`;
                    }
                },
                {"data":"mark"},
                {"data":"model"},
                {"data":"color"},
                {"data":"year"},
                {"data":"plate"},
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

    if(document.querySelector("#formVehicle")){
        let formVehicle = document.querySelector("#formVehicle");
        formVehicle.onsubmit = function(e) {
            e.preventDefault();
            let strMark = document.querySelector('#txtMark').value;
            let strModel= document.querySelector('#txtModel').value;
            let strColor = document.querySelector('#txtColor').value;
            let strYear = document.querySelector('#txtYear').value;
            let strPlate = document.querySelector('#txtPlate').value;

            // VALIDATIONS
            if(strMark.trim() == ''){
                Swal.fire({
                  title: "Atención!",
                  text: "Debe ingresar la marca, Los campos con asterisco * son requeridos.",
                  icon: "info"
                });
                return false;
            }

            if(strModel.trim() == ''){
                Swal.fire({
                  title: "Atención!",
                  text: "Debe ingresar el modelo, Los campos con asterisco * son requeridos.",
                  icon: "info"
                });
                return false;
            }

            if(strColor.trim() == ''){
                Swal.fire({
                  title: "Atención!",
                  text: "Debe ingresar el color, Los campos con asterisco * son requeridos.",
                  icon: "info"
                });
                return false;
            }

            if(strYear.trim() == ''){
                Swal.fire({
                  title: "Atención!",
                  text: "Debe ingresar el año, Los campos con asterisco * son requeridos.",
                  icon: "info"
                });
                return false;
            }

            if(strPlate.trim() == ''){
                Swal.fire({
                  title: "Atención!",
                  text: "Debe ingresar la placa, Los campos con asterisco * son requeridos.",
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
            let ajaxUrl = base_url+'/Vehicles/upsertVehicle'; 
            let formData = new FormData(formVehicle);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        if(rowTable == ""){
                            tableVehicles.ajax.reload();
                        }else{
                            rowTable.cells[1].textContent = strMark;
                            rowTable.cells[2].textContent = strModel;
                            rowTable.cells[3].textContent = strColor;
                            rowTable.cells[4].textContent = strYear;
                            rowTable.cells[5].textContent = strPlate;
                            rowTable = ""; 
                        }
                        $('#modalFormVehicle').modal("hide");
                        formVehicle.reset();
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
    
}, false);

function fntEditInfo(element, idvehicle){
    rowTable = element.closest("tr");

    document.querySelector('#titleModal').innerHTML = "<i class='fa-solid fa-pen-to-square'></i> ACTUALIZAR VEHICULO";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";

    let ajaxUrl = base_url + '/Vehicles/getVehicle/' + idvehicle;
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');

    request.open("GET", ajaxUrl, true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4){
            if(request.status == 200){
                let objData = JSON.parse(request.responseText);

                if(objData.status){
                    let vehicle = objData.data.vehicle;

                    document.querySelector("#idVehicle").value = vehicle.id_vehicle;
                    document.querySelector("#txtMark").value = vehicle.mark ?? '';
                    document.querySelector("#txtModel").value = vehicle.model ?? '';
                    document.querySelector("#txtColor").value = vehicle.color ?? '';
                    document.querySelector("#txtYear").value = vehicle.year ?? '';
                    document.querySelector("#txtPlate").value = vehicle.plate ?? '';
                    $('#modalFormVehicle').modal('show');
                }else{
                    Swal.fire("Error", objData.msg, "error");
                }
            }else{
                Swal.fire("Error", "No fue posible obtener los datos del vehiculo.", "error");
            }
        }
    }
}

function fntDelInfo(vehicleid){
    Swal.fire({
        title: "ELIMINAR VEHICULO",
        text: "¿Realmente quieres eliminar el vehiculo que has seleccionado?",
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
            let ajaxUrl = base_url+'/Vehicles/delVehicle';
            let strData = "idVehicle="+vehicleid;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    console.log(request.responseText);
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        Swal.fire({
                          title: "Eliminado!",
                          text: objData.msg,
                          icon: "success"
                        });
                        tableVehicles.ajax.reload();
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

function openModal()
{
    rowTable = "";
    document.querySelector('#idVehicle').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "<i class='fa-solid fa-car'></i> NUEVO VEHICULO";
    document.querySelector("#formVehicle").reset();
    $('#modalFormVehicle').modal('show');
}

$('[data-mask]').inputmask();