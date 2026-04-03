let tableFamilies; 
let rowTable = "";
let divLoading = document.querySelector("#divLoading");

document.addEventListener('DOMContentLoaded', function(){

    if (document.querySelector("#tableFamilies")) {
        tableFamilies = $('#tableFamilies').dataTable( {
            ordering:false,
            "aProcessing":true,
            "aServerSide":true,
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            },
            "ajax":{
                "url": " "+base_url+"/Families/getFamilies",
                "dataSrc":""
            },
            "columns":[
                {"data":"options"},
                {"data":"name"},
                {"data":"last_name"},
                {"data":"status"}
            ],
            "responsive": false,
            "bDestroy": true,
            "iDisplayLength": 10,
            "order":[[0,"desc"]]  
        });
    }

    if(document.querySelector("#formFamily")){
        let formFamily = document.querySelector("#formFamily");
        formFamily.onsubmit = function(e) {
            e.preventDefault();
            let intListAge = document.querySelector('#listAge').value;
            let intIdentification = document.querySelector('#txtIdentification').value;
            let strName = document.querySelector('#txtName').value;
            let strLastName = document.querySelector('#txtLastName').value;
            let strRelationship = document.querySelector('#txtRelationship').value;
            let intPhone = document.querySelector('#intPhone').value;
            let intStreet = document.querySelector('#listStreetId').value;
            let intNumber = document.querySelector('#intNumber').value;
            let strEmail = document.querySelector('#txtEmail').value;
            let strPassword = document.querySelector('#txtPassword').value;

            // VALIDATIONS
            if(intListAge == '' || intListAge == 0){
                Swal.fire({
                  title: "Atención!",
                  text: "Por favor indique si su familiar es menor o mayor de edad.",
                  icon: "info"
                });
                return false;
            }

            if(intListAge == 1 && intIdentification == ''){
                Swal.fire({
                  title: "Atención!",
                  text: "Por favor indique la identificacion del familiar.",
                  icon: "info"
                });
                return false;
            }

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

            if(strRelationship.trim() == ''){
                Swal.fire({
                  title: "Atención!",
                  text: "Debe indicar el parentesco, Los campos con asterisco * son requeridos.",
                  icon: "info"
                });
                return false;
            }

            if(intStreet == '' || intStreet == 0){
                Swal.fire({
                  title: "Atención!",
                  text: "Debe seleccionar una calle, Los campos con asterisco * son requeridos.",
                  icon: "info"
                });
                return false;
            }

            if(intNumber.trim() == ''){
                Swal.fire({
                  title: "Atención!",
                  text: "Debe ingresar el número de la vivienda, Los campos con asterisco * son requeridos.",
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
            let ajaxUrl = base_url+'/Families/setFamily'; 
            let formData = new FormData(formFamily);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        if(rowTable == ""){
                            tableFamilies.api().ajax.reload();
                        }else{
                            rowTable.cells[1].textContent = strName;
                            rowTable.cells[2].textContent = strLastName;
                            rowTable = ""; 
                        }
                        $('#modalFormFamily').modal("hide");
                        formFamily.reset();
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
        fntCalles();
}, false);

function fntViewInfo(idpersona){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Families/getPropietario/'+idpersona;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                document.querySelector("#celIdentificacion").innerHTML = objData.data.identificacion;
                document.querySelector("#celNombre").innerHTML = objData.data.nombres;
                document.querySelector("#celApellido").innerHTML = objData.data.apellidos;
                document.querySelector("#celTelefono").innerHTML = objData.data.telefono;
                document.querySelector("#celEmail").innerHTML = objData.data.email_user;
                document.querySelector("#celIde").innerHTML = objData.data.nit;
                document.querySelector("#celNomFiscal").innerHTML = objData.data.nombrefiscal;
                document.querySelector("#celDirFiscal").innerHTML = objData.data.direccionfiscal;
                document.querySelector("#celFechaRegistro").innerHTML = objData.data.fechaRegistro; 
                $('#modalViewCliente').modal('show');
            }else{
                Swal.fire({
                  title: "ERROR",
                  text: objData.msg,
                  icon: "error"
                });
            }
        }
    }
}

function fntEditInfo(element, idperson){
    rowTable = element.parentNode.parentNode.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML ="ACTUALIZAR FAMILIA";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Families/getFamily/'+idperson;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){

        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                document.querySelector("#idFamily").value = objData.data.id_person;
                document.querySelector("#listAge").value =objData.data.legal_age;
                $('#listAge').selectpicker('render');
                document.querySelector("#txtIdentification").value = objData.data.identification;
                document.querySelector("#txtName").value = objData.data.name;
                document.querySelector("#txtLastName").value = objData.data.last_name;
                document.querySelector("#txtRelationship").value = objData.data.relationship;
                document.querySelector("#intPhone").value =objData.data.phone;
                document.querySelector("#listStreetId").value =objData.data.street_id;
                $('#listStreetId').selectpicker('render');
                document.querySelector("#intNumber").value =objData.data.home_number;
                document.querySelector("#txtEmail").value =objData.data.email;
            }
        }
        $('#modalFormFamily').modal('show');
    }
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
                        tableFamilies.api().ajax.reload();
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

function fntCalles(){
    if(document.querySelector('#listStreetId')){
        let ajaxUrl = base_url+'/Streets/getSelectStreet';
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                document.querySelector('#listStreetId').innerHTML = request.responseText;
                $('#listStreetId').selectpicker('render');
            }
        }
    }
}

function openModal()
{
    rowTable = "";
    document.querySelector('#idFamily').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "<i class='ion ion-person-add'></i> NUEVO FAMILIAR";
    document.querySelector("#formFamily").reset();
    $('#modalFormFamily').modal('show');
}

$('[data-mask]').inputmask();