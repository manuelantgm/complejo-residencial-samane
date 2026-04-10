let tableVisits; 
let rowTable = "";
let divLoading = document.querySelector("#divLoading");

document.addEventListener('DOMContentLoaded', function(){

    if (document.querySelector("#tableVisits")) {
        tableVisits = $('#tableVisits').DataTable({
            ordering:false,
            "aProcessing":true,
            "aServerSide":true,
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            },
            "ajax":{
                "url": base_url + "/Visits/getVisits",
                "dataSrc":""
            },
            "columns":[
                {
                    "data": null,
                    "render": function(data, type, row){
                        let btnEdit   = row.canEdit   ? `<button class="btn" onClick="fntEditInfo(this,${row.id_visit})"><i class="fa-solid fa-pen-to-square"></i> Editar</button>` : "";
                        let btnDelete = row.canDelete ? `<button class="btn" onClick="fntDelInfo(${row.id_visit})"><i class="far fa-trash-alt"></i> Eliminar</button>` : "";

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
                {"data":"names"},
                {"data":"last_names"},
                {"data":"identification"},
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

    if(document.querySelector("#formVisit")){
        let formVisit = document.querySelector("#formVisit");
        formVisit.onsubmit = function(e) {
            e.preventDefault();
            let intIdentification = document.querySelector('#txtIdentification').value;
            let strPassport= document.querySelector('#txtPassport').value;
            let strName = document.querySelector('#txtName').value;
            let strLastName = document.querySelector('#txtLastName').value;

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
            let ajaxUrl = base_url+'/Visits/upsertVisit'; 
            let formData = new FormData(formVisit);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        if(rowTable == ""){
                            tableVisits.ajax.reload();
                        }else{
                            rowTable.cells[1].textContent = strName;
                            rowTable.cells[2].textContent = strLastName;
                            rowTable = ""; 
                        }
                        $('#modalFormVisit').modal("hide");
                        formVisit.reset();
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

function fntEditInfo(element, idVisit){
    rowTable = element.closest("tr");

    document.querySelector('#titleModal').innerHTML = "ACTUALIZAR EMPLEADO";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";

    let ajaxUrl = base_url + '/Visits/getVisit/' + idVisit;
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');

    request.open("GET", ajaxUrl, true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4){
            if(request.status == 200){
                let objData = JSON.parse(request.responseText);

                if(objData.status){
                    let visit = objData.data.visit;

                    document.querySelector("#idVisit").value = visit.id_visit;
                    document.querySelector("#txtIdentification").value = visit.identification ?? '';
                    document.querySelector("#txtPassport").value = visit.passport ?? '';
                    document.querySelector("#txtName").value = visit.names ?? '';
                    document.querySelector("#txtLastName").value = visit.last_names ?? '';
                    $('#modalFormVisit').modal('show');
                }else{
                    Swal.fire("Error", objData.msg, "error");
                }
            }else{
                Swal.fire("Error", "No fue posible obtener los datos de la visita.", "error");
            }
        }
    }
}

function fntDelInfo(visitid){
    Swal.fire({
        title: "ELIMINAR VISITA",
        text: "¿Realmente quieres eliminar la visita que has seleccionado?",
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
            let ajaxUrl = base_url+'/Visits/delVisit';
            let strData = "idVisit="+visitid;
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
                        tableVisits.ajax.reload();
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
    document.querySelector('#idVisit').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "<i class='ion ion-person-add'></i> NUEVA VISITA";
    document.querySelector("#formVisit").reset();
    $('#modalFormVisit').modal('show');
}

$('[data-mask]').inputmask();