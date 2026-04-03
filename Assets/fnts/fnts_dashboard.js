let tableRecibos;
let rowTable = "";
let divLoading = document.querySelector("#divLoading");
let Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});
let f_US = new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD',
});
$(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
});
document.addEventListener('DOMContentLoaded', function(){
   //NUEVA FACTURA
    if(document.querySelector("#formFactura")){
        let formFactura = document.querySelector("#formFactura");
        formFactura.onsubmit = function(e) {
            e.preventDefault();
            let intIdFactura = document.querySelector('#idFactura').value;
            let intPropietarioId = document.querySelector('#listPropietarioId').value;
            let strFechaI = document.querySelector('#txtFechaI').value;
            let strFechaF = document.querySelector('#txtFechaF').value;

            if(intPropietarioId == '' || strFechaI == '' || strFechaF == '')
            {
                Swal.fire({
                  title: "Atención!",
                  text: "Los campos con (*) son obligatorios.",
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
            let ajaxUrl = base_url+'/Factura/setFactura'; 
            let formData = new FormData(formFactura);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        Swal.fire({
                          title: objData.title,
                          text: objData.msg,
                          icon: objData.icon
                        });
                    }else{
                        Swal.fire({
                          title: objData.title,
                          text: objData.msg,
                          icon: objData.icon
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
    fntPropietarios();
}, false);

if(document.querySelector(".btnMantenance")){
   let btnMantenance =  document.querySelector(".btnMantenance");
   btnMantenance.onclick = function(e){
        toastWarning();
   }
}

$('[data-toggle="tooltip"]').tooltip();

function fntPropietarios(){
    let ajaxUrl = base_url+'/Propietarios/getSelectPropietarios';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){

            if(document.querySelector('#listPropietarioId')){
                document.querySelector('#listPropietarioId').innerHTML = request.responseText;
                $('#listPropietarioId').selectpicker('render');
            }
            if(document.querySelector('.listPersonaId')){
                document.querySelector('.listPersonaId').innerHTML = request.responseText;
                $('.listPersonaId').selectpicker('render');
            }
            if(document.querySelector('#personIdNullFact')){
                document.querySelector('#personIdNullFact').innerHTML = request.responseText;
                $('#personIdNullFact').selectpicker('render');
            }

        }
    }
}